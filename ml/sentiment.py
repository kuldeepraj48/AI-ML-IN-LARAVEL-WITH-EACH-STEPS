import sys, json
from textblob import TextBlob

text = " ".join(sys.argv[1:])
analysis = TextBlob(text)

sentiment = "POSITIVE" if analysis.sentiment.polarity > 0 else "NEGATIVE"

output = {
    "sentiment": sentiment,
    "score": float(analysis.sentiment.polarity)
}
print(json.dumps(output))
