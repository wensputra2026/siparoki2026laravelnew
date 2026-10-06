@echo off
REM ========================================================
REM   SIPAROKI 2026 - Pemasangan & Setup Otomatis Windows
REM ========================================================

echo ========================================================
echo    MEMULAI PEMASANGAN OTOMATIS SIPAROKI 2026 (WINDOWS)
echo ========================================================

REM 1. Salin file .env jika belum ada
if not exist .env (
    if exist .env.example (
        copy .env.example .env
        echo [+] File .env berhasil disalin dari .env.example
    ) else (
        echo [!] Peringatan: .env.example tidak ditemukan.
    )
) else (
    echo [*] File .env sudah ada.
)

REM 2. Install dependensi composer jika folder vendor belum ada atau ingin dipastikan
echo.
echo [+] Memeriksa & menginstal dependensi Composer...
call composer install --no-dev --optimize-autoloader

REM 3. Generate APP_KEY
echo.
echo [+] Memastikan APP_KEY terpasang...
call php artisan key:generate --force

REM 4. Jalankan Setup Otomatis Database, Migrasi, & Master Data
echo.
echo [+] Menjalankan instalasi database SIPAROKI (163 tabel, master data, akun superadmin)...
call php artisan siparoki:setup --force

REM 5. Tautan Penyimpanan Publik (Storage Link)
echo.
echo [+] Memastikan storage:link terhubung...
call php artisan storage:link

REM 6. Bersihkan & Optimalkan Cache Aplikasi
echo.
echo [+] Mengoptimalkan cache aplikasi...
call php artisan optimize:clear

echo.
echo ========================================================
echo    PEMASANGAN SELESAI & SISTEM SIAP DIGUNAKAN!
echo ========================================================
echo   URL Panel  : http://localhost:8000/login
echo   Email      : superadmin@paroki.org
echo   Password   : Admin@Paroki2026!
echo.
echo   Untuk mengaktifkan nama paroki Anda, jalankan:
echo   php artisan paroki:set "Nama Paroki Anda"
echo ========================================================
pause
