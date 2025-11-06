# ✅ Checklist Instalasi Project

Gunakan checklist ini untuk memastikan semua langkah instalasi sudah dilakukan dengan benar.

## 📦 Persiapan Software

- [ ] Install PHP 8.1+ (atau install XAMPP yang sudah include PHP)
- [ ] Install Composer
- [ ] Install Node.js (versi LTS)
- [ ] Install MySQL (atau gunakan yang dari XAMPP)
- [ ] Verifikasi instalasi:
  - [ ] `php -v` → menampilkan versi PHP
  - [ ] `composer --version` → menampilkan versi Composer
  - [ ] `node --version` → menampilkan versi Node.js
  - [ ] `npm --version` → menampilkan versi NPM

## 🗄️ Setup Database

- [ ] Start MySQL service (via XAMPP atau service lainnya)
- [ ] Buat database baru (nama: `bansos_db` - **wajib menggunakan nama ini**)
- [ ] Catat informasi database:
  - [ ] Database name: `bansos_db` (**wajib**)
  - [ ] Username: `_________________`
  - [ ] Password: `_________________`
  - [ ] Host: `_________________` (biasanya `127.0.0.1`)
  - [ ] Port: `_________________` (biasanya `3306`)

## 📥 Setup Project

- [ ] Extract file ZIP project ke folder yang diinginkan (misalnya: `C:\xampp\htdocs\laravel`)
- [ ] Buka Command Prompt/PowerShell di folder project (klik kanan folder → **Open in Terminal**)
- [ ] Install dependencies PHP: `composer install`
- [ ] Install dependencies Node.js: `npm install`

## ⚙️ Konfigurasi Environment

- [ ] Buat file `.env` baru di folder project (copy template dari panduan atau dari `.env.example` jika ada)
- [ ] Update konfigurasi database di file `.env`:
  - [ ] `DB_DATABASE` = `bansos_db` (**wajib menggunakan nama ini**)
  - [ ] `DB_USERNAME` = username MySQL (biasanya `root`)
  - [ ] `DB_PASSWORD` = password MySQL (kosongkan jika tidak ada)
  - [ ] `DB_HOST` = host MySQL (biasanya `127.0.0.1`)
  - [ ] `DB_PORT` = port MySQL (biasanya `3306`)
- [ ] Generate application key: `php artisan key:generate`

## 🗃️ Setup Database

- [ ] Jalankan migration: `php artisan migrate`
- [ ] Jalankan seeder: `php artisan db:seed`
- [ ] Buat user admin (opsional):
  - [ ] Buka `php artisan tinker`
  - [ ] Buat user baru dengan role admin

## 🚀 Menjalankan Project

- [ ] Terminal 1: Jalankan `php artisan serve`
- [ ] Terminal 2: Jalankan `npm run dev`
- [ ] Akses aplikasi di browser:
  - [ ] Web: http://localhost:8000
  - [ ] Admin Panel: http://localhost:8000/admin

## ✅ Verifikasi

- [ ] Aplikasi web dapat diakses
- [ ] Admin panel dapat diakses
- [ ] Login ke admin panel berhasil
- [ ] Tidak ada error di browser console
- [ ] Tidak ada error di terminal

---

## 📝 Catatan

Jika ada masalah, cek:
1. File `storage/logs/laravel.log` untuk detail error
2. Pastikan MySQL service sudah running
3. Pastikan kedua terminal (artisan serve dan npm run dev) masih berjalan
4. Cek konfigurasi di file `.env` sudah benar

**Untuk panduan lengkap, lihat file `PANDUAN_INSTALASI.md`**

