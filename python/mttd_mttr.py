from pymongo import MongoClient
import pandas as pd
from datetime import datetime
import os

def hitung_mttd_mttr():
    try:
        # Koneksi MongoDB dari ENV atau fallback
        mongo_uri = os.getenv("MONGO_URI", "mongodb://admin:admin9876@165.22.61.209:27017/")
        client = MongoClient(mongo_uri)
        db = client["wazuh_audit"]
        collection = db["predicted_logs"]

        # Ambil data dan validasi
        data = list(collection.find())
        if not data:
            print("Data kosong, tidak ada log untuk dihitung.")
            return {"mttd": 0, "mttr": 0, "total_event": 0}

        df = pd.DataFrame(data)
        if 'timestamp' not in df or 'predicted_label' not in df:
            raise ValueError("Kolom 'timestamp' dan 'predicted_label' wajib ada.")

        # Konversi timestamp
        df['timestamp'] = pd.to_datetime(df['timestamp'], errors='coerce')
        df = df.dropna(subset=['timestamp']).sort_values(by='timestamp')

        # Hitung MTTD dan MTTR
        deteksi_times, respon_times = [], []
        in_attack = False
        serangan_start = None
        deteksi_time = None

        for _, row in df.iterrows():
            label = row['predicted_label']
            waktu = row['timestamp']

            if label in ['brute_force', 'ddos']:
                if not in_attack:
                    serangan_start = waktu
                    in_attack = True
                deteksi_time = waktu
            elif label == 'normal' and in_attack:
                waktu_normal = waktu
                mttd = (deteksi_time - serangan_start).total_seconds() / 60
                mttr = (waktu_normal - deteksi_time).total_seconds() / 60
                deteksi_times.append(mttd)
                respon_times.append(mttr)
                in_attack = False

        rata_mttd = sum(deteksi_times) / len(deteksi_times) if deteksi_times else 0
        rata_mttr = sum(respon_times) / len(respon_times) if respon_times else 0

        # Simpan ke DB
        stat_collection = db["statistics"]
        stat_collection.delete_many({})
        stat_collection.insert_one({
            "mttd_menit": round(rata_mttd, 2),
            "mttr_menit": round(rata_mttr, 2),
            "total_event": len(df),
            "dihitung_pada": datetime.now()
        })

        print("MTTD dan MTTR berhasil dihitung dan disimpan.")
        return {
            "mttd": round(rata_mttd, 2),
            "mttr": round(rata_mttr, 2),
            "total_event": len(df)
        }

    except Exception as e:
        print("Error:", e)
        return {"mttd": 0, "mttr": 0, "total_event": 0}

if __name__ == "__main__":
    hitung_mttd_mttr()