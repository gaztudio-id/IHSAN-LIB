# 📚 IHSAN-LIB (Digital Library System)

**IHSAN-LIB** adalah sistem informasi perpustakaan digital modern yang dirancang untuk memudahkan pengelolaan perpustakaan sekolah/pesantren. Sistem ini mencakup portal untuk anggota (santri), dashboard staff, dan panel administrasi lengkap.

![IHSAN-LIB Banner](public/logo_ibs.png)

## ✨ Fitur Utama

### 🖥️ Public Landing Page
- Halaman depan informatif dengan pencarian katalog sederhana.
- Fitur "Staff Gate" untuk login cepat staff/admin.
- Integrasi Modal Login Anggota dan Staff.

### 👤 Portal Anggota (Santri)
- **Dashboard Personal**: Melihat status peminjaman aktif, riwayat kunjungan, dan poin pelanggaran.
- **Katalog Digital**: Pencarian buku dan cek ketersediaan.
- **Kartu Anggota Digital**: Menampilkan profil dan barcode/QR (simulasi).
- **Pengajuan SBP**: Surat Bebas Pustaka mandiri.

### 👮 Staff & Admin Dashboard
- **Manajemen Sirkulasi**: Scan RFID/Barcode untuk peminjaman dan pengembalian cepat.
- **Manajemen Anggota**: CRUD data santri/anggota.
- **Manajemen Koleksi**: Input buku, kategori, dan stok.
- **Laporan & Statistik**: Grafik kunjungan dan peminjaman real-time.



## 🛠️ Teknologi yang Digunakan

- **Framework PHP**: [Laravel 10.x](https://laravel.com)
- **Styling**: [Tailwind CSS](https://tailwindcss.com)
- **Interactivity**: Alpine.js / Vanilla JS (untuk wireframe), Livewire (untuk full app).
- **Database**: MySQL

## 🚀 Instalasi & Menjalankan Project

Ikuti langkah berikut untuk menjalankan projek di lokal:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/gaztudio-id/IHSAN-LIB.git
    cd ihsan-lib
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment**
    - Copy `.env.example` ke `.env`
    - Konfigurasi database di `.env`
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Migration & Seeding**
    ```bash
    php artisan migrate --seed
    ```

5.  **Compile Assets**
    ```bash
    npm run dev
    ```

6.  **Jalankan Server**
    ```bash
    php artisan serve
    ```

Akses aplikasi di: `http://localhost:8000`

## 👥 Kontribusi

Silakan fork repository ini dan buat Pull Request untuk berkontribusi.

---
© 2024 IHSAN-LIB Development Team.