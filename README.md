# UTS Pemrograman Web - Website Portal Berita

Proyek ini dibuat untuk memenuhi tugas Ujian Tengah Semester (UTS) mata kuliah Pemrograman Web. Website ini merupakan portal berita dinamis yang dibangun menggunakan PHP Native dan database MySQL.

## 👤 Identitas Mahasiswa
- **Nama:** Ibrahim Hilal
- **Program Studi:** Informatika
- **Universitas:** UIN Siber Syekh Nurjati Cirebon

## 🚀 Fitur Utama
- **Sistem Login Admin:** Keamanan akses untuk mengelola konten.
- **Manajemen Artikel (CRUD):** Tambah, lihat, edit, dan hapus berita.
- **Kategori Berita:** Pengelompokan berita berdasarkan topik (Teknologi, Olahraga, dll).
- **Fitur Pencarian:** Mencari berita berdasarkan judul atau isi.
- **Trending/Populer:** Menampilkan berita yang paling banyak dilihat.
- **Sistem Komentar:** Interaksi pengunjung pada setiap detail berita.
- **Responsive UI:** Tampilan modern menggunakan Bootstrap 5 yang ramah perangkat mobile.

## 🛠️ Teknologi yang Digunakan
- **Bahasa Pemrograman:** PHP Native
- **Database:** MySQL / MariaDB
- **Frontend Framework:** Bootstrap 5 & Bootstrap Icons
- **Web Server:** XAMPP (Apache)
- **Editor:** Visual Studio Code

## 💻 Cara Instalasi & Menjalankan Proyek
1. **Persiapan Database:**
   - Buka `phpMyAdmin` (localhost/phpmyadmin).
   - Buat database baru dengan nama `db_berita`.
   - Import file `db_berita.sql` yang ada di dalam repositori ini ke dalam database tersebut.

2. **Konfigurasi File:**
   - Pastikan folder proyek ini berada di dalam direktori `C:/xampp/htdocs/`.
   - Cek file `koneksi.php` untuk memastikan pengaturan host, user, dan password database sudah sesuai.

3. **Menjalankan Web:**
   - Jalankan Apache dan MySQL pada XAMPP Control Panel.
   - Buka browser dan akses `localhost/uts_berita_hilal/index.php`.

4. **Akses Admin:**
   - Halaman Admin: `localhost/uts_berita_hilal/login.php`
   - **Username:** `admin`
   - **Password:** `admin123`****
