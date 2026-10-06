# SIPAROKI &bull; Sistem Informasi &amp; Manajemen Pastoral Paroki Terpadu

<p align="center">
  <img src="docs/images/logo-siparoki.png" alt="SIPAROKI Logo" width="180" />
</p>

<p align="center">
  <strong>Platform Digital Universal Gereja Katolik Tingkat Paroki se-Indonesia</strong><br>
  <em>Solusi Modern Manajemen Umat, Kartu Keluarga Katolik (KKK), 7 Sakramen Gereja (KHK), Multi-Payment Gateway Midtrans Snap, Akuntansi &amp; Keuangan, Warta Paroki, dan Pelayanan Pastoral Berbasis Web Terpadu.</em>
</p>

<p align="center">
  <a href="https://github.com/wensputra2026/siparoki2026laravelnew"><img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12" /></a>
  <a href="https://github.com/wensputra2026/siparoki2026laravelnew"><img src="https://img.shields.io/badge/Inertia.js-2.x-9553E9?style=for-the-badge&logo=inertia&logoColor=white" alt="Inertia.js" /></a>
  <a href="https://github.com/wensputra2026/siparoki2026laravelnew"><img src="https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white" alt="Vue 3" /></a>
  <a href="https://github.com/wensputra2026/siparoki2026laravelnew"><img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" /></a>
  <a href="https://github.com/wensputra2026/siparoki2026laravelnew"><img src="https://img.shields.io/badge/Midtrans-Snap_Payment-002855?style=for-the-badge&logo=visa&logoColor=white" alt="Midtrans Snap" /></a>
  <a href="https://github.com/wensputra2026/siparoki2026laravelnew"><img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+" /></a>
  <a href="https://github.com/wensputra2026/siparoki2026laravelnew"><img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" /></a>
  <a href="https://github.com/wensputra2026/siparoki2026laravelnew/blob/main/LICENSE"><img src="https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge" alt="License MIT" /></a>
</p>

---

## 🌟 Tentang SIPAROKI

**SIPAROKI (Sistem Informasi Paroki Terpadu)** adalah ekosistem aplikasi sistem informasi gerejawi komprehensif generasi terbaru berbasis **Laravel 12**, **Inertia.js v2**, dan **Vue 3 Composition API**. Aplikasi ini dirancang secara khusus untuk mendigitalkan, menertibkan, dan mengoptimalkan seluruh alur pelayanan pastoral gereja Katolik di Indonesia.

### 🏛️ Universal Multi-Parish Ready (Siap Pakai untuk Seluruh Paroki di Indonesia)
Repositori ini bersifat **Universal Template**. Artinya, paroki mana pun di seluruh Indonesia dapat langsung mengklon dan memasang aplikasi ini. Sistem sudah memuat **database master nasional Konferensi Waligereja Indonesia (KWI)**:
- **39 Keuskupan Agung & Sufragan se-Indonesia**
- **Seluruh Kevikepan / Dekenat**
- **493 Paroki Terdaftar se-Indonesia** (lengkap dengan alamat, dekenat, dan nama pastor paroki)
- **Master Kongregasi/Ordo Religius** (SVD, SJ, OFM, MSF, CSsR, Pr/Diosesan, dll.)
- **Buku Akta Sakramen (*Liber Sacramenta*)** sesuai Kitab Hukum Kanonik (KHK).

Setelah diklon, paroki lain cukup menjalankan **satu perintah** (`php artisan paroki:set "Nama Paroki Anda"`) atau memilih lewat panel web untuk langsung mengaktifkan identitas paroki mereka sendiri tanpa perlu mengubah baris kode program!

---

## 📚 Dokumentasi Terperinci

Untuk panduan mendalam, silakan baca dokumentasi berikut:
- 🚀 [**Panduan Lengkap Instalasi & Deployment**](docs/PANDUAN_INSTALASI.md) *(Windows Laragon/XAMPP, cPanel, aaPanel, dan VPS Linux)*
- ⚙️ [**Spesifikasi Teknis & Arsitektur Sistem**](docs/SPESIFIKASI_TEKNIS.md) *(Teknologi, Database 163 Tabel, Security, Midtrans)*
- 📖 [**Panduan Pengguna & Pengoperasian Harian**](docs/PANDUAN_PENGGUNA.md) *(Buku panduan Pastor Paroki, Sekretariat, dan Bendahara)*

---

## ✨ Fitur-Fitur Unggulan

