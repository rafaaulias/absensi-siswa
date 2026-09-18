# Panduan Setup Application - Dashboard Daftar Hadir Murid (PHP Native MVC)

Aplikasi web **Dashboard Daftar Hadir Murid** ini dikembangkan menggunakan **PHP Native** dengan pola arsitektur **MVC (Model-View-Controller)** manual dan database **MySQL (PDO)** untuk lingkungan local development **Laragon**.

---

## Technical Specs & Environment
- **Web Server**: Apache / Nginx (Laragon)
- **Programming Language**: PHP 7.4+ / PHP 8.x (Native)
- **Database**: MySQL / MariaDB (PDO Extension Enabled)
- **Frontend**: HTML5, Vanilla CSS (Clean Light Mode), Vanilla JS

---

## Langkah Setup & Instalasi di Laragon

### 1. Penempatan Folder Project
Pastikan seluruh folder project `daftar_hadir_murid` diletakkan pada direktori web root Laragon:
```text
C:\laragon\www\daftar_hadir_murid
```

### 2. Menjalankan Server Laragon
1. Buka aplikasi **Laragon**.
2. Klik tombol **Start All** untuk menjalankan service **Apache** dan **MySQL**.

### 3. Membuat Database & Import `database.sql`
1. Buka tool database di Laragon:
   - Klik tombol **Database** di Laragon untuk membuka **HeidiSQL**, atau
   - Buka browser dan akses `http://localhost/phpmyadmin`
2. Buat database baru bernama `db_presensi_murid` (atau biarkan script SQL membuat database secara otomatis).
3. Import file `database.sql` yang ada di root project:
   - Di **HeidiSQL**: Pilih menu `File` -> `Load SQL file...` -> Pilih `database.sql` -> Tekan `F9` (Execute).
   - Di **phpMyAdmin**: Pilih tab `Import` -> Choose File `database.sql` -> Klik `Go` / `Kirim`.

### 4. Konfigurasi Database (Jika Diperlukan)
File konfigurasi database berada di [config/database.php](file:///d:/File/laragon/www/bu_zaima/daftar_hadir_murid/config/database.php):
```php
return [
    'host' => 'localhost',
    'dbname' => 'db_presensi_murid',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4'
];
```
*Catatan*: Konfigurasi default Laragon menggunakan username `root` tanpa password (`""`). Jika Anda mengubah kredensial MySQL Laragon Anda, sesuaikan file di atas.

### 5. Cara Akses Aplikasi di Browser
Setelah Apache & MySQL berjalan dan database terimport, Anda dapat mengakses aplikasi melalui URL:

- **Via Subfolder Localhost**:
  ```text
  http://localhost/daftar_hadir_murid/public
  ```
- **Via Laragon Auto Virtual Host** (jika fitur Auto Virtual Hosts Laragon aktif):
  ```text
  http://daftar_hadir_murid.test
  ```

---

## Fitur Aplikasi
1. **Beranda / Dashboard**: Menampilkan ringkasan jumlah total Kelas, Guru, Mata Pelajaran, dan Murid.
2. **Master Data CRUD**:
   - Master Kelas (Tambah, Edit, Hapus, Lihat)
   - Master Guru (Tambah, Edit, Hapus, Lihat)
   - Master Mata Pelajaran (Tambah, Edit, Hapus, Lihat)
   - Master Murid (Tambah, Edit, Hapus, Lihat dengan relasi ke Kelas)
3. **Fitur Presensi Matriks**:
   - Form Filter berdasarkan Kelas, Guru, Mata Pelajaran, Bulan, dan Tahun.
   - Generasi otomatis jumlah hari bulanan (28/29/30/31 hari).
   - Matriks kehadiran per tanggal dengan pilihan status `H` (Hadir), `I` (Izin), `S` (Sakit), `A` (Alpa).
   - Penyimpanan batch sekali klik (**Simpan Presensi**) menggunakan teknik `UPSERT` (`INSERT ... ON DUPLICATE KEY UPDATE`).

---

## Struktur Folder Project
```text
/config
  database.php          -> Konfigurasi koneksi database PDO
/app
  /controllers          -> Controller kelas, guru, mapel, murid, presensi, dashboard
  /models               -> Model query PDO database
  /views
    /layouts            -> Header & Footer template
    /dashboard          -> Halaman beranda
    /kelas              -> Views CRUD kelas
    /guru               -> Views CRUD guru
    /mapel              -> Views CRUD mapel
    /murid              -> Views CRUD murid
    /presensi           -> View Matriks Presensi
/core
  Router.php            -> Front Controller Router
  Controller.php        -> Base Controller
  Model.php             -> Base Model
  Database.php          -> PDO Singleton Wrapper
/public
  index.php             -> Entry point tunggal aplikasi
  /assets/css/style.css -> CSS Vanilla Light Mode
.htaccess               -> Rewrite rule root
database.sql            -> DDL & DML Schema + Data Dummy
README.md               -> Dokumentasi setup ini
```
