from flask import Flask, request, jsonify
import torch
import torch.nn as nn

app = Flask(__name__)

# Define the model class (ensure it matches the saved model's architecture)
class ComplaintClassification(nn.Module):
    def __init__(self, vocab_size, embed_dim, num_class):
        super(ComplaintClassification, self).__init__()
        self.embedding = nn.EmbeddingBag(vocab_size, embed_dim, sparse=False)
        self.fc = nn.Linear(embed_dim, num_class)
    
    def forward(self, text):
        embedded = self.embedding(text)
        return self.fc(embedded)

# Load your saved model
vocab_size = 10000  # Example, adjust as per your vocab size
embed_dim = 64
num_classes = 10  # Example, adjust as per your number of classes

model = ComplaintClassification(vocab_size, embed_dim, num_classes)
model.load_state_dict(torch.load('best_model.pt'))
model.eval()

# Function to preprocess text
def text_pipeline(text, vocab):
    tokens = text.lower().split()
    return [vocab.get(token, vocab["<unk>"]) for token in tokens]

@app.route('/predict', methods=['POST'])
def predict():
    data = request.json
    text = data['text']
    vocab = data['vocab']
    text_tensor = torch.tensor(text_pipeline(text, vocab)).unsqueeze(0)
    with torch.no_grad():
        output = model(text_tensor)
        _, predicted = torch.max(output.data, 1)
        return jsonify({'prediction': predicted.item()})

if __name__ == '__main__':
    app.run(port=5000)