### 1. 👨‍👩‍👧‍👦 Sensus Umat & Kartu Keluarga Katolik (KKK Digital)
- **Komponen Pencarian Instan (`SearchableSelect`)**: Pengisian data pekerjaan, pendidikan, golongan darah, pastor pembaptis, status ekonomi, dan relasi keluarga sangat cepat dan terstandardisasi.
- **Mutual Filtering Wilayah & KUB**: Pemilihan Wilayah secara otomatis memfilter Stasi/Kapela dan Komunitas Umat Basis (KUB) yang sesuai.
- **Buku Induk Umat**: Pencatatan NIK, nama baptis, data kelahiran, status perkawinan, dan talenta pelayanan pastoral.
- **Cetak Lembar KKK Resmi**: Format cetak Kartu Keluarga Katolik resmi dengan kop gereja dan tanda tangan pastor paroki.

### 2. 🕊️ Pencatatan & Permohonan 7 Sakramen Gereja (KHK)
- **Sakramen Inisiasi**: Baptis (Bayi/Dewasa/Receptio), Krisma/Penguatan, dan Ekaristi (Komuni Pertama).
- **Sakramen Penyembuhan**: Tobat/Rekonsiliasi dan Pengurapan Orang Sakit (Minyak Suci).
- **Sakramen Panggilan & Persekutuan**: Perkawinan Katolik dan Tahbisan Imamat.
- **Buku Akta Gereja**: Penomoran resmi jilid, halaman, dan akta pada *Liber Baptizatorum*, *Liber Confirmatorum*, dan *Liber Matrimoniorum*.
- **Permohonan Mandiri Daring**: Umat dapat mengajukan permohonan sakramen secara online dan memantau status verifikasi.

### 3. 💳 Multi-Payment Gateway Midtrans Snap & QRIS Dinamis
- **Kanal Pembayaran Terlengkap**:
  - **QRIS Dinamis**: Scan langsung via BCA Mobile, Livin' Mandiri, BRImo, BNI Mobile, GoPay, OVO, Dana, ShopeePay, LinkAja (nominal otomatis pas).
  - **Virtual Account (VA)**: BCA, Mandiri Bill, BNI, BRI, Permata, CIMB Niaga.
  - **Direct E-Wallet**: Pembayaran instan via aplikasi GoPay dan ShopeePay.
  - **Gerai Minimarket**: Bayar tunai via kasir Alfamart dan Indomaret.
  - **Kartu Kredit / Debit**: Visa, Mastercard, JCB (3D Secure).
- **Auto-Settlement Webhook Real-time**: Verifikasi tanda tangan digital SHA512 dan konfirmasi lunas otomatis detik itu juga tanpa perlu mutasi rekening manual.
- **Dukungan Pembayaran Manual**: Tetap mendukung rekening bank transfer manual dan gambar QRIS statis paroki.

### 4. 🛡️ Pusat Keamanan Sistem & Firewall
- **Brute Force Protection**: Pembatasan otomatis percobaan login salah (default: 5 kali) dan penguncian akun sementara.
- **Simple CAPTCHA Bawaan Aktif**: Sistem keamanan CAPTCHA langsung aktif saat instalasi baru untuk mencegah serangan robot/brute force.
- **Audit Log Keamanan**: Pencatatan riwayat login, alamat IP, user-agent, dan aktivitas perubahan data krusial.
- **Multi-Level RBAC**: Pembatasan 9 peran pengguna dengan prinsip *Least Privilege Access* dan password terenkripsi Bcrypt.

### 5. 💾 Backup & Restore Database Terpadu
- **Pencadangan 1-Klik**: Menghasilkan salinan SQL terkompresi langsung dari panel admin.
- **Pemulihan Instan**: Pemulihan basis data kapan saja melalui pengunggahan berkas cadangan.

### 6. 📰 Warta Paroki, Liturgi & Informasi Publik
- **Jadwal Misa Interaktif**: Penayangan jadwal perayaan ekaristi harian, mingguan, hari raya, dan misa stasi luar.
- **Jadwal Petugas Liturgi**: Pengelolaan jadwal lektor, pemazmur, koor, dan prodiakon.
- **Editor Teks Kaya (RichTextEditor)**: Pembuatan berita kegiatan, renungan mingguan, dan pengumuman pastoral.
- **Sensor Otomatis Kata Kasar**: Penyaringan otomatis terhadap kata makian dan kata tidak pantas pada kolom komentar artikel publik.

---

