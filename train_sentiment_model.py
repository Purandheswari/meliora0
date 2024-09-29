import pickle
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.svm import LinearSVC
from sklearn.pipeline import make_pipeline
from sklearn.metrics import accuracy_score
import pandas as pd

# Sample data for training (you can replace this with your own dataset)
data = {
    'text': [
        "This system is good!",
        "I am not satisfied with the service.",
        "The website is easy to navigate.",
        "The app crashes often.",
        "I love this platform!",
        "The support team is unresponsive."
    ],
    'label': ['positive', 'negative', 'positive', 'negative', 'positive', 'negative']
}

df = pd.DataFrame(data)

# Vectorization and model training
vectorizer = TfidfVectorizer()
classifier = LinearSVC()

model = make_pipeline(vectorizer, classifier)
model.fit(df['text'], df['label'])

# Save the model to a file
with open('sentiment_model.pkl', 'wb') as model_file:
    pickle.dump(model, model_file)
