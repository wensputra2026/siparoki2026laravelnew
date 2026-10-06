# 📖 Panduan Pengguna & Pengoperasian SIPAROKI 2026

Panduan ini ditujukan bagi Pastor Paroki, Sekretariat, Pengurus Wilayah/Stasi/KUB, Bendahara, dan Tim Komsos dalam menjalankan operasional harian **SIPAROKI 2026**.

---

## 📑 Daftar Isi
1. [Struktur Hierarki Teritorial Paroki](#1-struktur-hierarki-teritorial-paroki)
2. [Manajemen Sensus Umat & Kartu Keluarga Katolik (KKK)](#2-manajemen-sensus-umat--kartu-keluarga-katolik-kkk)
3. [Pengelolaan & Pencatatan 7 Sakramen Gereja](#3-pengelolaan--pencatatan-7-sakramen-gereja)
4. [Konfigurasi Pembayaran Digital & Midtrans Snap](#4-konfigurasi-pembayaran-digital--midtrans-snap)
5. [Pengelolaan Warta, Berita, & Media Komsos](#5-pengelolaan-warta-berita--media-komsos)
6. [Pusat Keamanan & Manajemen Akun Pengguna](#6-pusat-keamanan--manajemen-akun-pengguna)
7. [Pencadangan & Pemulihan Database (Backup & Restore)](#7-pencadangan--pemulihan-database-backup--restore)

---

## 1. Struktur Hierarki Teritorial Paroki

Sebelum menginput data keluarga dan umat, pastikan struktur teritorial paroki Anda sudah terdaftar secara urut:
1. **Wilayah / Lingkungan**: Masuk ke menu **Master Wilayah** &rarr; Tambahkan nama-nama wilayah atau lingkungan pastoral paroki Anda.
2. **Stasi / Kapela**: Jika paroki Anda memiliki gereja stasi luar / kapela, daftarkan di menu **Master Stasi/Kapela** dan tautkan ke wilayah terkait.
3. **Komunitas Umat Basis (KUB)**: Daftarkan seluruh KUB di menu **Master KUB**, pilih lingkungan/wilayah dan stasi induknya.

*Fitur Mutual Filtering*: Saat formulir pendaftaran jemaat dibuka, pemilihan Wilayah akan secara cerdas memfilter daftar Stasi dan KUB yang relevan secara otomatis.

---

## 2. Manajemen Sensus Umat & Kartu Keluarga Katolik (KKK)

### A. Menambahkan Kartu Keluarga Katolik (KKK) Baru
1. Buka menu **Kartu Keluarga (KKK)** &rarr; Klik **Tambah KK**.
2. Masukkan Nomor Kartu Keluarga, nama kepala keluarga, alamat domisili, nomor telepon, serta pilih wilayah dan KUB.
3. Simpan data KK.

### B. Menambahkan Anggota Keluarga / Umat
1. Masuk ke detail KK yang telah dibuat &rarr; Klik **Tambah Anggota Keluarga**, atau buka menu **Data Umat** &rarr; **Tambah Umat**.
2. Lengkapi biodata umat:
   - Data Sipil: NIK, Nama Lengkap, Tempat & Tanggal Lahir, Jenis Kelamin, Golongan Darah, Pekerjaan, Pendidikan.
   - Data Gerejawi: Nama Baptis, Status Baptis, Tanggal & Tempat Baptis, Pastor Pembaptis, Status Komuni Pertama, Status Krisma/Penguatan, Status Perkawinan (Gereja/Sipil/Belum Menikah).
   - Talenta Pelayanan: Centang minat keterlibatan (Lektor, Pemazmur, Misdinar, Koor, Katekis, dll.).
3. Klik **Simpan**.

### C. Mencetak Lembar KKK Resmi
Pada halaman detail KK, klik tombol **Cetak Kartu Keluarga Katolik** untuk menghasilkan dokumen lembar KKK siap cetak dengan kop paroki dan tanda tangan resmi pastor paroki.

---

## 3. Pengelolaan & Pencatatan 7 Sakramen Gereja

SIPAROKI mendukung pencatatan ketujuh sakramen sesuai standar Kitab Hukum Kanonik (KHK):
- **Sakramen Baptis**: Mencatat nomor buku baptis (*Liber Baptizatorum*), tanggal penerimaan, nama ayah-ibu, wali baptis (*patrinus/matrina*), dan pastor pembaptis.
- **Sakramen Ekaristi / Komuni Pertama**: Pencatatan tanggal dan paroki penerimaan komuni suci pertama.
- **Sakramen Krisma / Penguatan**: Mencatat nomor *Liber Confirmatorum*, tanggal krisma, nama uskup yang mengurapi, dan nama pelindung krisma.
- **Sakramen Perkawinan**: Mencatat nomor *Liber Matrimoniorum*, tanggal kanonik, dispensasi nikah (bila beda gereja/beda agama), saksi pernikahan, dan pastor peneguh.
- **Pengajuan Sakramen Mandiri oleh Umat**: Umat yang telah memiliki akun mandiri dapat mengajukan pendaftaran sakramen secara daring dengan melampirkan foto dokumen pendukung. Sekretariat dapat meninjau dan mengubah status menjadi Disetujui/Ditolak.

---

## 4. Konfigurasi Pembayaran Digital & Midtrans Snap

SIPAROKI terintegrasi dengan **Midtrans Payment Gateway** untuk memfasilitasi persembahan, kolekte online, iuran KUB, dan intensi misa tanpa ribet.

### Cara Menghubungkan Akun Midtrans Paroki:
1. Masuk sebagai **Super Admin** &rarr; Buka menu **Integrasi Midtrans**.
2. Daftarkan akun gratis di [https://dashboard.midtrans.com](https://dashboard.midtrans.com).
3. Salin:
   - **Server Key**
   - **Client Key**
4. Masukkan kedua kunci tersebut ke pengaturan di panel admin SIPAROKI.
5. Atur mode ke **Sandbox** untuk uji coba, atau **Production** saat paroki siap menerima dana nyata.
6. Masukkan URL Webhook Paroki Anda ke dashboard Midtrans:
   `https://domain-paroki-anda.org/api/midtrans/webhook`
7. Sistem siap menerima pembayaran QRIS instan seluruh bank & dompet digital di Indonesia!

---

## 5. Pengelolaan Warta, Berita, & Media Komsos

Tim Komsos dan Penulis dapat mengelola konten website publik tanpa menyentuh kode program:
- **Warta & Artikel Paroki**: Buka menu **Warta & Artikel** &rarr; Buat artikel berita kegiatan, renungan mingguan, atau homili pastor paroki menggunakan editor teks kaya visual.
- **Galeri Foto**: Buka menu **Galeri** untuk mengunggah album dokumentasi kegiatan misa, hari raya, krisma, dan perayaan natal/paskah.
- **Video Dokumentasi**: Tautkan tautan YouTube atau unggah video misa online dan rekaman kegiatan paroki.
- **Moderasi Komentar**: Seluruh komentar publik disaring secara otomatis oleh filter kata kasar. Tim redaksi dapat menyetujui, menyembunyikan, atau menghapus komentar yang tidak pantas.

---

## 6. Pusat Keamanan & Manajemen Akun Pengguna

1. **Manajemen Akun Pengguna**:
   - Super Admin dapat membuat akun pengurus dan menetapkan peran sesuai level tanggung jawab (misalnya memberikan peran *Bendahara* hanya kepada pengurus keuangan).
2. **Pusat Keamanan (Security Center)**:
   - Pantau percobaan login yang mencurigakan di tab **Audit Log Keamanan**.
   - Konfigurasi proteksi brute force (jumlah maksimal gagal login sebelum akun diblokir sementara).
   - Pengaturan CAPTCHA (Simple CAPTCHA bawaan selalu aktif untuk mencegah bot otomatis).

---

## 7. Pencadangan & Pemulihan Database (Backup & Restore)

Untuk menjamin keamanan seluruh arsip sensus umat paroki:
1. Buka menu **Pencadangan Basis Data (Backup Database)** di panel Super Admin.
2. Klik tombol **Buat Cadangan Baru (Generate Backup)**.
3. Sistem akan menghasilkan berkas SQL terkompresi yang siap diunduh ke komputer Anda.
4. Anda dapat memulihkan (*restore*) database sewaktu-waktu cukup dengan mengunggah kembali berkas cadangan tersebut.