## 👥 Matriks 9 Peran Pengguna (Role-Based Access)

| Role | Prefix URL | Cakupan Akses & Tanggung Jawab |
|---|---|---|
| **Super Admin** | `/superadmin` | Akses penuh sistem, manajemen pengguna, konfigurasi identitas paroki, Midtrans gateway, backup database, security center. |
| **Pastor Paroki** | `/pastor` | Persetujuan sakramen, verifikasi data umat, laporan pastoral, jadwal misa, sambutan, buku kas paroki. |
| **Admin Paroki** | `/paroki` | Tata usaha & sekretariat, pendaftaran sakramen, kartu keluarga (KKK), data umat, aset, surat-menyurat. |
| **Admin Wilayah** | `/wilayah` | Pemantauan data umat, KKK, dan kegiatan pada tingkat Wilayah / Lingkungan pastoral. |
| **Admin Kapela / Stasi** | `/kapela` | Pengelolaan data jemaat stasi luar, jadwal peribadatan kapela, inventaris stasi. |
| **Pengurus KUB** | `/kub` | Pendataan warga basis KUB, iuran komunitas basis, dan validasi anggota keluarga. |
| **Bendahara** | `/bendahara` | Pengelolaan transaksi keuangan, verifikasi bukti transfer/QRIS, konfirmasi Midtrans, buku kas, dan laporan keuangan. |
| **Penulis / Komsos** | `/penulis` | Publikasi berita, artikel renungan, pengumuman, galeri media, slider banner, dan moderasi komentar publik. |
| **Umat Mandiri** | `/umat` | Akses portal umat mandiri untuk cek data KKK digital, pengajuan sakramen online, dan pembayaran iuran via QRIS. |

---

## 📋 Persyaratan Sistem (System Requirements)

- **PHP**: Versi `8.2` atau `8.3+`
- **Database**: MySQL `5.7+` / MySQL `8.0+` atau MariaDB `10.3+`
- **Ekstensi PHP Wajib**:
  - `pdo_mysql`, `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd`, `curl`, `zip`
- **Composer**: Versi `2.x+`
- **Web Server**: Apache (`mod_rewrite` aktif), Nginx, atau OpenLiteSpeed
- **Node.js & NPM** *(Opsional)*: Versi `18+` (Aset JavaScript/CSS siap pakai sudah dikompilasi di `public/build/`).

---

## 🚀 Panduan Instalasi Cepat (Quick Installation)

Pilih salah satu metode instalasi yang paling sesuai dengan komputer atau server Anda:

---

### 💻 Jalur A: Pengguna Windows (Laragon / XAMPP) &mdash; Paling Cepat 1-Klik

1. **Buka terminal** di folder web server Anda:
   - Jika menggunakan **Laragon**: buka `C:\laragon\www\`
   - Jika menggunakan **XAMPP**: buka `C:\xampp\htdocs\`

2. **Klon Repositori**:
   ```bash
   git clone https://github.com/wensputra2026/siparoki2026laravelnew.git siparoki
   cd siparoki
   ```

3. **Buat Database Kosong** di phpMyAdmin atau HeidiSQL:
   - Nama database: `siparoki_db` (Collation: `utf8mb4_unicode_ci`)

4. **Jalankan Skrip Setup Otomatis (1-Klik)**:
   - Cukup **klik dua kali `setup.bat`** atau jalankan di Command Prompt:
     ```cmd
     setup.bat
     ```
   *(Skrip akan otomatis menyalin .env, mengunduh dependensi Composer, membuat APP_KEY, mengimpor 163 tabel & master data nasional KWI, symlink storage, dan mengoptimalkan cache).*

5. **Jalankan Aplikasi**:
   ```bash
   php artisan serve
   ```
   Akses di browser: 👉 **`http://127.0.0.1:8000/login`**

---

### 🐧 Jalur B: Pengguna Linux / VPS aaPanel &mdash; Skrip Otomatis

1. **Klon Repositori ke Folder Web**:
   ```bash
   cd /var/www  # atau direktori website aaPanel: /www/wwwroot/domain-anda.org
   git clone https://github.com/wensputra2026/siparoki2026laravelnew.git .
   ```

2. **Jalankan Skrip Setup Otomatis Linux**:
   ```bash
   chmod +x setup.sh
   ./setup.sh
   ```

3. **Sesuaikan Kredensial Database di `.env`**:
   ```env
   DB_DATABASE=nama_db_anda
   DB_USERNAME=user_db_anda
   DB_PASSWORD=password_db_anda
   ```

