# Maintenance Workshop Management

Aplikasi web Laravel untuk mengelola langganan maintenance workshop beserta data pendukungnya: partner, lokasi layanan, kontak, dan jenis layanan.

Antarmuka dibuat ringan dan fokus pada kebutuhan operasional sehingga alur aplikasi mudah dijelaskan saat demo atau presentasi.

## Fitur utama

- Dashboard ringkas berisi jumlah langganan, partner, lokasi, dan kontak
- Pengelolaan langganan workshop: tambah, edit, hapus, cari, dan filter status
- Pengelolaan partner, lokasi, kontak, dan jenis layanan
- Status langganan: `active`, `pending`, `paused`, dan `expired`
- Export data langganan ke Excel dan PDF
- Autentikasi, pengaturan profil, dan perubahan password
- Tampilan responsif untuk desktop dan perangkat mobile
- Light mode dan dark mode yang tersimpan di browser

## Teknologi

- PHP 8.1+
- Laravel 10
- MySQL atau MariaDB
- Laravel Breeze
- Blade dan Alpine.js
- Tailwind CSS 3
- Vite 5
- Laravel DOMPDF
- Laravel Excel

## Instalasi lokal

### 1. Clone repository

```bash
git clone https://github.com/Rvxz213/WAD-RILA-ALFAPUTRAP-1202224359.git
cd WAD-RILA-ALFAPUTRAP-1202224359
```

### 2. Install dependency

```bash
composer install
npm install
```

### 3. Siapkan environment

Windows:

```bash
copy .env.example .env
php artisan key:generate
```

macOS atau Linux:

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Hubungkan database

Buat database MySQL, kemudian sesuaikan bagian berikut di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi, seed, dan build

```bash
php artisan migrate --seed
npm run build
```

### 6. Jalankan aplikasi

```bash
php artisan serve
```

Buka [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Akun demo

Seeder membuat akun administrator untuk kebutuhan pengembangan lokal:

```text
Email: admin@maintenance-app.test
Password: admin123
```

Ganti kredensial tersebut sebelum aplikasi dipublikasikan.

## Menjalankan dengan Laragon

Letakkan proyek di folder web Laragon, misalnya:

```text
C:\laragon\www\maintenance-app
```

Aktifkan Auto Virtual Hosts dan gunakan konfigurasi berikut:

```env
APP_URL=http://maintenance-app.test
SESSION_DRIVER=file
SESSION_DOMAIN=
SESSION_SECURE_COOKIE=false
SESSION_SAME_SITE=lax
```

Setelah mengubah `.env`, bersihkan cache konfigurasi:

```bash
php artisan optimize:clear
```

Buka [http://maintenance-app.test](http://maintenance-app.test).

## Perintah pengembangan

Menjalankan Vite:

```bash
npm run dev
```

Menjalankan seluruh test:

```bash
php artisan test
```

Membuat frontend build produksi:

```bash
npm run build
```

Kondisi terakhir proyek: 29 test dan 77 assertion berhasil dijalankan.

## Route utama

| Route | Fungsi |
| --- | --- |
| `/login` | Login pengguna |
| `/dashboard` | Ringkasan operasional |
| `/workshops` | Pengelolaan workshop dan langganan |
| `/workshops/export/excel` | Export langganan ke Excel |
| `/workshops/export/pdf` | Export langganan ke PDF |
| `/profile` | Pengaturan profil pengguna |

Semua route selain autentikasi memerlukan pengguna yang sudah login.

## Struktur proyek

```text
app/                 Model, controller, middleware, dan provider
database/            Migration, factory, dan seeder
public/              Entry point serta aset frontend hasil build
resources/css/       Style dasar dan antarmuka dashboard
resources/js/        Entry point JavaScript dan Alpine.js
resources/views/     Template Blade
routes/              Route web, API, console, dan autentikasi
tests/               Feature test
tokens.css           Token warna, tipografi, spacing, dan motion
```

## Masalah umum

### Tabel database belum tersedia

```bash
php artisan migrate --seed
```

### Konfigurasi database masih menggunakan nilai lama

Periksa `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`, lalu jalankan:

```bash
php artisan optimize:clear
```

### Error 419 Page Expired

Pastikan `APP_URL` sama dengan hostname yang dibuka di browser. Setelah itu, bersihkan konfigurasi dan cookie untuk domain lokal tersebut.

```bash
php artisan optimize:clear
```

### Apache menampilkan halaman 404

Arahkan DocumentRoot virtual host ke folder `public`:

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

## Catatan keamanan

- Jangan commit file `.env`.
- Gunakan `APP_KEY` yang berbeda untuk setiap instalasi.
- Ganti atau hapus akun demo sebelum deployment publik.
- Gunakan `APP_DEBUG=false` pada production.
- Pastikan folder `storage` dan `bootstrap/cache` dapat ditulis oleh web server.
