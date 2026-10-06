# 📚 Spesifikasi Teknis & Arsitektur Sistem SIPAROKI 2026

SIPAROKI (**Sistem Informasi & Manajemen Pastoral Paroki Terpadu**) adalah platform perangkat lunak tata kelola pastoral gerejawi berbasis web modern yang dirancang untuk seluruh gereja paroki Katolik di Indonesia di bawah naungan **Konferensi Waligereja Indonesia (KWI)**.

---

## 🛠️ 1. Arsitektur Teknologi (Technology Stack)

### Backend Framework
- **Framework Utama**: [Laravel 12.x](https://laravel.com/) (PHP Framework for Web Artisans)
- **Bahasa Pemrograman**: PHP `^8.2` (Mendukung PHP `8.2` dan `8.3+`)
- **Pola Arsitektur**: Model-View-Controller (MVC) + Trait-Driven Modular Domain Services + Single Page Application (SPA via Inertia.js).
- **Protokol Realtime**: Laravel Reverb `^1.11` (Pushover / WebSocket messaging).
- **Livewire**: Livewire `^3.8` (Komponen interaktif reaktif tambahan).
- **Export / Import**: Maatwebsite Excel `^3.1` (Pencetakan laporan spreadsheet data umat dan keuangan).
- **Penyimpanan Berkas Terkompresi**: Maennchen ZipStream `^3.1`.

### Frontend Stack
- **Adapter SPA**: [Inertia.js v2.0](https://inertiajs.com/) (Menghilangkan kebutuhan membangun REST API manual untuk routing UI).
- **Framework UI**: [Vue.js 3.x](https://vuejs.org/) (Composition API, `<script setup>`, Reactive State).
- **CSS Utility Framework**: [Tailwind CSS 3.x](https://tailwindcss.com/) dengan plugin Form & Typography.
- **Bundler & Build Tool**: [Vite 6.x](https://vitejs.dev/) dengan code splitting dan asset minification.
- **Komponen Interaktif Khusus**:
  - `SearchableSelect`: Dropdown pencarian instan dengan caching data lokal untuk daftar ribuan pilihan.
  - `RichTextEditor`: Editor teks kaya HTML untuk warta paroki, artikel, dan pengumuman.
  - `ConfirmationModal`: Modal konfirmasi aksi aman sebelum penghapusan data penting.
  - `Midtrans Snap JS`: Popup pembayaran multi-kanal dinamis terintegrasi.

---

## 🗄️ 2. Arsitektur Basis Data (Database Architecture)

- **Database Engine**: MySQL 5.7+ / MySQL 8.0+ / MariaDB 10.3+.
- **Karakter Set & Collation**: `utf8mb4` / `utf8mb4_unicode_ci` (Dukungan penuh emoji, karakter multilingual, dan teks Latin gerejawi).
- **Jumlah Tabel**: **163 Tabel Terstruktur** yang terbagi dalam klaster modular:

### Klaster Tabel Database:
1. **Hierarki Gereja Nasional (KWI)**:
   - `keuskupan`: 39 Keuskupan Agung & Sufragan se-Indonesia.
   - `dekenat`: Kevikepan / Dekenat di setiap keuskupan.
   - `paroki`: 493 Paroki terdaftar di Indonesia lengkap dengan alamat dan nama pastor aktif.
   - `kuasi_paroki`: Wilayah bakal paroki.
   - `master_pastor`: Direktori imam/pastor, gelar, ordo, dan riwayat penugasan pastoral.
   - `master_ordo`: Kongregasi / Tarekat religius (SVD, SJ, OFM, MSF, CSsR, Pr/Projo, dll.).
   - `master_uskup`: Daftar Uskup Diosesan dan Uskup Emeritus.

2. **Teritori Pastoral Paroki**:
   - `wilayah`: Wilayah pastoral / Lingkungan paroki.
   - `kapela` / `stasi_kapela`: Gereja stasi luar / kapela cabang.
   - `kub` / `kubs`: Komunitas Umat Basis.

3. **Data Umat & Sensus Pastoral**:
   - `kk_katolik`: Kartu Keluarga Katolik (KKK), Nomor KKK, Kepala Keluarga, Status Ekonomi, Alamat.
   - `umat`: Buku Induk Umat Katolik (NIK, Nama Lengkap, Nama Baptis, Tempat Lahir, Tgl Lahir, Jenis Kelamin, Golongan Darah, Pekerjaan, Pendidikan, Status Baptis, Status Komuni, Status Krisma, Status Perkawinan, Talenta).
   - `anggota_keluarga`: Hubungan relasi keluarga di dalam KKK.
   - `riwayat_mutasi_umat` / `mutasi_umat`: Perpindahan domisili jemaat antar-KUB, antar-Stasi, maupun antar-Paroki.

4. **Tujuh Sakramen Gereja (Kitab Hukum Kanonik)**:
   - `sakramen`: Master registrasi penerimaan sakramen.
   - `sakramen_umat` / `sakramen_verifikasi`: Verifikasi berkas akta sakramen dan persetujuan pastoral.
   - `pengajuan_sakramen`: Pengajuan online berkas sakramen mandiri oleh umat.
   - Buku Akta Registrasi (*Liber Baptizatorum*, *Liber Confirmatorum*, *Liber Matrimoniorum*, *Liber Defunctorum*).

5. **Keuangan, Aset & Midtrans**:
   - `midtrans_transactions`: Log transaksi payment gateway Midtrans Snap (QRIS, VA, E-Wallet, Kartu).
   - `transaksi_pembayaran` / `iuran`: Pencatatan tagihan iuran KUB dan tanda bukti pembayaran.
   - `kolekte`: Pencatatan kolekte misa pertama, kedua, dan intensi khusus.
   - `kas_rekening` / `keuangan`: Buku kas besar paroki, mutasi debet/kredit, dan saldo rekening bank.
   - `aset` / `kategori_aset` / `aset_maintenance`: Inventaris tanah, bangunan gereja, perlengkapan liturgi, dan log pemeliharaan aset.

6. **Warta Paroki, Liturgi & Media Komunikasi**:
   - `konten` / `kategori_konten`: Berita paroki, renungan harian, dan warta mingguan.
   - `komentar_artikel`: Komentar publik dengan filter sensor kata kasar otomatis.
   - `jadwal_misa` / `misa_kapela`: Jadwal misa gereja pusat dan kapela stasi.
   - `jadwal_petugas_liturgi`: Petugas lektor, pemazmur, koor, putri/putra altar, misdinar, dan prodiakon.
   - `galeri` / `galeri_album` / `galeri_item`: Dokumentasi foto kegiatan pastoral.
   - `video`: Tautan video profil, streaming perayaan ekaristi, dan warta video.
   - `arsip_digital`: Unduhan formulir administrasi dan warta paroki digital (PDF).

7. **Keamanan, Hak Akses & Sistem**:
   - `users`: Akun pengguna terotentikasi.
   - `roles`: 9 Peran berbasis RBAC (*Role-Based Access Control*).
   - `security_settings`: Konfigurasi CAPTCHA, brute force limit, session timeout, dan lockout.
   - `login_attempts` / `login_activity` / `security_logs`: Audit trail keamanan sistem.
   - `backup_database`: Riwayat dan berkas unduhan pencadangan basis data.
   - `pengaturan_aplikasi` / `profil_paroki`: Konfigurasi identitas paroki aktif.

---

## 🔐 3. Matriks Hak Akses (9 Peran Multi-Level RBAC)

| ID | Nama Peran | Slug Role | Level Akses | Lingkup Tanggung Jawab |
|:--:|---|---|:--:|---|
| **1** | **Super Admin** | `superadmin` | Level 1 | Akses mutlak sistem, konfigurasi paroki, manajemen akun pengguna, backup database, security center, integrasi Midtrans. |
| **2** | **Admin Paroki** | `admin_paroki` | Level 2 | Tata usaha & sekretariat paroki, verifikasi sensus umat, pembuatan KKK, administrasi surat sakramen, pengelolaan jadwal misa. |
| **3** | **Pastor Paroki** | `pastor` | Level 3 | Pastor Paroki & Pastor Rekan: Persetujuan sakramen, verifikasi dispensasi perkawinan, laporan pastoral, buku kas paroki, sambutan. |
| **4** | **Admin Wilayah** | `admin_wilayah` | Level 4 | Koordinator Wilayah Rohani: Pemantauan data umat dan KUB di wilayahnya. |
| **5** | **Admin Kapela / Stasi** | `admin_kapela` | Level 5 | Pengurus Kapela / Gereja Stasi Luar: Data jemaat stasi, jadwal peribadatan kapela, inventaris stasi. |
| **6** | **Ketua KUB** | `ketua_kub` | Level 6 | Pengurus Komunitas Umat Basis: Pendaftaran dan validasi warga basis, verifikasi iuran warga basis, pendataan keluarga baru. |
| **8** | **Penulis / Komsos** | `penulis` | Level 8 | Tim Komunikasi Sosial (Komsos): Penulisan warta, artikel renungan, pengumuman, pengunggahan galeri & video dokumentasi. |
| **9** | **Bendahara** | `bendahara` | Level 9 | Pengelolaan kas paroki, verifikasi pembayaran manual, mutasi rekening, dan laporan neraca keuangan. |
| **-** | **Umat Mandiri** | `umat` | Publik/User | Akses mandiri jemaat untuk memeriksa data NIK KKK digital, pendaftaran sakramen online, dan pembayaran iuran via Midtrans QRIS. |

---

## 💳 4. Spesifikasi Integrasi Midtrans Snap

- **Protokol Komunikasi**: HTTPS REST API + Snap JS SDK + Webhook Notification Handler.
- **Metode Pembayaran Didukung**:
  1. **QRIS Dinamis**: BCA QRIS, Gopay QRIS, ShopeePay QRIS, Nobu QRIS (Mendukung seluruh aplikasi mobile banking & e-wallet di Indonesia).
  2. **Virtual Account (VA)**: BCA, Mandiri Bill, BNI, BRI, Permata, CIMB Niaga.
  3. **Direct E-Wallet**: GoPay & ShopeePay App Redirect.
  4. **Over-The-Counter (OTC)**: Alfamart & Indomaret.
  5. **Kartu Kredit & Debit**: Visa, Mastercard, JCB (3D Secure).
- **Validasi Keamanan Webhook**:
  - Hash Signature SHA512: `SHA512(order_id + status_code + gross_amount + server_key)`.
  - Pencegahan pemalsuan status (*Idempotency check*): Hanya memperbarui status jika hash terverifikasi sah.
  - Otomatis memperbarui kolom `status_pembayaran` menjadi `lunas` dan memicu pencatatan jurnal kas paroki.

---

## 🛡️ 5. Spesifikasi Keamanan (Security Suite)

1. **Proteksi Brute-Force Login**:
   - Membatasi percobaan login salah (default: 5 kali).
   - Pemblokiran sementara (lockout) selama waktu terkonfigurasi.
2. **CAPTCHA Bawaan Aktif**:
   - Proteksi Simple CAPTCHA matematika langsung aktif pada instalasi baru.
   - Opsi integrasi Google reCAPTCHA v2 / v3 atau Turnstile Cloudflare via panel Security Center.
3. **Penyimpanan Kredensial**:
   - Enkripsi kata sandi menggunakan algoritma **Bcrypt** dengan work factor dinamis (12 rounds).
4. **Proteksi CSRF**:
   - Semua formulir dan mutasi POST/PUT/DELETE dilindungi token CSRF otomatis dari Laravel 12.
5. **Sanitasi Konten & Filter Komentar**:
   - Pembersihan input HTML terhadap serangan XSS (*Cross-Site Scripting*).
   - Sensor otomatis kata makian/kata kasar pada kolom komentar publik.
6. **Backup Database Terenkripsi**:
   - Generator backup SQL terintegrasi untuk mencadangkan database secara berkala langsung dari dashboard admin.
