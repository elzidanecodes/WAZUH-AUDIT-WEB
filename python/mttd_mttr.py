from pymongo import MongoClient
import pandas as pd
from datetime import datetime

# Koneksi MongoDB (ganti jika perlu)
client = MongoClient("mongodb://admin:admin9876@139.59.123.110:27017/")
db = client["wazuh_audit"]
collection = db["predicted_logs"]

# Ambil data dari MongoDB
data = list(collection.find())
df = pd.DataFrame(data)

# Pastikan kolom yang dibutuhkan ada
if 'timestamp' not in df.columns or 'predicted_label' not in df.columns:
    raise ValueError("Kolom 'timestamp' dan 'predicted_label' wajib ada.")

# Format timestamp dan urutkan
df['timestamp'] = pd.to_datetime(df['timestamp'], errors='coerce', format='%b %d %H:%M:%S')
df = df.dropna(subset=['timestamp'])

# Variabel bantu
deteksi_times = []
respon_times = []
in_attack = False
serangan_start = None
deteksi_time = None

# Hitung MTTD & MTTR
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

# Rata-rata
rata_mttd = sum(deteksi_times) / len(deteksi_times) if deteksi_times else 0
rata_mttr = sum(respon_times) / len(respon_times) if respon_times else 0

# Simpan ke MongoDB
stat_collection = db["statistics"]
stat_collection.delete_many({})
stat_collection.insert_one({
    "mttd_menit": round(rata_mttd, 2),
    "mttr_menit": round(rata_mttr, 2),
    "total_event": len(df),
    "dihitung_pada": datetime.now()
})

print("MTTD dan MTTR berhasil dihitung dan disimpan.")