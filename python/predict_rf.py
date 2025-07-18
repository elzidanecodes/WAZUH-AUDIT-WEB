import pandas as pd
import joblib
import os
from pymongo import MongoClient
from datetime import datetime, timezone

def main():
    BASE_DIR = os.path.dirname(os.path.abspath(__file__))
    client = None
    try:
        # === 1. Load model ===
        model_path = os.path.join(BASE_DIR, 'outputs/model_rf.pkl')
        model = joblib.load(model_path)
        
        # === 2. Load data log CSV ===
        df = pd.read_csv(os.path.abspath(os.path.join(BASE_DIR, '../storage/app/python/outputs/alerts_for_labeling.csv')))
        print(f"Loaded {len(df)} raw records from CSV")
        
        # === 3. Fix timestamp conversion ===
        print("\nBefore timestamp conversion:")
        print(df['timestamp'].head())
        
        # Parse with correct format and add current year
        current_year = datetime.now().year
        df['timestamp'] = df['timestamp'].apply(
            lambda x: pd.to_datetime(f"{current_year} {x}", format='%Y %b %d %H:%M:%S', errors='coerce')
        )
        
        print("\nAfter timestamp conversion:")
        print(df['timestamp'].head())
        
        # Drop invalid timestamps
        initial_count = len(df)
        df = df.dropna(subset=['timestamp'])
        print(f"\nDropped {initial_count - len(df)} invalid records")
        print(f"Keeping {len(df)} valid records")
        
        if len(df) == 0:
            raise ValueError("No valid records after timestamp conversion")
        
        # === 4. Continue with remaining processing ===
        df['combined'] = df['description'].fillna('') + ' ' + df['decoder'].fillna('')
        df['predicted_label'] = model.predict(df['combined'])
        
        upload_time = datetime.now(timezone.utc)
        df['source'] = f"upload_{upload_time.strftime('%Y%m%d_%H%M%S')}"
        
        # Prepare for MongoDB
        records = df[['timestamp', 'description', 'decoder', 'predicted_label', 'source']].to_dict('records')
        
        # Convert pandas timestamps to datetime
        for record in records:
            if isinstance(record['timestamp'], pd.Timestamp):
                record['timestamp'] = record['timestamp'].to_pydatetime()
        
        # Insert into MongoDB
        client = MongoClient('mongodb://admin:admin9876@165.22.61.209:27017/')
        db = client['wazuh_audit']
        collection = db['predicted_logs']
        
        result = collection.insert_many(records)
        print(f"\nSuccessfully inserted {len(result.inserted_ids)} documents")
        
    except Exception as e:
        print(f"\nError: {str(e)}")
    finally:
        if client is not None:
            client.close()

if __name__ == "__main__":
    main()