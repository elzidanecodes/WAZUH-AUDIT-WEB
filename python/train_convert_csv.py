import re
import os
import pandas as pd

def extract_entries(file_path):
    with open(file_path, 'r') as f:
        lines = f.readlines()

    data = []

    brute_force_keywords = [
        "Failed password",
        "authentication failure",
        "Invalid user",
        "error: maximum authentication attempts exceeded"
    ]

    ddos_keywords = [
        "query (cache)",
        "client",
        "denied (allow-query-cache did not match)",
        "UFW BLOCK",
        "SYN",
        "PROTO=TCP",
        "connection attempt",
        "syn flood",
        "connection refused",
        "connection reset by peer",
        "rate limit exceeded",
        "exceeded the maximum number of connections"
    ]

    for line in lines:
        match = re.search(r'(\w{3}\s+\d+\s[\d:]+)\s.*?(sshd|systemd|kernel|ufw|suricata|iptables).*?:\s(.+)', line)
        if match:
            timestamp, decoder, message = match.groups()
            message_lower = message.lower()

            if any(keyword.lower() in message_lower for keyword in brute_force_keywords):
                label = "Brute Force"
            elif any(keyword.lower() in message_lower for keyword in ddos_keywords):
                label = "DDoS"
            else:
                label = "Normal"

            data.append({
                'timestamp': timestamp,
                'decoder': decoder.lower(),
                'description': message,
                'label': label
            })

    return pd.DataFrame(data)

# Ganti path ke folder python/data relatif terhadap file ini
BASE_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), 'data'))

try:
    # Ambil file log dari folder python/data/
    auth_path = os.path.join(BASE_DIR, 'auth.log')
    syslog_path = os.path.join(BASE_DIR, 'syslog')
    syslog_path = os.path.join(BASE_DIR, 'syslog2')

    df_auth = extract_entries(auth_path)
    df_syslog = extract_entries(syslog_path)

    # Gabungkan dan reset index
    df = pd.concat([df_auth, df_syslog], ignore_index=True)

    # Simpan ke folder python/outputs/
    OUTPUT_DIR = os.path.abspath(os.path.join(os.path.dirname(__file__), 'outputs'))
    os.makedirs(OUTPUT_DIR, exist_ok=True)

    output_file = os.path.join(OUTPUT_DIR, 'alerts_for_labeling.csv')
    df.to_csv(output_file, index=False)

    print(f"✅ Berhasil ekspor ke CSV: {output_file}")

except Exception as e:
    print("❌ Error:", e)
    raise