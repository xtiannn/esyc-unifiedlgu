from flask import Flask, request, jsonify
import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
import re

app = Flask(__name__)

# Download NLTK data (run once)
nltk.download('punkt')
nltk.download('stopwords')

# Simple intent mapping (expand as needed)
INTENT_MAP = {
    'scholarship': ['scholarship', 'apply', 'status', 'documents', 'eligibility'],
    'incident': ['incident', 'report', 'problem', 'issue'],
    'emergency': ['emergency', 'alert', 'urgent', 'crisis'],
    'interview': ['interview', 'schedule', 'book', 'meeting'],
    'announcement': ['announcement', 'news', 'update'],
    'user': ['user', 'password', 'role', 'account']
}

def process_input(text):
    # Tokenize and clean input
    tokens = word_tokenize(text.lower())
    stop_words = set(stopwords.words('english'))
    cleaned = [word for word in tokens if word not in stop_words and re.match(r'^[a-z]+$', word)]

    # Detect intent
    for intent, keywords in INTENT_MAP.items():
        if any(keyword in cleaned for keyword in keywords):
            return intent
    return None

@app.route('/nlp', methods=['POST'])
def nlp():
    data = request.get_json()
    text = data.get('text', '')
    intent = process_input(text)
    return jsonify({'intent': intent if intent else 'unknown'})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
