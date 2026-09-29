# Maintenance Workshop Management

A Laravel web application for managing maintenance workshop subscriptions and their supporting data: partners, service locations, contacts, and service types.

The application includes an operational dashboard, searchable subscription records, Excel and PDF exports, authentication, responsive layouts, and a focused light/dark interface designed for clear demonstrations.

## Features

- Dashboard with current totals for subscriptions, partners, locations, and contacts
- Workshop subscription creation, editing, deletion, search, and status filtering
- Partner, location, contact, and service-type management
- Subscription status tracking for active, pending, paused, and expired records
- Excel and PDF exports
- User authentication and profile management
- Responsive desktop and mobile layouts
- Persistent light and dark themes
- Default administrator account for local development

## Tech stack

- PHP 8.1 or newer
- Laravel 10
- MySQL or MariaDB
- Laravel Breeze authentication
- Blade and Alpine.js
- Tailwind CSS
- Vite
- Laravel DOMPDF
- Laravel Excel

## Local installation

### Requirements

Install the following before starting:

- PHP 8.1+
- Composer
- Node.js and npm
- MySQL or MariaDB
- Laragon, XAMPP, or another local PHP environment

### Setup

Clone the repository and enter the project directory:

```bash
git clone https://github.com/your-username/maintenance-app.git
cd maintenance-app
```

Install the PHP and frontend dependencies:

```bash
composer install
npm install
```

Create the environment file and application key:

```bash
copy .env.example .env
php artisan key:generate
```

On macOS or Linux, use:

```bash
cp .env.example .env
php artisan key:generate
```

Create a MySQL database named `laravel`, then update the database section in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Run the migrations and seed the administrator account:

```bash
php artisan migrate --seed
```

Build the frontend assets:

```bash
npm run build
```

Start the development server:

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Laragon setup

Place the project at:

```text
C:\laragon\www\maintenance-app
```

The project structure should contain `artisan` directly inside that directory:

```text
C:\laragon\www\maintenance-app\artisan
C:\laragon\www\maintenance-app\public
C:\laragon\www\maintenance-app\routes
```

With Laragon Auto Virtual Hosts enabled, open:

```text
http://maintenance-app.test
```

Use this value in `.env`:

```env
APP_URL=http://maintenance-app.test
SESSION_DRIVER=file
SESSION_DOMAIN=
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax
```

After changing `.env`, clear Laravel's cached configuration:

```bash
php artisan optimize:clear
```

## Default administrator

The database seeder creates this account for local development:

```text
Email: admin@maintenance-app.test
Password: admin123
```

Change or remove the default credentials before deploying the application to a public server.

## Development

Start Vite in development mode:

```bash
npm run dev
```

Run the test suite:

```bash
php artisan test
```

Create a production build:

```bash
npm run build
```

## Main routes

| Route | Purpose |
| --- | --- |
| `/login` | User login |
| `/dashboard` | Operational summary |
| `/workshops` | Workshop and subscription management |
| `/workshops/export/excel` | Export subscription data to Excel |
| `/workshops/export/pdf` | Export subscription data to PDF |
| `/profile` | User profile settings |

Protected routes require authentication.

## Common issues

### `SQLSTATE[42S02]` table not found

Run the migrations:

```bash
php artisan migrate --seed
```

### MySQL tries to connect as `forge`

Update `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`, then run:

```bash
php artisan optimize:clear
```

### 419 Page Expired

Use one hostname consistently, confirm `APP_URL` matches it, and clear cached configuration. Also confirm that `storage/framework/sessions` exists and is writable.

```bash
php artisan optimize:clear
```

Clear the browser cookies for the local domain before opening the login page again.

### Apache returns 404

Point the virtual host DocumentRoot to the Laravel `public` directory and allow `.htaccess` overrides:

```apache
<VirtualHost *:80>
    ServerName maintenance-app.test
    DocumentRoot "C:/laragon/www/maintenance-app/public"

    <Directory "C:/laragon/www/maintenance-app/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Project structure

```text
app/                 Application models, controllers, and providers
database/            Migrations, factories, and seeders
public/              Web entry point and built frontend assets
resources/css/       Base and Neo-Brutalist stylesheets
resources/views/     Blade templates
routes/              Web and authentication routes
tests/               Feature and unit tests
```

## Security notes

- Never commit `.env` to GitHub.
- Generate a separate `APP_KEY` for each installation.
- Replace the default administrator password before public deployment.
- Disable `APP_DEBUG` in production.
