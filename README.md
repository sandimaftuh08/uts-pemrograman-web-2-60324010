# Sistem Manajemen Kategori Buku — UTS Pemrograman Web II
## Data Mahasiswa

| Field | Keterangan |
|---|---|
| **Nama Lengkap** | Ahmad Sandi Maftuh Firdaus |
| **NIM** | 60324010 |
| **Mata Kuliah / Kelas** | Pemrograman Web-II / A |

---

## Gambaran Umum Proyek

Proyek ini dikembangkan sebagai implementasi operasi CRUD (*Create, Read, Update, Delete*) pada sistem perpustakaan sederhana dengan fokus pada pengelolaan data kategori buku. Pengguna dapat melakukan empat operasi utama berikut:

- **Membaca** — Menampilkan seluruh daftar kategori yang tersimpan di database
- **Menambahkan** — Memasukkan data kategori baru disertai validasi pada sisi server
- **Memperbarui** — Mengubah informasi kategori yang telah ada sebelumnya
- **Menghapus** — Menghapus data kategori dengan konfirmasi terlebih dahulu

Setiap entri kategori terdiri dari empat atribut utama: kode unik berkformat `KAT-XXX`, nama kategori, keterangan/deskripsi, serta status ketersediaan (Aktif / Nonaktif).

**Stack teknologi yang dipakai:**
- PHP 8.x (tanpa framework, murni native)
- MySQL / MariaDB sebagai basis data
- Bootstrap 5.3 untuk tampilan antarmuka + Bootstrap Icons
- MySQLi dengan Prepared Statements untuk keamanan query dari SQL Injection

---

## Panduan Instalasi

### Kebutuhan Sistem

Salah satu dari paket web server berikut harus terinstal di komputer Anda:

| Software | Platform | Unduhan |
|---|---|---|
| XAMPP | Windows / Linux / macOS | [apachefriends.org](https://www.apachefriends.org/) |
| Laragon | Windows | [laragon.org](https://laragon.org/) |
| MAMP | macOS | [mamp.info](https://www.mamp.info/) |

### Tahapan Instalasi

**Langkah 1 — Unduh Source Code**

Lakukan clone repositori via terminal:
```bash
git clone https://github.com/sandimaftuh08/uts-pemrograman-web-2-60324010
```
Atau unduh sebagai file ZIP dan ekstrak secara manual.

**Langkah 2 — Letakkan di Direktori Web Server**

Salin folder proyek ke direktori root web server yang sesuai:

```
# Pengguna XAMPP (Windows)
C:/xampp/htdocs/uts-perpustakaan/

# Pengguna Laragon (Windows)
C:/laragon/www/uts-perpustakaan/

# Pengguna XAMPP (Linux / macOS)
/opt/lampp/htdocs/uts-perpustakaan/
```

**Langkah 3 — Inisialisasi Database**

Buka **phpMyAdmin** melalui browser di `http://localhost/phpmyadmin`, lalu:
1. Pilih menu **Import**
2. Klik **Choose File** dan pilih file `setup.sql` dari folder proyek
3. Klik tombol **Go** untuk memulai proses impor

Alternatif via terminal:
```bash
mysql -u root -p < setup.sql
```

**Langkah 4 — Konfigurasi Koneksi Database** *(opsional)*

Jika pengaturan database Anda berbeda dari default, buka `config/database.php` dan sesuaikan nilainya:

```php
define('DB_SERVER',   'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');         
define('DB_NAME',     'uts_perpustakaan_60324010');
```

**Langkah 5 — Akses Aplikasi**

Buka browser dan navigasikan ke URL berikut:
```
http://localhost/uts-pemrograman-web-2-60324010/index.php
```

---

## Struktur Direktori Proyek

```
uts-perpustakaan/
│
├── config/
│   └── database.php        
│
├── index.php               
├── create.php              
├── edit.php                
├── delete.php              
│
├── setup.sql               
│
└── README.md               
```

---

## Repositori GitHub

Kode sumber lengkap tersedia di:

```
https://github.com/sandimaftuh08/uts-pemrograman-web-2-60324010
```