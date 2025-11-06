# Panduan Instalasi dan Menjalankan Project Laravel

Panduan ini dibuat untuk membantu mahasiswa yang belum familiar dengan project Laravel ini untuk dapat menjalankan project di laptop masing-masing.

## 📋 Daftar Isi

1. [Persyaratan Sistem](#persyaratan-sistem)
2. [Langkah 1: Install Software yang Diperlukan](#langkah-1-install-software-yang-diperlukan)
3. [Langkah 2: Clone/Download Project](#langkah-2-clonedownload-project)
4. [Langkah 3: Setup Database](#langkah-3-setup-database)
5. [Langkah 4: Install Dependencies](#langkah-4-install-dependencies)
6. [Langkah 5: Konfigurasi Environment](#langkah-5-konfigurasi-environment)
7. [Langkah 6: Setup Database dan Seeder](#langkah-6-setup-database-dan-seeder)
8. [Langkah 7: Menjalankan Project](#langkah-7-menjalankan-project)
9. [Masalah yang Sering Terjadi](#masalah-yang-sering-terjadi)

---

## Persyaratan Sistem

Sebelum memulai, pastikan laptop Anda memenuhi persyaratan berikut:

- **PHP**: Versi 8.1 atau lebih tinggi (8.2 atau 8.3 lebih disarankan)
- **Composer**: Package manager untuk PHP
- **Node.js**: Versi 16 atau lebih tinggi (untuk frontend assets)
- **Database**: MySQL 5.7+ atau MariaDB 10.3+
- **Web Server**: Apache/Nginx (bisa menggunakan built-in Laravel server)

---

## Langkah 1: Install Software yang Diperlukan

### 1.1 Install PHP

#### Untuk Windows:
1. Download PHP dari [windows.php.net](https://windows.php.net/download/)
2. Pilih versi **PHP 8.1 atau 8.2** (Thread Safe)
3. Extract file ZIP ke folder `C:\php`
4. Tambahkan `C:\php` ke PATH environment variable:
   - Tekan `Windows + R`, ketik `sysdm.cpl`, tekan Enter
   - Pilih tab **Advanced** → **Environment Variables**
   - Di bagian **System Variables**, pilih **Path** → **Edit**
   - Klik **New** dan tambahkan `C:\php`
   - Klik **OK** untuk semua dialog
5. Verifikasi instalasi dengan buka Command Prompt/PowerShell, ketik:
   ```bash
   php -v
   ```
   Jika muncul versi PHP, berarti sudah berhasil!

**Alternatif Lebih Mudah**: Install **XAMPP** atau **Laragon** yang sudah include PHP, MySQL, dan Apache.

#### Untuk Mac:
```bash
# Install menggunakan Homebrew
brew install php@8.2
brew link php@8.2
```

#### Untuk Linux (Ubuntu/Debian):
```bash
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip php8.2-gd
```

### 1.2 Install Composer

1. Download Composer dari [getcomposer.org](https://getcomposer.org/download/)
2. Jalankan installer dan ikuti petunjuk
3. Verifikasi instalasi:
   ```bash
   composer --version
   ```

### 1.3 Install Node.js dan NPM

1. Download Node.js dari [nodejs.org](https://nodejs.org/)
2. Install versi LTS (Long Term Support)
3. Verifikasi instalasi:
   ```bash
   node --version
   npm --version
   ```

### 1.4 Install MySQL

#### Untuk Windows:
- Download MySQL dari [mysql.com](https://dev.mysql.com/downloads/installer/)
- Atau install **XAMPP** yang sudah include MySQL

#### Untuk Mac:
```bash
brew install mysql
brew services start mysql
```

#### Untuk Linux:
```bash
sudo apt install mysql-server
sudo systemctl start mysql
```

Buat database baru untuk project ini:
```sql
CREATE DATABASE laravel_db;
```

**Catatan**: Ingat username dan password MySQL Anda, akan diperlukan nanti!

---

## Langkah 2: Extract Project dari File ZIP

1. **Download file ZIP** project yang diberikan
2. **Extract file ZIP** ke folder yang diinginkan (misalnya: `C:\xampp\htdocs\laravel` atau `D:\Projects\laravel`)
   - Klik kanan pada file ZIP → **Extract All** atau gunakan aplikasi seperti **WinRAR** / **7-Zip**
3. **Buka Command Prompt/PowerShell** di folder project:
   - Cara 1: Buka Command Prompt/PowerShell, lalu ketik:
     ```bash
     cd C:\xampp\htdocs\laravel
     ```
     (sesuaikan dengan path folder project Anda)
   - Cara 2: Di File Explorer, klik kanan pada folder project → **Open in Terminal** atau **Open PowerShell window here**

---

## Langkah 3: Setup Database

1. Buka aplikasi MySQL (phpMyAdmin, MySQL Workbench, atau command line)
2. Buat database baru:
   ```sql
   CREATE DATABASE bansos_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
   Atau jika sudah ada database, catat nama database-nya.

3. Catat informasi berikut (akan digunakan di langkah berikutnya):
   - **Database Name**: `bansos_db` (atau nama yang Anda buat)
   - **Database Username**: biasanya `root` (default)
   - **Database Password**: password MySQL Anda (kosongkan jika tidak ada)
   - **Database Host**: biasanya `127.0.0.1` atau `localhost`
   - **Database Port**: biasanya `3306`

---

## Langkah 4: Install Dependencies

Buka Command Prompt/PowerShell di folder project dan jalankan:

### 4.1 Install PHP Dependencies
```bash
composer install
```
Proses ini mungkin memakan waktu beberapa menit. Tunggu sampai selesai.

### 4.2 Install Node.js Dependencies
```bash
npm install
```
Tunggu sampai proses selesai.

---

## Langkah 5: Konfigurasi Environment

1. Di folder project, buat file `.env` (jika belum ada):
   - Buat file baru bernama `.env` (tanpa ekstensi lain, hanya `.env`)
   - Copy isi template di bawah ini ke dalam file `.env`
   - Atau copy dari `.env.example` jika ada di folder project

2. Buka file `.env` dengan text editor (Notepad++, VS Code, atau Notepad biasa)

3. Cari dan ubah bagian berikut sesuai dengan setup database Anda:

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

**Penjelasan**:
- `DB_DATABASE`: Nama database yang Anda buat (**wajib**: `bansos_db`)
- `DB_USERNAME`: Username MySQL (biasanya `root`)
- `DB_PASSWORD`: Password MySQL (kosongkan jika tidak ada password)
- `DB_HOST`: Biasanya `127.0.0.1` atau `localhost`
- `APP_URL`: URL untuk mengakses aplikasi (set ke `http://localhost`, meskipun `php artisan serve` menggunakan port 8000)
- `APP_DEBUG`: Set `false` untuk production, `true` untuk development (disarankan set `true` saat development untuk debugging)
- `APP_KEY`: Akan di-generate otomatis setelah menjalankan `php artisan key:generate`

4. Generate Application Key:
```bash
php artisan key:generate
```

---

## Langkah 6: Setup Database dan Seeder

### 6.1 Jalankan Migration
Ini akan membuat tabel-tabel yang diperlukan di database:
```bash
php artisan migrate
```

Jika muncul error, pastikan:
- Database sudah dibuat
- Konfigurasi di file `.env` sudah benar
- MySQL service sudah berjalan

### 6.2 Jalankan Seeder
Ini akan mengisi database dengan data awal (roles, permissions, departments):
```bash
php artisan db:seed
```

### 6.3 Buat User Admin (Opsional)
Jika ingin membuat user admin untuk login ke admin panel:
```bash
php artisan tinker
```
Kemudian di dalam tinker, jalankan:
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = bcrypt('password123');
$user->save();
$user->assignRole('admin'); // atau role yang sesuai
exit
```

---

## Langkah 7: Menjalankan Project

### 7.1 Jalankan Laravel Development Server
Di Command Prompt/PowerShell, jalankan:
```bash
php artisan serve
```

Anda akan melihat output seperti:
```
Starting Laravel development server: http://127.0.0.1:8000
```

### 7.2 Jalankan Vite (untuk Frontend Assets)
Buka **Command Prompt/PowerShell baru** (jangan tutup yang pertama), lalu:
```bash
npm run dev
```

**Catatan**: Anda perlu menjalankan **kedua command** di atas secara bersamaan:
- Terminal 1: `php artisan serve`
- Terminal 2: `npm run dev`

### 7.3 Akses Aplikasi

Buka browser dan akses:
- **Web Application**: http://localhost:8000
- **Admin Panel (Filament)**: http://localhost:8000/admin

**Catatan**: Gunakan email dan password yang Anda buat di langkah 6.3 untuk login ke admin panel.

---

## Masalah yang Sering Terjadi

### ❌ Error: "SQLSTATE[HY000] [2002] No connection could be made"
**Solusi**: 
- Pastikan MySQL service sudah berjalan
- Cek konfigurasi `DB_HOST` di file `.env`
- Pastikan port MySQL benar (default: 3306)

### ❌ Error: "Access denied for user"
**Solusi**:
- Pastikan `DB_USERNAME` dan `DB_PASSWORD` di file `.env` sudah benar
- Coba reset password MySQL atau gunakan user yang berbeda

### ❌ Error: "Class 'PDO' not found"
**Solusi**:
- Install extension PHP PDO MySQL
- Di XAMPP, biasanya sudah terinstall otomatis
- Di Linux: `sudo apt install php-mysql`

### ❌ Error: "The stream or file could not be opened"
**Solusi**:
- Pastikan folder `storage` dan `bootstrap/cache` memiliki permission write
- Di Windows biasanya tidak masalah, tapi pastikan folder tidak di-protect
- Di Linux/Mac: `chmod -R 775 storage bootstrap/cache`

### ❌ Error: "npm command not found"
**Solusi**:
- Pastikan Node.js sudah terinstall
- Restart Command Prompt/PowerShell setelah install Node.js
- Cek PATH environment variable

### ❌ Error: "composer command not found"
**Solusi**:
- Pastikan Composer sudah terinstall
- Restart Command Prompt/PowerShell setelah install Composer
- Cek PATH environment variable

### ❌ Halaman kosong atau error 500
**Solusi**:
- Pastikan sudah menjalankan `php artisan key:generate`
- Cek file `.env` sudah ada dan konfigurasinya benar
- Cek log error di `storage/logs/laravel.log`

### ❌ CSS/JS tidak muncul
**Solusi**:
- Pastikan `npm run dev` sedang berjalan
- Jalankan `npm run build` jika production
- Clear cache: `php artisan cache:clear` dan `php artisan config:clear`

---

## Tips Tambahan

1. **Selalu jalankan kedua command** (`php artisan serve` dan `npm run dev`) saat development
2. **Jangan commit file `.env`** ke git (sudah ada di `.gitignore`)
3. Jika ada perubahan di file `.env`, jalankan: `php artisan config:clear`
4. Jika ada masalah dengan database, bisa reset dengan:
   ```bash
   php artisan migrate:fresh --seed
   ```
   ⚠️ **PERINGATAN**: Ini akan menghapus semua data di database!

---

## Struktur Project

- `app/`: Kode aplikasi utama
- `app/Filament/`: Admin panel menggunakan Filament
- `app/Models/`: Model database
- `database/migrations/`: File migration database
- `database/seeders/`: Data awal untuk database
- `public/`: File yang bisa diakses public (CSS, JS, images)
- `resources/`: View dan assets
- `.env`: Konfigurasi environment (tidak di-commit ke git)

---

## Bantuan Lebih Lanjut

Jika masih mengalami masalah:
1. Cek file `storage/logs/laravel.log` untuk detail error
2. Pastikan semua langkah di atas sudah dilakukan dengan benar
3. Cek dokumentasi Laravel: [laravel.com/docs](https://laravel.com/docs)
4. Cek dokumentasi Filament: [filamentphp.com/docs](https://filamentphp.com/docs)

---

**Selamat! Project Anda seharusnya sudah berjalan sekarang.** 🎉

Jika ada pertanyaan atau masalah, jangan ragu untuk bertanya!

