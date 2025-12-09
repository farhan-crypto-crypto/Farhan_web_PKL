# Website Biodata Farhan

Website biodata personal dengan sistem kehadiran dan laporan kegiatan yang dibuat menggunakan PHP dan MySQL.

## Fitur Utama

### 1. Biodata Personal
- Form input biodata lengkap
- Daftar biodata dengan fitur view dan edit
- Informasi personal yang terstruktur

### 2. Sistem Kehadiran
- Input data kehadiran harian
- Status kehadiran (Hadir, Sakit, Izin, Alpha)
- Statistik kehadiran
- Waktu masuk dan keluar

### 3. Laporan Kegiatan
- Input kegiatan dengan detail lengkap
- Status kegiatan (Sedang Berlangsung, Selesai, Dibatalkan)
- Statistik kegiatan
- Deskripsi dan lokasi kegiatan

## Teknologi yang Digunakan

- **Backend**: PHP Native
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Font Awesome
- **Server**: XAMPP (Apache + MySQL)

## Instalasi

### 1. Persyaratan Sistem
- XAMPP (Apache + MySQL)
- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi

### 2. Langkah Instalasi

1. **Clone atau download project**
   ```
   Letakkan semua file di folder: C:/xampp/htdocs/farhan_biodata/
   ```

2. **Setup Database**
   - Buka phpMyAdmin: http://localhost/phpmyadmin
   - Buat database baru dengan nama: `biodata_db`
   - Import file `database.sql` atau jalankan query SQL yang ada di file tersebut

3. **Konfigurasi Database**
   - Edit file `config.php` jika diperlukan
   - Sesuaikan username dan password database jika berbeda

4. **Akses Website**
   - Buka browser
   - Akses: http://localhost/farhan_biodata/

## Struktur File

```
farhan_biodata/
├── config.php              # Konfigurasi database
├── database.sql            # File SQL untuk setup database
├── index.php               # Halaman utama
├── biodata.php             # Halaman biodata
├── kehadiran.php           # Halaman sistem kehadiran
├── kegiatan.php            # Halaman laporan kegiatan
├── get_biodata.php         # API untuk mengambil data biodata
├── get_kehadiran.php       # API untuk mengambil data kehadiran
├── get_kegiatan.php        # API untuk mengambil data kegiatan
└── README.md               # Dokumentasi
```

## Cara Penggunaan

### 1. Biodata
- Klik menu "Biodata" di navbar
- Isi form untuk menambah biodata baru
- Lihat daftar biodata yang sudah ada
- Klik tombol "View" untuk melihat detail
- Klik tombol "Edit" untuk mengubah data

### 2. Kehadiran
- Klik menu "Kehadiran" di navbar
- Isi form untuk menambah data kehadiran
- Lihat statistik kehadiran di bagian atas
- Lihat daftar kehadiran yang sudah ada
- Klik tombol "Edit" untuk mengubah data

### 3. Kegiatan
- Klik menu "Kegiatan" di navbar
- Isi form untuk menambah kegiatan baru
- Lihat statistik kegiatan di bagian atas
- Lihat daftar kegiatan yang sudah ada
- Klik tombol "Edit" untuk mengubah data

## Database Schema

### Tabel: biodata
- id (Primary Key)
- nama
- tempat_lahir
- tanggal_lahir
- jenis_kelamin
- alamat
- email
- telepon
- pendidikan_terakhir
- pekerjaan
- foto
- created_at

### Tabel: kehadiran
- id (Primary Key)
- tanggal
- waktu_masuk
- waktu_keluar
- status
- keterangan
- created_at

### Tabel: kegiatan
- id (Primary Key)
- tanggal
- nama_kegiatan
- deskripsi
- lokasi
- waktu_mulai
- waktu_selesai
- status
- created_at

## Fitur Tambahan

- **Responsive Design**: Website dapat diakses dari berbagai ukuran layar
- **Modern UI**: Menggunakan Bootstrap 5 dengan desain yang menarik
- **Real-time Statistics**: Statistik yang update secara real-time
- **Modal Forms**: Form edit menggunakan modal untuk UX yang lebih baik
- **Alert Messages**: Notifikasi sukses dan error yang informatif

## Troubleshooting

### Masalah Koneksi Database
- Pastikan XAMPP sudah running (Apache + MySQL)
- Periksa konfigurasi di `config.php`
- Pastikan database `biodata_db` sudah dibuat

### Masalah Tampilan
- Pastikan koneksi internet untuk loading Bootstrap dan Font Awesome
- Refresh halaman jika ada masalah CSS

### Masalah Input Data
- Pastikan semua field required sudah diisi
- Periksa format tanggal dan waktu yang benar

## Kontak

Untuk pertanyaan atau masalah teknis, silakan hubungi developer.

---

**Dibuat dengan ❤️ menggunakan PHP dan Bootstrap** 