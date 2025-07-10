import re
import pandas as pd

def extract_entries(file_path):
    with open(file_path, 'r') as f:
        lines = f.readlines()

    data = []
    for line in lines:
        match = re.search(r'(\w{3}\s+\d+\s[\d:]+)\s.*?(sshd|systemd|kernel|ufw|suricata|iptables).*?:\s(.+)', line)
        if match:
            timestamp, decoder, message = match.groups()
            message_lower = message.lower()

            # Auto label
            if any(x in message_lower for x in ['authentication failed', 'invalid user']):
                label = 'brute_force'
            elif any(x in message_lower for x in ['flood', 'traffic', 'dos']):
                label = 'ddos'
            else:
                label = 'normal'

            data.append({
                'timestamp': timestamp,
                'decoder': decoder.lower(),
                'description': message,
                'label': label
            })

    return pd.DataFrame(data)

df_auth = extract_entries('data/auth.log')
df_syslog = extract_entries('data/syslog')
df = pd.concat([df_auth, df_syslog], ignore_index=True)
df.to_csv('outputs/alerts_for_labeling.csv', index=False)
print("✅ Brhasil Eksport ke CSV")
