import sys
import pickle

def predict_sentiment(text):
    # Load the pre-trained model
    with open('sentiment_model.pkl', 'rb') as model_file:
        model = pickle.load(model_file)

    # Preprocess the text here if needed (cleaning, tokenization, etc.)
    # Replace this with your actual preprocessing steps

    # Predict sentiment using the loaded model
    predicted_class = model.predict([text])[0]
    
    return predicted_class

if __name__ == "__main__":
    # Get the input text from command line argument
    input_text = sys.argv[1]

    # Predict sentiment for the provided text
    predicted_sentiment = predict_sentiment(input_text)
    print(predicted_sentiment)
