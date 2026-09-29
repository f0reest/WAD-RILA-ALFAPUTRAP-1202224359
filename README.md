# Maintenance Workshop Management

A Laravel web application for managing workshop maintenance subscriptions and their supporting data, including partners, service locations, contacts, and service types.

The interface is lightweight and focused on operational workflows, making the application easy to explain during demonstrations and presentations.

## Main features

- Compact dashboard showing subscription, partner, location, and contact totals
- Create, edit, delete, search, and filter workshop subscriptions
- Manage partners, locations, contacts, and service types
- Track `active`, `pending`, `paused`, and `expired` subscription statuses
- Export subscription data to Excel and PDF
- Authentication, profile settings, and password management
- Admin-only access with public registration disabled
- Responsive layouts for desktop and mobile devices
- Persistent light and dark themes

## Technology stack

- PHP 8.1+
- Laravel 10
- MySQL or MariaDB
- Laravel Breeze
- Blade and Alpine.js
- Tailwind CSS 3
- Vite 5
- Laravel DOMPDF
- Laravel Excel

## Local installation

### 1. Clone the repository

```bash
git clone https://github.com/Rvxz213/WAD-RILA-ALFAPUTRAP-1202224359.git
cd WAD-RILA-ALFAPUTRAP-1202224359
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Prepare the environment

Windows:

```bash
copy .env.example .env
php artisan key:generate
```

macOS or Linux:

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure the database

Create a MySQL database, then update the following values in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrate, seed, and build

```bash
php artisan migrate --seed
npm run build
```

### 6. Start the application

```bash
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Demo account

The database seeder creates the administrator account used to access the application locally. Public registration is disabled, so only accounts already stored in the `users` table can sign in.

```text
Email: admin@maintenance-app.test
Password: admin123
```

Change these credentials before publishing the application.

## Running with Laragon

Place the project in the Laragon web directory, for example:

```text
C:\laragon\www\maintenance-app
```

Enable Auto Virtual Hosts and use the following environment configuration:

```env
APP_URL=http://maintenance-app.test
SESSION_DRIVER=file
SESSION_DOMAIN=
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax
```

Clear the configuration cache after changing `.env`:

```bash
php artisan optimize:clear
```

Open [http://maintenance-app.test](http://maintenance-app.test).

## Development commands

Start Vite in development mode:

```bash
npm run dev
```

Run the complete test suite:

```bash
php artisan test
```

Create a production frontend build:

```bash
npm run build
```

Current verification status: 29 tests and 77 assertions passing.

## Main routes

| Route | Purpose |
| --- | --- |
| `/login` | User login |
| `/dashboard` | Operational summary |
| `/workshops` | Workshop and subscription management |
| `/workshops/export/excel` | Export subscriptions to Excel |
| `/workshops/export/pdf` | Export subscriptions to PDF |
| `/profile` | User profile settings |

All application routes require an existing authenticated administrator. The `/register` route is intentionally unavailable.

## Project structure

```text
app/                 Models, controllers, middleware, and providers
database/            Migrations, factories, and seeders
public/              Web entry point and compiled frontend assets
resources/css/       Base styles and dashboard interface
resources/js/        JavaScript entry point and Alpine.js
resources/views/     Blade templates
routes/              Web, API, console, and authentication routes
tests/               Feature tests
tokens.css           Color, typography, spacing, and motion tokens
```

## Troubleshooting

### Database tables are missing

```bash
php artisan migrate --seed
```

### The application uses outdated database credentials

Check `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env`, then run:

```bash
php artisan optimize:clear
```

### 419 Page Expired

Make sure `APP_URL` matches the hostname opened in the browser. Then clear the configuration cache and cookies for that local domain.

```bash
php artisan optimize:clear
```

### Apache returns a 404 page

Point the virtual host DocumentRoot to Laravel's `public` directory:

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

## Security notes

- Never commit the `.env` file.
- Generate a separate `APP_KEY` for every installation.
- Replace or remove the demo account before a public deployment.
- Use `APP_DEBUG=false` in production.
- Ensure the web server can write to `storage` and `bootstrap/cache`.
