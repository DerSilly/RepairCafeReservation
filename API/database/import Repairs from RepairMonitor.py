# Import Repairmonitor data with this script as it is much faster than using laravel commands
import pandas as pd
import sqlite3
import requests
from io import BytesIO
import os

conn = sqlite3.connect('./API/database/repaircafe.sqlite')

# Fetch column names from the 'repairs' table
cursor = conn.execute('SELECT * FROM repairs LIMIT 0')
conn.execute('DELETE FROM repairs')
column_names = [description[0] for description in cursor.description if description[0] != 'id']
yourLanguage = "de"

# === Read Records from your country in your language ===
response = requests.get(f'https://dashboard.repairmonitor.org/data/sheets/repairs-{yourLanguage}.xlsx')
df = pd.read_excel(BytesIO(response.content))
df.columns = column_names
df = df[df['country'] == yourLanguage.upper()]
df.to_sql('repairs', conn, if_exists='append', index=False, method='multi', chunksize=1000)
# ========================================================

# === Now read all records except your country in your language ===
response = requests.get('https://dashboard.repairmonitor.org/data/sheets/repairs-en.xlsx')
df = pd.read_excel(BytesIO(response.content))
df.columns = column_names
df = df[df['country'] != yourLanguage.upper()]
df.to_sql('repairs', conn, if_exists='append', index=False, method='multi', chunksize=1000)
# ========================================================

conn.close()
