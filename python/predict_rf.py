import pandas as pd
import joblib
import os
from pymongo import MongoClient, errors
from datetime import datetime, timezone
import hashlib

def generate_hash_key(record):
    """Generate hash berdasarkan timestamp dan description (lowercase, strip)."""
    ts = record['timestamp'].isoformat() if isinstance(record['timestamp'], datetime) else str(record['timestamp'])
    desc = record['description'].strip().lower()
    return hashlib.md5(f"{ts}_{desc}".encode()).hexdigest()

def main():
    BASE_DIR = os.path.dirname(os.path.abspath(__file__))
    client = None

    try:
        print("🚀 Mulai proses prediksi dan insert MongoDB...")
        
        # === 1. Load model ===
        model_path = os.path.join(BASE_DIR, 'outputs/model_rf.pkl')
        if not os.path.exists(model_path):
            raise FileNotFoundError("❌ Model file tidak ditemukan di outputs/model_rf.pkl")
        model = joblib.load(model_path)

        # === 2. Load CSV ===
        csv_path = os.path.abspath(os.path.join(BASE_DIR, '../storage/app/python/outputs/alerts_for_labeling.csv'))
        if not os.path.exists(csv_path):
            raise FileNotFoundError(f"❌ CSV tidak ditemukan: {csv_path}")
        df = pd.read_csv(csv_path)
        print(f"📄 Loaded {len(df)} baris dari file CSV")

        # === 3. Timestamp conversion ===
        current_year = datetime.now().year
        df['timestamp'] = df['timestamp'].apply(
            lambda x: pd.to_datetime(f"{current_year} {x}", format='%Y %b %d %H:%M:%S', errors='coerce')
        )
        df = df.dropna(subset=['timestamp'])
        df['timestamp'] = df['timestamp'].apply(lambda x: x.replace(microsecond=0))
        if df.empty:
            raise ValueError("⛔ Tidak ada data valid setelah parsing timestamp")

        # === 4. Prediksi dan feature engineering ===
        df['combined'] = df['description'].fillna('') + ' ' + df['decoder'].fillna('')
        df['predicted_label'] = [str(label).lower().replace(' ', '_') for label in model.predict(df['combined'])]
        upload_time = datetime.now(timezone.utc)
        df['source'] = f"upload_{upload_time.strftime('%Y%m%d_%H%M%S')}"

        # === 5. Konversi ke dict dan generate hash_key ===
        records = df[['timestamp', 'description', 'decoder', 'predicted_label', 'source']].to_dict('records')
        for record in records:
            if isinstance(record['timestamp'], pd.Timestamp):
                record['timestamp'] = record['timestamp'].to_pydatetime()
            record['hash_key'] = generate_hash_key(record)

        # === 6. Koneksi MongoDB ===
        client = MongoClient('mongodb://admin:admin9876@165.22.61.209:27017/')
        db = client['wazuh_audit']
        collection = db['predicted_logs']

        # Buat index unik untuk hash_key (jika belum ada)
        try:
            collection.create_index('hash_key', unique=True)
        except errors.OperationFailure:
            pass  # Sudah ada

        # === 7. Ambil hash_key yang sudah ada
        incoming_hashes = set(r['hash_key'] for r in records)
        existing_hashes = set(doc['hash_key'] for doc in collection.find(
            {'hash_key': {'$in': list(incoming_hashes)}},
            {'hash_key': 1}
        ))
        filtered_records = [r for r in records if r['hash_key'] not in existing_hashes]

        # === 8. Insert data baru
        if filtered_records:
            result = collection.insert_many(filtered_records, ordered=False)
            print(f"✅ Inserted {len(result.inserted_ids)} dari {len(records)} total records.")
        else:
            print("ℹ️ Semua data sudah ada di database. Tidak ada yang diinsert.")

    except Exception as e:
        print(f"❌ Error: {e}")
    finally:
        if client:
            client.close()
            print("🔒 Koneksi MongoDB ditutup.")

if __name__ == "__main__":
    main()