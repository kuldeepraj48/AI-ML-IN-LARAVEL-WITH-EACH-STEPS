# AI-ML-IN-LARAVEL-WITH-EACH-STEPS

This project demonstrates how to integrate **AI/ML models** with a Laravel application.  
It supports:

- ✅ Local **Python ML model** (sentiment analysis)  
- ✅ OpenAI **ChatGPT API** (text generation, summarization)  
- ✅ Laravel Blade frontend to test AI  

---

## 📌 Requirements

### System
- PHP `>=8.1`
- Composer
- Laravel `>=10`
- Node.js & NPM (for frontend assets)
- Python `>=3.8` with `pip`

### Python Dependencies
Install in your Python environment:

```bash
pip install textblob
pip install transformers torch


# ALL STEPS AS PER EACH EVENT

Laravel Dependencies

Install in your Laravel app:

composer require openai-php/laravel


Publish config:

php artisan vendor:publish --provider="OpenAI\Laravel\ServiceProvider"


Add your API key in .env:

OPENAI_API_KEY=your_api_key_here
OPENAI_ORGANIZATION=null

Project Structure

AI-ML-IN-LARAVEL-WITH-EACH-STEPS/
│
├── app/Http/Controllers/AIController.php  # Main AI Controller
├── ml/sentiment.py                        # Python ML script Create file ml/sentiment.py: //inside ml folder touch sentiment.py
├── resources/views/analyze.blade.php      # Frontend form + results
├── routes/web.php                         # Routes
├── routes/api.php                         # api root for checking event
├── README.md                              # Documentation


Setup Instructions

Clone Repo git clone https://gitlab.com/your-username/AI-ML-IN-LARAVEL-WITH-EACH-STEPS.git
cd AI-ML-IN-LARAVEL-WITH-EACH-STEPS

Install Laravel Dependencies
composer install
npm install && npm run dev

Configure Environment

Copy .env.example to .env:

cp .env.example .env
php artisan key:generate


Add DB connection and OpenAI key in .env.

Setup Database
php artisan migrate

5️⃣ Test Local Python Sentiment

Run:

python ml/sentiment.py "Laravel with AI is amazing"


Expected output:

{"sentiment": "POSITIVE", "score": 0.85}

Start Laravel Server
php artisan serve


Visit http://127.0.0.1:8000


Usage

Enter text in the form.

Select mode:

Local Sentiment (Python) → Runs local ML script.

ChatGPT API → Uses OpenAI API.

Summary (ChatGPT) → Summarizes text.

View AI response on screen.

Example Commands
Call API locally
curl -X POST http://127.0.0.1:8000/api/analyze -d "text=Laravel with AI is amazing"


Response:

{"sentiment":"POSITIVE","score":0.85}

Example ChatGPT (if key active)
curl -X POST http://127.0.0.1:8000/api/analyze -d "text=Explain AI in one sentence" -d "mode=chatgpt"


Response:

{"response":"AI is the simulation of human intelligence in machines."}

Notes

If you don’t have OpenAI credits, only local Python ML will work.

Extend ml/sentiment.py with Hugging Face models for summarization, classification, translation, etc.

Logs of AI input/output are stored in DB (ai_logs table).


