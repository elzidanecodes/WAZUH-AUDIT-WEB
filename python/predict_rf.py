import pandas as pd
import joblib
from pymongo import MongoClient
from datetime import datetime

# === 1. Load model ===
model = joblib.load('./outputs/model_rf.pkl')

# === 2. Load data log CSV ===
df = pd.read_csv('../storage/app/python/inputs/uploaded.csv')

# === 3. Gabungkan field untuk prediksi ===
df['combined'] = df['description'].fillna('') + ' ' + df['decoder'].fillna('')

# === 4. Prediksi ===
df['predicted_label'] = model.predict(df['combined'])

# === 5. Tambahkan kolom penanda batch upload
upload_time = datetime.now().strftime('%Y%m%d_%H%M%S')
df['source'] = f"upload_{upload_time}"

# === 6. Ambil kolom yang disimpan
hasil = df[['timestamp', 'description', 'decoder', 'predicted_label', 'source']]

# === 6. Format timestamp (opsional)
# df['timestamp'] = pd.to_datetime(df['timestamp']) # jika perlu

# === 7. Simpan ke MongoDB TANPA menghapus data lama
client = MongoClient('mongodb://admin:admin9876@139.59.123.110:27017/')
db = client['wazuh_audit']
collection = db['predicted_logs']

# Insert sebagai batch
collection.insert_many(hasil.to_dict(orient='records'))

print("Prediksi selesai dan data baru ditambahkan ke MongoDB")