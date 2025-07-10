import pandas as pd
import joblib
import json

# Load model
model = joblib.load('./outputs/model_rf.pkl')

# Load log baru
df = pd.read_csv('./outputs/alerts_for_labeling.csv')  # Ganti dengan file log yang kamu punya

# Gabungkan teks untuk prediksi
df['combined'] = df['description'].fillna('') + ' ' + df['decoder'].fillna('')

# Prediksi
df['predicted_label'] = model.predict(df['combined'])

# Ambil kolom penting saja
hasil = df[['timestamp', 'description', 'decoder', 'predicted_label']]

# Simpan ke file JSON (untuk dimasukkan ke MongoDB)
hasil.to_json('./outputs/predicted_logs.json', orient='records', lines=True)

print("Prediksi selesai. Output JSON disimpan di: predicted_logs.json")
