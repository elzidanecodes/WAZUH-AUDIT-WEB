<p align="center">
    <img src="public/logo.png" alt="Logo/Preview Aplikasi" width="180"/>
</p>

<h1 align="center">WAZUDIT — Cyber Attack Detection & Audit Platform</h1>

<p align="center">
    Dibangun oleh <b>Laita Zidan</b>. Sistem ini mengintegrasikan <b>Wazuh SIEM</b>, 
    <b>Machine Learning (Random Forest)</b>, notifikasi <b>Telegram</b>, serta 
    perhitungan metrik <b>MTTD</b> & <b>MTTR</b> melalui dashboard modern berbasis Laravel + MongoDB.
</p>

---

## 🎯 Tujuan Sistem

- Mengumpulkan, menormalkan, dan menampilkan log keamanan untuk audit.
- Memprediksi kategori insiden (DDoS, Brute Force, Normal) menggunakan model **Random Forest**.
- Menghitung metrik operasional keamanan: **MTTD** (Mean Time To Detect) & **MTTR** (Mean Time To Respond).
- Menyediakan **dashboard monitoring & audit** yang interaktif, dengan laporan siap unduh (CSV/PDF).
- Mengirim **notifikasi Telegram** untuk respons cepat terhadap insiden.

---

## 🧠 Teknologi yang Digunakan

| Komponen                  | Fungsi                                                          |
| ------------------------- | --------------------------------------------------------------- |
| **Wazuh Manager + Agent** | SIEM untuk mengumpulkan dan mendeteksi log serangan             |
| **Laravel 11 + Vite**     | Aplikasi web, routing, jobs/queue, scheduler                    |
| **Blade + Alpine.js**     | UI dashboard, tabel, form                                       |
| **TailwindCSS + Flowbite**| Styling dan komponen UI                                         |
| **ApexCharts**            | Grafik tren & pie chart di dashboard                            |
| **MongoDB**               | Penyimpanan koleksi `alerts` dan `predicted_logs`               |
| **MySQL**                 | Backend queue untuk job antrian Laravel                         |
| **Symfony Process**       | Menjalankan skrip Python dari job Laravel                       |
| **Python (scikit-learn)** | Model Random Forest untuk klasifikasi log & perhitungan metrik  |
| **Monolog**               | Logging proses, termasuk output skrip Python                    |
| **Telegram Bot API**      | Notifikasi otomatis insiden                                     |

---

## 🧩 Struktur Direktori

```
wazudit/
├── app/
│   ├── Http/Controllers/      # Dashboard, Log, Reports
│   ├── Jobs/                  # ConvertLogToCsv, PredictLogLabels, MttdMttr
│   └── Models/                # Alert, PredictedLog, Statistics
├── python/                    # Skrip ML & util (predict_rf.py, mttd_mttr.py, dll.)
│   └── outputs/               # Model & hasil prediksi
├── resources/views/           # Blade: dashboard, reports, historis
├── public/                    # Asset build & logo
├── routes/                    # web.php, console.php, auth.php
├── storage/app/python/        # Tempat file upload (auth.log, syslog)
├── config/                    # database.php (MongoDB), queue.php
├── docs/screenshots/          # Gambar dokumentasi (hero, dashboard, reports, historis)
└── README.md
```

---

## 🔄 Alur Sistem (High-Level)

1. **Wazuh Agent** mengirimkan log insiden → **Wazuh Manager**.
2. Log diekstrak dari `auth.log` & `syslog`, diproses oleh Laravel job `ConvertLogToCsv`.
3. **Random Forest (Python)** memprediksi label insiden: DDoS / Brute Force / Normal.
4. Hasil prediksi disimpan di MongoDB (`predicted_logs`).
5. Job `MttdMttr` menghitung metrik keamanan → disimpan di koleksi `statistics`.
6. **Laravel Dashboard** menampilkan grafik tren, pie chart, log historis, serta laporan.
7. **Telegram Bot** mengirim notifikasi insiden secara otomatis.

---

## ⚙️ Konfigurasi .env (contoh minimal)

```
APP_NAME="WAZUDIT"
APP_ENV=local
APP_URL=http://127.0.0.1:8000

# MongoDB (utama)
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=wazuh_audit
DB_USERNAME=
DB_PASSWORD=

# Queue database (lihat config/queue.php)
QUEUE_CONNECTION=database
DB_QUEUE_CONNECTION=mysql
DB_QUEUE_TABLE=jobs

# SQLite bawaan (opsional)
DB_DATABASE_CLI=database/database.sqlite
```

---

## 🚀 Cara Menjalankan (Windows PowerShell)

Prasyarat: PHP 8.2+, Composer, Node.js 18+, MongoDB aktif, Python 3.10+, pip.

```powershell
# 1) Pindah ke folder proyek
cd d:\Project\Laravel\wazudit

# 2) Instal dependensi PHP
composer install

# 3) Salin .env dan generate APP_KEY
copy .env.example .env
php artisan key:generate

# 4) Siapkan database
php artisan migrate --force

# 5) Link storage
php artisan storage:link

# 6) Instal dependensi frontend & jalankan dev server
npm install
npm run dev

# 7) Siapkan Python env & paket
python -m venv .venv ; .\.venv\Scripts\Activate.ps1 ; pip install -r python\requirement.txt

# 8) Jalankan server Laravel
php artisan serve

# 9) Jalankan worker (terminal terpisah)
php artisan queue:work
```

---

<!-- ## 🖼️ Screenshot

- `docs/screenshots/hero.png`
- `docs/screenshots/01-dashboard.png`
- `docs/screenshots/02-historis.png`
- `docs/screenshots/03-reports.png`

Contoh:

<p align="center">
    <img src="docs/screenshots/01-dashboard.png" alt="Dashboard" width="800"/>
</p>

--- -->

## 👮 Role & Akses

Hanya tersedia satu role: Admin (semua tugas digabung).

| Role  | Fitur Utama |
| ----- | ----------- |
| Admin | Upload log, jalankan pipeline prediksi, lihat dashboard & reports, unduh CSV/PDF, tinjau hasil prediksi, pencarian & filter, arsip laporan, monitoring & audit penuh, notifikasi Telegram, manajemen pengguna |

---

## ✅ Catatan & Praktik Baik

- Pastikan MongoDB aktif dan kredensial sesuai `.env`.  
- Jalankan `queue:work` agar job Python tereksekusi.  
- Periksa `storage/logs/laravel.log` untuk output Python (via Symfony Process).  
- Gunakan environment Python terisolasi (`.venv`) + paket dari `python/requirement.txt`.  
- Notifikasi Telegram opsional bisa diaktifkan lewat Bot API.  

---

## 📜 Lisensi

&copy; 2025 Laita Zidan Dirilis dengan [Lisensi MIT](LICENSE)
---

## 🙋 Tentang Pengembang

**Laita Zidan**  
GitHub: [github.com/elzidanecodes](https://github.com/elzidanecodes)
