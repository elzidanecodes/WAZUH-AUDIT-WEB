import pandas as pd
from sklearn.pipeline import Pipeline
from sklearn.ensemble import RandomForestClassifier
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.model_selection import StratifiedKFold, cross_val_score
from sklearn.metrics import classification_report
from sklearn.model_selection import cross_val_score
import joblib

# Load data
df = pd.read_csv('./outputs/alerts_for_labeling.csv')
df['combined'] = df['description'].fillna('') + ' ' + df['decoder'].fillna('')
X = df['combined']
y = df['label']

# Pipeline TF-IDF + RF
pipeline = Pipeline([
    ('tfidf', TfidfVectorizer()),
    ('clf', RandomForestClassifier(n_estimators=100, random_state=42))
])

# Stratified K-Fold (biar seimbang per kelas)
cv = StratifiedKFold(n_splits=50, shuffle=True, random_state=42)

# Evaluasi F1-score per fold
scores = cross_val_score(pipeline, X, y, cv=cv, scoring='f1_macro')

print("🔁 F1-score per fold:", scores)
print("📊 Rata-rata F1-score:", scores.mean())

# Latih model terakhir pada seluruh data
pipeline.fit(X, y)
joblib.dump(pipeline, './outputs/model_rf.pkl')
print("Model final disimpan sebagai model_rf.pkl")