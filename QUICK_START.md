# Quick Start Guide - Instalasi Cepat

Panduan ringkas untuk menjalankan project ini dalam waktu singkat.

## ⚡ Langkah Cepat (10 Menit)

### 1. Extract Project dari File ZIP
1. Extract file ZIP project yang diberikan ke folder yang diinginkan
2. Buka Command Prompt/PowerShell di folder project (klik kanan folder → **Open in Terminal**)

### 2. Install Software
- **XAMPP** (include PHP, MySQL, Apache) - [Download di sini](https://www.apachefriends.org/)
- **Composer** - [Download di sini](https://getcomposer.org/download/)
- **Node.js** - [Download di sini](https://nodejs.org/) (pilih versi LTS)

### 3. Setup Database
1. Buka XAMPP Control Panel
2. Start **Apache** dan **MySQL**
3. Buka phpMyAdmin (http://localhost/phpmyadmin)
4. Buat database baru: `bansos_db`

### 4. Install Dependencies
Buka Command Prompt/PowerShell di folder project:
```bash
composer install
npm install
```

### 5. Setup Environment
Buat file `.env` di folder project (copy template di bawah ini atau dari `.env.example` jika ada):
```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bansos_db
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

**Catatan**: 
- Nama database wajib: `bansos_db`
- `APP_DEBUG=false` untuk production, ubah ke `true` jika ingin melihat error detail saat development
- `APP_KEY` akan otomatis terisi setelah menjalankan `php artisan key:generate`

Kemudian jalankan:
```bash
php artisan key:generate
```

### 6. Setup Database
```bash
php artisan migrate
php artisan db:seed
```

### 7. Jalankan Project

**Terminal 1:**
```bash
php artisan serve
```

**Terminal 2:**
```bash
npm run dev
```

### 8. Akses Aplikasi
- Web: http://localhost:8000
- Admin Panel: http://localhost:8000/admin

---

## 📝 Buat User Admin

Untuk login ke admin panel, buat user terlebih dahulu:
```bash
php artisan tinker
```

Kemudian ketik:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = bcrypt('password123');
$user->save();
$user->assignRole('admin');
exit
```

Login dengan:
- Email: `admin@example.com`
- Password: `password123`

---

## ❗ Troubleshooting

**Error koneksi database?**
- Pastikan MySQL di XAMPP sudah running
- Cek username/password di file `.env`

**Command tidak ditemukan?**
- Restart Command Prompt setelah install software
- Cek PATH environment variable

**CSS/JS tidak muncul?**
- Pastikan `npm run dev` sedang berjalan di terminal terpisah

---

**Untuk panduan lengkap, lihat file `PANDUAN_INSTALASI.md`**

