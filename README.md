<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Livewire-4.0-FB70A9?style=for-the-badge&logo=livewire&logoColor=white" alt="Livewire 4">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="MIT License">
</p>

# 📚 StudyFlow — Smart Study Planner & Pomodoro Timer

**StudyFlow** is a full-featured study planner web application built with Laravel 12. It helps students organize subjects, manage tasks, track focus sessions with a Pomodoro timer, and visualize their learning progress through analytics — all wrapped in a modern, premium UI.

---

## ✨ Features

### Core Functionality
- **Subject Management** — Organize your studies by subject with color-coded labels
- **Task Management** — Create, prioritize (low/medium/high), and track tasks with deadlines
- **Pomodoro Timer** — Built-in focus timer with configurable work/break intervals, task linking, and session history
- **Analytics Dashboard** — Weekly focus charts, study streaks, daily goal tracking, subject progress, and motivational quotes

### Authentication & Security
- Email/password registration and login
- Google OAuth social login (via Laravel Socialite)
- Email verification
- Two-factor authentication (2FA)
- Password reset flow
- Role-based access control (Student / Admin)

### User Experience
- Premium dark-gradient sidebar with collapsible navigation
- Responsive design for mobile, tablet, and desktop
- Real-time Alpine.js interactivity
- Browser notifications for Pomodoro timer
- Flash messages with animations

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| **Framework** | Laravel 12 |
| **Language** | PHP 8.2+ |
| **Frontend** | Tailwind CSS 4, Alpine.js 3, Chart.js 4 |
| **Reactivity** | Livewire 4, Flux 2 |
| **Auth** | Laravel Fortify, Laravel Breeze, Laravel Socialite |
| **Database** | SQLite (default) / MySQL / PostgreSQL |
| **Build** | Vite 7 |
| **Testing** | Pest 4 |

---

## 📦 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & npm
- SQLite / MySQL / PostgreSQL

### Setup

```bash
# Clone the repository
git clone https://github.com/your-username/studyflow.git
cd studyflow

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate

# (Optional) Seed sample data
php artisan db:seed

# Build frontend assets
npm run build

# Start the development server
php artisan serve
```

### Quick Start (with Composer script)

```bash
composer run setup
composer run dev
```

The `dev` command starts the Laravel server, queue worker, log viewer, and Vite dev server concurrently.

---

## ⚙️ Configuration

### Environment Variables

Copy `.env.example` to `.env` and configure the following:

#### Database

```env
DB_CONNECTION=sqlite
# For MySQL/PostgreSQL:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=studyflow
# DB_USERNAME=root
# DB_PASSWORD=
```

#### Google OAuth (Optional)

To enable "Sign in with Google", create credentials at [Google Cloud Console](https://console.cloud.google.com/):

```env
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

#### Mail (for email verification & password resets)

```env
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
```

---

## 🗂 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AnalyticsController.php      # Study analytics & charts
│   │   ├── PomodoroController.php       # Pomodoro timer sessions
│   │   ├── ProfileController.php        # User profile management
│   │   ├── StudyDashboardController.php # Main dashboard with stats
│   │   ├── SubjectController.php        # Subject CRUD
│   │   └── TaskController.php           # Task CRUD & toggle
│   └── Middleware/
│       └── RoleMiddleware.php           # Role-based access control
├── Models/
│   ├── User.php                         # User with roles & relationships
│   ├── Subject.php                      # Study subjects (color-coded)
│   ├── Task.php                         # Tasks with priority & deadlines
│   └── PomodoroSession.php             # Focus/break session tracking
resources/
├── views/
│   ├── components/layouts/
│   │   └── study.blade.php             # Main application layout
│   ├── study/
│   │   ├── dashboard.blade.php         # Dashboard with stats & charts
│   │   ├── analytics.blade.php         # Analytics page
│   │   ├── pomodoro.blade.php          # Pomodoro timer
│   │   ├── subjects/                   # Subject views (index, create, edit)
│   │   └── tasks/                      # Task views (index, create, edit)
│   ├── profile/
│   │   └── edit.blade.php             # Profile settings page
│   └── auth/                          # Authentication views
routes/
├── web.php                            # Application routes
├── auth.php                           # Authentication routes
└── settings.php                       # Settings/Livewire routes
```

---

## 🗄 Database Schema

```
users
├── id, name, email, password, role (student|admin)
├── email_verified_at, two_factor_secret, two_factor_recovery_codes
└── timestamps

subjects
├── id, user_id (FK), name, color (default: #6366f1)
└── timestamps

tasks
├── id, user_id (FK), subject_id (nullable FK)
├── title, description, deadline, priority (low|medium|high), status (pending|completed)
└── timestamps

pomodoro_sessions
├── id, user_id (FK), task_id (nullable FK)
├── duration (seconds), type (focus|break), completed_at
└── timestamps
```

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run with Pest directly
./vendor/bin/pest

# Run a specific test file
./vendor/bin/pest tests/Feature/ExampleTest.php
```

---

## 📸 Pages Overview

| Page | Description |
|---|---|
| **Dashboard** | Daily goal ring, study streak, weekly chart, task overview, motivational quotes |
| **Subjects** | Color-coded subject cards with task counts and progress bars |
| **Tasks** | Filterable task list with priority badges, deadlines, and quick toggle |
| **Pomodoro** | Circular timer with focus/break modes, session log, and customizable settings |
| **Analytics** | Monthly focus stats, weekly line chart, subject distribution doughnut, task progress |
| **Profile** | Account settings, password update, and account deletion |

---

## 🚀 Deployment

```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Build frontend for production
npm run build
```

Ensure the following in production:
- `APP_ENV=production`
- `APP_DEBUG=false`
- Proper database credentials
- Configured mail driver for email verification
- HTTPS for Google OAuth callback URL

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This project is open-sourced under the [MIT License](LICENSE).

---

<p align="center">
  Built with ❤️ using Laravel 12
</p>
