import pandas as pd
from sklearn.pipeline import Pipeline
from sklearn.ensemble import RandomForestClassifier
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.model_selection import StratifiedKFold, GridSearchCV
from sklearn.metrics import classification_report
import joblib

# Load data
df = pd.read_csv('./outputs/alerts_for_labeling.csv')
df['combined'] = df['description'].fillna('') + ' ' + df['decoder'].fillna('')
X = df['combined']
y = df['label']

# Pipeline: TF-IDF + Random Forest
pipeline = Pipeline([
    ('tfidf', TfidfVectorizer()),
    ('clf', RandomForestClassifier(random_state=42))  # No fixed n_estimators here, will be set via GridSearch
])

# Stratified K-Fold CV
cv = StratifiedKFold(n_splits=10, shuffle=True, random_state=42)

# Grid Search Hyperparameter Space (sesuai tabel jurnal)
param_grid = {
    'clf__n_estimators': [50, 100, 200],
    'clf__max_depth': [None, 5, 10, 20],
    'clf__min_samples_split': [2, 5, 10],
    'clf__min_samples_leaf': [1, 2, 4],
    'clf__max_features': ['auto', 'sqrt']
}

# Grid Search
grid_search = GridSearchCV(
    estimator=pipeline,
    param_grid=param_grid,
    cv=cv,
    scoring='f1_macro',
    verbose=2,
    n_jobs=-1
)

# Fit Grid Search
grid_search.fit(X, y)

# Tampilkan hasil terbaik
print("Best Parameters:", grid_search.best_params_)
print("Best F1 Macro Score:", grid_search.best_score_)

# Simpan model terbaik
best_model = grid_search.best_estimator_
joblib.dump(best_model, './outputs/model_rf.pkl')
print("Model terbaik disimpan sebagai model_rf.pkl")