4. **Jalankan Setup Database**:
   ```bash
   php artisan siparoki:setup --force
   ```

5. **Atur Izin Folder (Permissions) & Symlink**:
   ```bash
   chown -R www:www storage bootstrap/cache   # (atau www-data:www-data di Ubuntu/Debian)
   chmod -R 775 storage bootstrap/cache
   php artisan storage:link
   ```

---

### ⚙️ Jalur C: Instalasi Standar Manual (Composer & Artisan)

Bagi pengembang yang ingin menjalankan langkah demi langkah:

```bash
# 1. Klon repositori
git clone https://github.com/wensputra2026/siparoki2026laravelnew.git
cd siparoki2026laravelnew

# 2. Install dependensi PHP
composer install --no-dev --optimize-autoloader

# 3. Siapkan file konfigurasi lingkungan
cp .env.example .env
php artisan key:generate

# 4. Sesuaikan database di berkas .env, lalu inisialisasi database SIPAROKI
php artisan siparoki:setup --force

# 5. Hubungkan storage & bersihkan cache
php artisan storage:link
php artisan optimize:clear

# 6. Jalankan server lokal
php artisan serve
```

---

## 🏛️ Langkah Wajib: Mengaktifkan Identitas Paroki Anda

Setelah instalasi selesai, data paroki bawaan adalah contoh template. Anda dapat mengganti identitas paroki ke paroki Anda sendiri dalam 5 detik!

### Cara 1: Menggunakan Perintah CLI (Cepat 1 Detik)
SIPAROKI sudah memuat direktori **493 Paroki se-Indonesia**. Cukup ketik nama paroki Anda:
```bash
php artisan paroki:set "Katedral Denpasar"
# atau
php artisan paroki:set "St. Fransiskus Asisi Singkawang"
# atau dengan nomor ID Paroki jika Anda tahu nomornya:
php artisan paroki:set 380
```
Sistem akan otomatis:
- Menyesuaikan nama paroki di website, kop surat, dan invoice.
- Menautkan nama Keuskupan, Kevikepan/Dekenat, dan nama Pastor Paroki aktif.
- Membersihkan cache aplikasi.

---

### Cara 2: Menggunakan Tampilan Panel Web Admin
1. Buka browser dan login ke **`http://127.0.0.1:8000/login`** dengan akun Super Admin.
2. Klik menu **Profil Paroki** di navigasi kiri (atau akses URL `/superadmin/profil-paroki`).
3. Pada tab **Ganti Paroki Dari Master KWI**:
   - Ketik nama paroki Anda pada kotak pencarian instan.
   - Pilih paroki Anda dari daftar hasil.
   - Klik **Simpan & Terapkan Identitas Paroki**.
4. Anda juga dapat mengunggah logo paroki resmi, foto gereja, banner, dan foto pastor paroki.

---

## 🔑 Kredensial Login Bawaan & Reset Password

Setelah instalasi berhasil, gunakan akun bawaan Super Admin berikut:
- **URL Login**: `http://localhost:8000/login`
- **Email**: `superadmin@paroki.org`
- **Password**: `Admin@Paroki2026!`
- **CAPTCHA**: Masukkan hasil penjumlahan matematika yang tampil di formulir login.

### Cara Mereset Password Super Admin Kapan Saja:
Jika Anda lupa kata sandi atau ingin membuat akun admin baru, jalankan perintah ini di terminal:
```bash
php artisan admin:reset admin@paroki.org PasswordBaru123!
```

---

## 🔄 Panduan Update Otomatis (Saat Ada Rilis Fitur Baru)

Ketika ada perbaikan atau penambahan fitur baru di repositori GitHub, paroki dapat melakukan pembaruan tanpa kehilangan data database jemaat maupun konfigurasi yang sudah berjalan:

```mermaid
flowchart LR
    A["Rilis Pembaruan di GitHub"] --> B["Tarik Kode Terbaru (git pull)"]
    B --> C["Jalankan Migrasi Skema (php artisan migrate)"]
    C --> D["Bersihkan Cache (php artisan optimize:clear)"]
    D --> E["Sistem Terupdate & Data Umat 100% Aman!"]
```

### Di Server / Terminal:
```bash
git pull origin main
php artisan migrate --force
php artisan optimize:clear
```

### Di cPanel Shared Hosting:
Buka menu **cPanel &rarr; Git™ Version Control &rarr; Manage &rarr; Pull or Deploy &rarr; Update from Remote**.

