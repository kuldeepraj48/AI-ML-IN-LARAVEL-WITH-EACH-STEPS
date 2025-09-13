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
🛠 Laravel Dependencies
Install in your Laravel app:

bash
Copy code
composer require openai-php/laravel
Publish config:

bash
Copy code
php artisan vendor:publish --provider="OpenAI\Laravel\ServiceProvider"
Add your API key in .env:

env
Copy code
OPENAI_API_KEY=your_api_key_here
OPENAI_ORGANIZATION=null
📂 Project Structure
bash
Copy code
AI-ML-IN-LARAVEL-WITH-EACH-STEPS/
│
├── app/Http/Controllers/AIController.php  # Main AI Controller
├── ml/sentiment.py                        # Python ML script (create inside /ml folder)
├── resources/views/analyze.blade.php      # Frontend form + results
├── routes/web.php                         # Routes
├── routes/api.php                         # API routes
├── README.md                              # Documentation
▶️ Setup Instructions
1️⃣ Clone Repo
bash
Copy code
git clone https://gitlab.com/your-username/AI-ML-IN-LARAVEL-WITH-EACH-STEPS.git
cd AI-ML-IN-LARAVEL-WITH-EACH-STEPS
2️⃣ Install Laravel Dependencies
bash
Copy code
composer install
npm install && npm run dev
3️⃣ Configure Environment
Copy .env.example to .env:

bash
Copy code
cp .env.example .env
php artisan key:generate
Add DB connection and OpenAI key in .env.

4️⃣ Setup Database
bash
Copy code
php artisan migrate
5️⃣ Test Local Python Sentiment
Run:

bash
Copy code
python ml/sentiment.py "Laravel with AI is amazing"
Expected output:

json
Copy code
{"sentiment": "POSITIVE", "score": 0.85}
6️⃣ Start Laravel Server
bash
Copy code
php artisan serve
Visit:
👉 http://127.0.0.1:8000

🧑‍💻 Usage
Enter text in the form.

Select mode:

Local Sentiment (Python) → Runs local ML script.

ChatGPT API → Uses OpenAI API.

Summary (ChatGPT) → Summarizes text.

View AI response on screen.

📝 Example Commands
Local API call
bash
Copy code
curl -X POST http://127.0.0.1:8000/api/analyze -d "text=Laravel with AI is amazing"
Response:

json
Copy code
{"sentiment":"POSITIVE","score":0.85}
ChatGPT (if key active)
bash
Copy code
curl -X POST http://127.0.0.1:8000/api/analyze -d "text=Explain AI in one sentence" -d "mode=chatgpt"
Response:

json
Copy code
{"response":"AI is the simulation of human intelligence in machines."}
⚠️ Notes
If you don’t have OpenAI credits, only local Python ML will work.

Extend ml/sentiment.py with Hugging Face models for summarization, classification, translation, etc.

Logs of AI input/output are stored in DB (ai_logs table).

📌 Notes Last
These both are working fine as per:

http://127.0.0.1:8000/analyze

http://127.0.0.1:8000/api/analyze