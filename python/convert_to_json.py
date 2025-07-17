import re
from datetime import datetime
from pymongo import MongoClient

# Konfigurasi koneksi MongoDB
client = MongoClient("mongodb://admin:admin9876@165.22.61.209:27017/")
db = client["wazuh_audit"]
collection = db["alerts"]

# Fungsi untuk parsing satu baris log
def parse_log_line(line, source):
    pattern = r"^(\w{3})\s+(\d{1,2})\s([\d:]{8})\s([\w\-.]+)\s([\w\-/]+)(?:\[(\d+)\])?:\s(.+)$"
    match = re.match(pattern, line)
    if match:
        month, day, time, host, process, pid, message = match.groups()
        try:
            current_year = datetime.now().year
            timestamp = datetime.strptime(f"{current_year} {month} {day} {time}", "%Y %b %d %H:%M:%S")
        except ValueError:
            timestamp = None

        return {
            "timestamp": timestamp,
            "source": source,
            "month": month,
            "day": int(day),
            "time": time,
            "host": host,
            "process": process,
            "pid": int(pid) if pid else None,
            "message": message,
            "raw": line.strip()
        }
    return {
        "raw": line.strip(),
        "source": source,
        "parse_error": True
    }

# Fungsi untuk membaca file log dan insert ke MongoDB
def insert_log_file(filepath, source):
    count = 0
    with open(filepath, "r", encoding="utf-8", errors="ignore") as f:
        for line in f:
            if line.strip():
                parsed = parse_log_line(line, source)
                collection.insert_one(parsed)
                count += 1
    print(f"[✓] {count} baris dari '{source}' berhasil dimasukkan ke koleksi 'alerts'.")

# Eksekusi utama
if __name__ == "__main__":
    insert_log_file("data/auth.log", "auth")
    insert_log_file("data/syslog", "syslog")