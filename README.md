# TK Online - Laravel 9

Sistem e-commerce sederhana berbasis **Laravel 9** dengan manajemen produk, keranjang belanja, checkout, dan role-based dashboard.

---

## 📌 Prasyarat

- PHP >= 8.0.9  
- Composer  
- Node.js & npm  
- PostgreSQL (pgAdmin)  
- Laravel Framework 9.52.21  

---



## 💾 Instalasi

1. **Clone repository**  
   ```bash
   git clone <repository-url>
   cd <project-folder>

composer install
npm install
cp .env.example .env
php artisan key:generate

CREATE DATABASE tk_online di posgree;
CREATE SCHEMA master;
CREATE SCHEMA transactions;

npm run dev
php artisan migrate
php artisan db:seed
chmod -R 775 storage bootstrap/cache
php artisan serve

User & Role Default

Email	            Username / Name	    Password	    Role
admin@mail.com	Cece Syamsul Hadi	    password123	  admin
user@mail.com 	Febri Herdian	        password123	  pelanggan
cs1@mail.com  	CS 1	                password123	  cs1
cs2@mail.com   CS 2	                  password123	  cs2

🛒 Role Pelanggan
Masuk ke website.
- Tiap produk memiliki tombol Add to Cart dan input Qty.
- Klik icon keranjang untuk melihat daftar belanja.
  - Checkout:
            Jika belum login, sistem memberikan opsi:
            Login
            Daftar
            Checkout sebagai tamu
  Setelah checkout berhasil, upload bukti bayar.
  Upload bukti bayar juga bisa di halaman History jika belum diunggah.
  Status pesanan dapat dilihat di History.
  Tombol History ada di dropdown nama user.

🛠 Role Admin
- Login ke dashboard.
- Dashboard menampilkan:
  Total order + total nominal (Rp)
  Total produk + total stok
  Order yang masih diproses + total nominal
  Order dibatalkan + total nominal
  Order selesai + total nominal
  Order terkirim + total nominal
  Tabel 5 order terakhir
  Tombol Filter / Export Excel
  Menu Produk:
  Tambah, edit, hapus produk
  Import produk dari Excel

🛠 Role CS1
- Login ke dashboard.
- Dashboard sama seperti Admin.
  Menu Pesanan:
   Menampilkan pesanan yang harus dikonfirmasi
   Daftar pesanan
   Tiap baris ada tombol Detail untuk melihat detail pesanan dan update status
   Jika pelanggan sudah upload bukti bayar, CS1 bisa mengubah status
   Jika status belum upload bukti, CS1 tidak bisa mengubah status

🛠  Role CS2
Sama seperti CS1.
Perbedaan: CS2 bisa update status jika:
Sudah konfirmasi bukti bayar
Selesai packing
