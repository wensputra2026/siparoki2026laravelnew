# 🚀 Panduan Lengkap Instalasi & Deployment SIPAROKI 2026

Panduan ini disusun untuk membantu sekretariat, pengurus IT, pengembang, maupun tim komsos di setiap paroki Katolik di Indonesia dalam mengklon, menginstal, dan mengonfigurasi **SIPAROKI 2026** di berbagai lingkungan server.

---

## 📑 Daftar Isi
1. [Prasyarat Sistem](#1-prasyarat-sistem)
2. [Metode 1: Instalasi Cepat di Windows (Laragon / XAMPP)](#2-metode-1-instalasi-cepat-di-windows-laragon--xampp)
3. [Metode 2: Instalasi di VPS aaPanel (Linux Nginx / OpenLiteSpeed)](#3-metode-2-instalasi-di-vps-aapanel-linux-nginx--openlitespeed)
4. [Metode 3: Instalasi di Shared Hosting cPanel](#4-metode-3-instalasi-di-shared-hosting-cpanel)
5. [Metode 4: Instalasi di Server VPS Linux Murni (Ubuntu / Debian)](#5-metode-4-instalasi-di-server-vps-linux-murni-ubuntu--debian)
6. [Langkah Wajib: Mengaktifkan Identitas Paroki Anda](#6-langkah-wajib-mengaktifkan-identitas-paroki-anda)
7. [Akun Login Bawaan & Reset Password](#7-akun-login-bawaan--reset-password)
8. [Penyelesaian Masalah Umum (Troubleshooting)](#8-penyelesaian-masalah-umum-troubleshooting)

---

## 1. Prasyarat Sistem

Sebelum memulai, pastikan server atau komputer Anda memenuhi spesifikasi berikut:
- **PHP**: Versi `8.2` atau `8.3` (Sangat disarankan PHP 8.2+)
- **Database**: MySQL `5.7+`, MySQL `8.0+`, atau MariaDB `10.3+`
- **Ekstensi PHP Wajib**:
  - `pdo_mysql`, `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd`, `curl`, `zip`
- **Composer**: Versi `2.x+`
- **Node.js & NPM** *(Opsional)*: Versi `18+` (Aset JavaScript & CSS hasil build sudah disertakan, sehingga Anda tidak wajib menjalankan npm kecuali ingin memodifikasi tampilan Vue).

---

## 2. Metode 1: Instalasi Cepat di Windows (Laragon / XAMPP)

Bagi pengguna Laragon (Sangat Direkomendasikan) atau XAMPP di Windows:

### Langkah-langkah:
1. **Buka Terminal di Folder Web**:
   - Jika menggunakan **Laragon**, buka direktori: `C:\laragon\www\`
   - Jika menggunakan **XAMPP**, buka direktori: `C:\xampp\htdocs\`

2. **Klon Repositori SIPAROKI**:
   ```bash
   git clone https://github.com/wensputra2026/siparoki2026laravelnew.git siparoki
   cd siparoki
   ```

3. **Buat Database Kosong di MySQL**:
   - Buka HeidiSQL (bawaan Laragon) atau phpMyAdmin (`http://localhost/phpmyadmin`).
   - Buat sebuah database baru bernama: `siparoki_db` (Collation: `utf8mb4_unicode_ci`).

4. **Jalankan Skrip Setup Otomatis (1-Klik)**:
   - Cukup **klik dua kali berkas `setup.bat`** di dalam folder `siparoki`, ATAU jalankan lewat PowerShell / Command Prompt:
     ```cmd
     setup.bat
     ```
   - Skrip ini akan secara otomatis:
     - Menyalin `.env.example` ke `.env`
     - Mengunduh dependensi Composer
     - Menghasilkan `APP_KEY`
     - Mengimpor seluruh 163 tabel dan master data nasional KWI (`php artisan siparoki:setup --force`)
     - Membuat symlink storage publik (`php artisan storage:link`)
     - Membersihkan dan mengoptimalkan cache aplikasi

5. **Jalankan Server Lokal**:
   - Jika di Laragon: website langsung dapat diakses di `http://siparoki.test`
   - Atau jalankan server bawaan Laravel:
     ```bash
     php artisan serve
     ```
     Buka browser: 👉 `http://127.0.0.1:8000/login`

---

## 3. Metode 2: Instalasi di VPS aaPanel (Linux Nginx / OpenLiteSpeed)

Bagi paroki yang memiliki VPS Cloud (seperti DomaiNesia, Niagahoster, Biznet, IDCloudHost, Contabo, DigitalOcean, Linode):

1. **Persiapan di Dashboard aaPanel**:
   - Pasang **Nginx**, **MySQL 5.7/8.0**, dan **PHP-8.2** (atau **PHP-8.3**).
   - Di menu PHP Setting &rarr; **Install Extensions**: Pasang `fileinfo`, `opcache`, dan `exif`.
   - Di menu PHP Setting &rarr; **Disabled functions**: Hapus fungsi `putenv`, `proc_open`, `pcntl_signal`, dan `symlink` dari daftar batasan.
   - Restart layanan PHP.

2. **Buat Website Baru**:
   - Masuk ke menu **Website** &rarr; **Add site**.
   - Masukkan domain paroki Anda (contoh: `parokikita.org`).
   - Pada kolom Database, pilih **MySQL** (aaPanel akan membuatkan nama database dan password baru).
   - Pilih versi **PHP-82** lalu klik **Submit**.

3. **Klon Kode Sumber SIPAROKI**:
   - Buka menu **Terminal** aaPanel dan navigasikan ke direktori website:
     ```bash
     cd /www/wwwroot/parokikita.org
     rm -rf * .user.ini
     git clone https://github.com/wensputra2026/siparoki2026laravelnew.git .
     ```

4. **Konfigurasi Folder & URL Rewrite Nginx**:
   - Di menu Website aaPanel &rarr; Klik domain Anda:
     - Tab **Site directory**: Ubah *Running directory* dari `/` menjadi **/public**, lalu klik Simpan.
     - Tab **URL rewrite**: Pilih template **laravel5**, lalu klik Simpan.

5. **Jalankan Skrip Setup Otomatis Linux**:
   - Jalankan perintah instalasi 1-klik:
     ```bash
     chmod +x setup.sh
     ./setup.sh
     ```
   - Sesuaikan nama database, user, dan password di berkas `.env` sesuai informasi yang dibuat aaPanel di Langkah 2:
     ```env
     DB_DATABASE=nama_db_aapanel
     DB_USERNAME=user_db_aapanel
     DB_PASSWORD=password_db_aapanel
     ```
   - Jalankan setup basis data:
     ```bash
     php artisan siparoki:setup --force
     ```

6. **Atur Izin Folder (Permissions) & Pasang SSL**:
   - Jalankan perintah:
     ```bash
     chown -R www:www storage bootstrap/cache
     chmod -R 775 storage bootstrap/cache
     php artisan storage:link
     ```
   - Di pengaturan website aaPanel &rarr; Tab **SSL** &rarr; Let's Encrypt &rarr; Aktifkan sertifikat SSL gratis & centang **Force HTTPS**.

---

## 4. Metode 3: Instalasi di Shared Hosting cPanel

Jika paroki Anda menggunakan shared hosting standar cPanel:

1. **Buat Database MySQL di cPanel**:
   - Buka cPanel &rarr; Menu **MySQL Databases**.
   - Buat database baru (contoh: `u1234_siparoki`).
   - Buat user database dan password, lalu tautkan user tersebut ke database dengan hak akses **ALL PRIVILEGES**.

2. **Deploy Kode Sumber Menggunakan cPanel Git™ Version Control**:
   - Buka menu **Git™ Version Control** di cPanel &rarr; Klik **Create**.
   - Clone URL: `https://github.com/wensputra2026/siparoki2026laravelnew.git`
   - Repository Path: `repositories/siparoki`
   - Klik **Create**.

3. **Atur Struktur Direktori Web Publik**:
   - Pindahkan seluruh isi folder `public/` SIPAROKI ke dalam folder `public_html/`.
   - Buka berkas `public_html/index.php` dan pastikan path bootstrap Laravel mengarah ke direktori inti:
     ```php
     require __DIR__.'/../repositories/siparoki/vendor/autoload.php';
     $app = require_once __DIR__.'/../repositories/siparoki/bootstrap/app.php';
     ```

4. **Impor Database Master**:
   - Buka menu **phpMyAdmin** di cPanel.
   - Pilih database yang Anda buat.
   - Buka tab **Import**, pilih berkas **`database/siparoki.sql`** (atau gunakan `database/data/siparoki.sql.gz`), lalu klik **Go / Kirim**.

5. **Konfigurasi Berkas `.env`**:
   - Di File Manager, buat/edit berkas `.env` di folder utama aplikasi:
     ```env
     APP_NAME="SIPAROKI"
     APP_ENV=production
     APP_DEBUG=false
     APP_URL=https://namaparokianda.org

     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=u1234_siparoki
     DB_USERNAME=u1234_dbuser
     DB_PASSWORD=password_db_anda
     ```

6. **Generate Key & Clear Cache**:
   - Di menu **Terminal cPanel** (atau Cron Job 1x):
     ```bash
     php artisan key:generate --force
     php artisan storage:link
     php artisan optimize:clear
     ```

---

## 5. Metode 4: Instalasi di Server VPS Linux Murni (Ubuntu / Debian)

Untuk instalasi mandiri di terminal Ubuntu 22.04 / 24.04 LTS:

```bash
# 1. Update paket & clone repository
sudo apt update && sudo apt install -y git curl php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-bcmath nginx mysql-server

cd /var/www
sudo git clone https://github.com/wensputra2026/siparoki2026laravelnew.git siparoki
cd siparoki

# 2. Jalankan skrip setup
chmod +x setup.sh
./setup.sh

# 3. Sesuaikan koneksi database di .env
nano .env

# 4. Inisialisasi basis data SIPAROKI
php artisan siparoki:setup --force

# 5. Atur hak akses pengguna www-data
sudo chown -R www-data:www-data /var/www/siparoki/storage /var/www/siparoki/bootstrap/cache
sudo chmod -R 775 /var/www/siparoki/storage /var/www/siparoki/bootstrap/cache

# 6. Konfigurasi virtual host Nginx (/etc/nginx/sites-available/siparoki)
# Pastikan root diarahkan ke /var/www/siparoki/public
sudo nginx -t && sudo systemctl reload nginx
```

---

## 6. Langkah Wajib: Mengaktifkan Identitas Paroki Anda

Setelah SIPAROKI terpasang, data paroki secara bawaan adalah contoh template. Anda dapat mengubah seluruh identitas ke paroki Anda hanya dalam hitungan detik!

### 🌟 Pilihan A: Melalui Perintah CLI (Cepat 1 Detik)
SIPAROKI sudah memuat database master **493 Paroki se-Indonesia**. Cukup ketik nama paroki Anda:
```bash
php artisan paroki:set "Katedral Denpasar"
# atau
php artisan paroki:set "St. Fransiskus Asisi Singkawang"
# atau dengan ID Paroki jika Anda tahu nomor ID-nya:
php artisan paroki:set 120
```
Sistem akan langsung:
1. Mengubah nama paroki di header, footer, dan kop surat.
2. Mengaitkan nama Keuskupan, Kevikepan/Dekenat, dan Pastor Paroki aktif secara otomatis.
3. Membersihkan cache konfigurasi.

---

### 🌐 Pilihan B: Melalui Panel Web Admin (Visual)
1. Buka browser dan login ke **`http://domain-anda.org/login`** menggunakan akun Super Admin.
2. Klik menu **Profil Paroki** di bilah navigasi kiri (atau akses URL `/superadmin/profil-paroki`).
3. Pada tab **Ganti Paroki Dari Master KWI**:
   - Ketik nama paroki Anda pada kotak pencarian instan.
   - Pilih paroki Anda dari daftar hasil.
   - Klik **Simpan & Terapkan Identitas Paroki**.
4. Unggah logo paroki, foto pastor paroki, dan sesuaikan nomor WhatsApp sekretariat paroki.

---

## 7. Akun Login Bawaan & Reset Password

### Kredensial Default Super Admin:
- **URL Login**: `http://localhost:8000/login` atau `https://domain-anda.org/login`
- **Email**: `superadmin@paroki.org`
- **Password**: `Admin@Paroki2026!`
- **CAPTCHA**: Masukkan hasil penjumlahan matematika yang tampil di layar login.

### Cara Mereset Password Super Admin Kapan Saja:
Jika lupa kata sandi, jalankan perintah ini di terminal:
```bash
php artisan admin:reset email_baru@paroki.org PasswordBaru123!
```

---

## 8. Penyelesaian Masalah Umum (Troubleshooting)

### Q1: Error 500 "Internal Server Error" setelah instalasi?
- **Penyebab**: Folder `storage` dan `bootstrap/cache` tidak memiliki izin tulis (*write permission*).
- **Solusi**:
  ```bash
  chmod -R 775 storage bootstrap/cache
  # Di Windows/Laragon, pastikan web server memiliki akses Read/Write ke folder aplikasi.
  ```

### Q2: Error "No application encryption key has been specified"?
- **Penyebab**: `APP_KEY` belum terisi di berkas `.env`.
- **Solusi**:
  ```bash
  php artisan key:generate --force
  ```

### Q3: Gambar logo atau foto tidak tampil?
- **Penyebab**: Tautan symlink storage publik belum aktif.
- **Solusi**:
  ```bash
  php artisan storage:link
  ```

### Q4: Ingin mengosongkan seluruh data sensus umat dummy untuk mulai dari nol?
- **Solusi**: Jalankan perintah pembersih aman bawaan:
  ```bash
  php artisan siparoki:clean-data
  ```
  Perintah ini akan mengosongkan tabel umat, keluarga, mutasi, dan keuangan, namun tetap menjaga akun Super Admin dan master data keuskupan se-Indonesia tetap utuh!
