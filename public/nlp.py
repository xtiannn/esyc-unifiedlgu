import sys
import json
import nltk
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
import re

# Download NLTK data (run once manually or ensure it’s pre-downloaded)
nltk.download('punkt', quiet=True)
nltk.download('stopwords', quiet=True)

# Intent mapping
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

if __name__ == '__main__':
    # Get input from command line argument
    if len(sys.argv) > 1:
        user_input = sys.argv[1]
        intent = process_input(user_input)
        # Output JSON to stdout
        result = {'intent': intent if intent else 'unknown'}
        print(json.dumps(result))
    else:
        print(json.dumps({'intent': 'unknown', 'error': 'No input provided'}))
