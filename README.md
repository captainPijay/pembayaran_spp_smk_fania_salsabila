# Aplikasi Pembayaran SPP Dengan Laravel 10
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
## Langkah-langkah Instalasi

1. **Clone Project**

    - Clone project dari repository dengan menggunakan perintah berikut:
        ```bash
        git clone https://github.com/captainPijay/pembayaran_spp_smk_fania_salsabila.git
        ```

2. **Install Composer Dependencies**

    - Jalankan perintah berikut untuk menginstal semua dependensi yang diperlukan:
        ```bash
        composer install
        ```
3. **Install NPM Dependencies**

    - Jalankan perintah berikut untuk menginstal semua dependensi yang diperlukan:
        ```bash
        npm install
        ```

3. **Copy dan Paste File .env**

    - Salin semua data dari file `.env.example` dan tempelkan di file `.env`:
        ```bash
        cp .env.example .env
        ```

4. **Generate Project Key**

    - Jalankan perintah berikut untuk menghasilkan kunci proyek:
        ```bash
        php artisan key:generate
        ```
        
5. **Migrate Database**

    - Jalankan perintah berikut untuk migrasi database:
        ```bash
        php artisan migrate
        ```
    - Jalankan perintah berikut untuk melakukan seeding default user:
        ```bash
        php artisan db:seed --class="IndoBankSeeder"
        ```
        ```bash
        php artisan db:seed
        ```
6. **Konfigurasi Symbolic Link**

    - Jalankan perintah berikut untuk konfigurasi symbolic link:
        ```bash
        php artisan storage:link
        ```

7. **Jalankan Server Lokal**
    - Terakhir, jalankan perintah berikut untuk menjalankan proyek secara lokal:
        ```bash
        php artisan serve
        ```
   - Setelah itu buka terminal baru dan jalankan:
        ```bash
        npm run dev
        ```
   - Terakhir itu buka terminal baru dan jalankan:
        ```bash
        php artisan queue:listen --timeout=0
        ```
    - Proyek akan berjalan di `http://localhost:8000 || http://127.0.0.1:8000/` secara default.
8. **Login**
    - Login menggunakan akun operator dengan email dan password berikut:
        - email: *cek di DatabaseSeeder*
        - password: *cek di DatabasesSeeder*
## Catatan

-   Pastikan Anda memiliki PHP, Composer, dan Laravel CLI yang terinstal di sistem Anda sebelum menjalankan langkah-langkah di atas.
-   Pastikan juga Anda memiliki database yang sudah terbuat dan konfigurasi yang sesuai di file `.env`.
-   Pastikan juga Anda telah mengaktifkan extension=zip di php.ini.
-   Pastikan juga Anda telah mengaktifkan extension=gd di php.ini.
