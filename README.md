<div align="center">

# 🤖 Laravel AI Resume Analyzer

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/AI-Powered-00C4CC?style=for-the-badge&logo=anthropic&logoColor=white" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" />
</p>

<p align="center">
  An intelligent resume analysis web application powered by the official <strong>Laravel AI SDK</strong>.<br/>
  Upload your PDF resume and get instant AI driven feedback and improvement suggestions.
</p>

</div>

---

## ✨ Features

- 📄 **PDF Resume Upload** - Upload any PDF resume directly from the browser
- 🤖 **AI-Powered Analysis** - Get intelligent feedback using the Laravel AI SDK
- 📊 **Detailed Insights** - Receive section-by-section breakdown and improvement tips
- 🔐 **Secure Authentication** - User login & registration via Laravel Sanctum
- ⚡ **Fast Processing** - PDF text extracted instantly using `smalot/pdfparser`
- 📱 **Responsive UI** - Clean and modern interface built with Blade & Vite

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 13 |
| **Language** | PHP 8.3 |
| **AI Integration** | Laravel AI SDK (`laravel/ai`) |
| **PDF Parsing** | smalot/pdfparser |
| **Authentication** | Laravel Sanctum |
| **Frontend** | Blade Templates + Vite |
| **Testing** | Pest PHP |
| **Queue** | Laravel Queue (async processing) |

---

## 🚀 Getting Started

### Prerequisites

Make sure you have the following installed:

- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL or SQLite

### Installation

**1. Clone the repository**

```bash
git clone https://github.com/rakibhossainporosh/Laravel-Ai-SDK-Resume-Analyzer.git
cd Laravel-Ai-SDK-Resume-Analyzer
```

**2. Run the setup script**

```bash
composer run setup
```

This will automatically:
- Install PHP & Node dependencies
- Copy `.env.example` to `.env`
- Generate application key
- Run database migrations
- Build frontend assets

**3. Configure your `.env` file**

```env
APP_NAME="Laravel AI Resume Analyzer"
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# or use mysql:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=resume_analyzer
# DB_USERNAME=root
# DB_PASSWORD=

# Add your AI API key here
ANTHROPIC_API_KEY=your_api_key_here
```

**4. Start the development server**

```bash
composer run dev
```

> This starts the Laravel server, queue listener, logs watcher and Vite dev server all at once.

---

## 📖 Usage

1. **Register / Login** to your account
2. **Upload** your PDF resume from the dashboard
3. The system **parses** the PDF and extracts all text content
4. **AI analyzes** the resume and generates detailed feedback
5. **Review** suggestions to improve your resume

---

## 📁 Project Structure

```
├── app/
│   ├── Http/
│   │   └── Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   └── Services/            # AI & PDF service classes
├── resources/
│   └── views/               # Blade templates
├── routes/
│   └── web.php              # Web routes
├── database/
│   └── migrations/          # Database migrations
└── tests/                   # Pest test suite
```

---

## 🧪 Running Tests

```bash
composer run test
```

---

## 👨‍💻 Author

**Rakib Hossain**

- GitHub: [@rakibhossainporosh](https://github.com/rakibhossainporosh)

---

## 📄 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

<div align="center">
  <p>If you found this project helpful, please consider giving it a ⭐</p>
</div>
