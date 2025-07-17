import os
BASE_STORAGE = os.path.abspath(os.path.join(os.path.dirname(__file__), '../storage/app/python'))

auth_path = os.path.join(BASE_STORAGE, 'data', 'auth.log')
syslog_path = os.path.join(BASE_STORAGE, 'data', 'syslog')

print("auth.log Path:", auth_path)
print("syslog Path:", syslog_path)