---

## 🛠️ Perintah Artisan Khusus SIPAROKI

SIPAROKI dilengkapi sejumlah perintah CLI khusus untuk mempermudah administrator server:

| Perintah Artisan | Deskripsi & Fungsi |
|---|---|
| `php artisan siparoki:setup {--force}` | Inisialisasi otomatis 163 tabel skema database, master data nasional KWI, akun superadmin, storage link, dan optimasi cache. |
| `php artisan paroki:set {keyword}` | Mengubah paroki aktif dari direktori 493 paroki nasional KWI berdasarkan nama atau ID paroki. |
| `php artisan admin:reset {email} {password}` | Mereset atau membuat akun Super Administrator baru secara langsung dari terminal. |
| `php artisan siparoki:clean-data` | Mengosongkan seluruh data sensus umat dummy/lokal paroki secara aman (menjaga akun superadmin dan master hierarki tetap utuh). |

---

## 📁 Struktur Direktori Utama

```plaintext
siparoki/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controller (Auth, Panel, ProfilParoki, MidtransController, dll.)
│   │   │   ├── Concerns/      # Trait domain (BackupModuleTrait, KkModuleTrait, GenericModuleTrait)
│   │   │   └── Webhook/       # Webhook Handler (GitHubDeployController, Midtrans Webhook)
│   │   └── Middleware/        # Middleware (PanelAccess, EnsureParokiConfigured, Captcha, dll.)
│   ├── Models/                # Eloquent Models (Umat, KK, Sakramen, Midtrans, Paroki, Keuskupan)
│   └── Services/              # Domain Services (MidtransService, GenericModuleService)
├── bootstrap/                 # Inisialisasi aplikasi Laravel 12 & exception handling
├── database/
│   ├── data/                  # Berkas baseline SQL & master JSON Keuskupan/Paroki se-Indonesia
│   ├── migrations/            # Berkas migrasi database
│   ├── seeders/               # Database seeders (Hierarki KWI, Roles, SuperAdmin)
│   └── siparoki.sql           # Master database siap import (163 tabel + master nasional)
├── docs/                      # Dokumentasi komprehensif
│   ├── PANDUAN_INSTALASI.md   # Panduan instalasi multi-platform terperinci
│   ├── SPESIFIKASI_TEKNIS.md  # Spesifikasi teknis & arsitektur sistem
│   └── PANDUAN_PENGGUNA.md    # Panduan penggunaan & operasional gereja
├── public/
│   ├── build/                 # Hasil build aset produksi Vite (Vue 3, Inertia, Tailwind)
│   ├── uploads/               # Direktori berkas unggahan publik (logo paroki, foto pastor)
│   └── index.php              # Front controller publik
├── resources/
│   ├── js/                    # Komponen Vue 3 & Halaman Inertia (SearchableSelect, AppLayout, dll.)
│   └── views/                 # Blade templates (Halaman publik, portal warta, login)
├── routes/
│   ├── web.php                # Seluruh rute navigasi publik & panel administrasi
│   └── console.php            # Perintah artisan bawaan (siparoki:setup, paroki:set, admin:reset)
├── setup.bat                  # Skrip instalasi otomatis 1-klik untuk Windows (Laragon/XAMPP)
└── setup.sh                   # Skrip instalasi otomatis 1-klik untuk Linux / aaPanel
```

---

## 🤝 Kontribusi & Dukungan

Aplikasi ini dikembangkan dan didedikasikan secara terbuka untuk mendukung transformasi digital pastoral gereja Katolik di seluruh Indonesia. Saran, laporan masalah (*issue*), maupun kontribusi kode (*pull request*) sangat dipersilakan.

- **Repositori GitHub**: [https://github.com/wensputra2026/siparoki2026laravelnew](https://github.com/wensputra2026/siparoki2026laravelnew)
- **Author / Pengembang**: Tim Pengembang SIPAROKI

---

## 📄 Lisensi (License)

SIPAROKI dirilis di bawah lisensi terbuka [MIT License](LICENSE). Anda bebas mengklon, menggunakan, memodifikasi, dan mendistribusikan aplikasi ini untuk seluruh paroki dan keuskupan di Indonesia.

---
<p align="center">
  <em>"Melayani dengan Kasih dan Menata Pelayanan Pastoral Secara Terpadu."</em><br>
  <strong>SIPAROKI &copy; 2026</strong>
</p>
