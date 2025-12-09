-- Membuat database
CREATE DATABASE IF NOT EXISTS biodata_db;
USE biodata_db;

-- Tabel biodata
CREATE TABLE IF NOT EXISTS biodata (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    tempat_lahir VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    alamat TEXT NOT NULL,
    email VARCHAR(100),
    telepon VARCHAR(15),
    pendidikan_terakhir VARCHAR(100),
    pekerjaan VARCHAR(100),
    foto VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel users untuk login & register
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel kehadiran
CREATE TABLE IF NOT EXISTS kehadiran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    waktu_masuk TIME,
    waktu_keluar TIME,
    nama_panjang VARCHAR(200),
    status ENUM('Hadir', 'Sakit', 'Izin', 'Alpha') DEFAULT 'Hadir',
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel kegiatan
CREATE TABLE IF NOT EXISTS kegiatan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATE NOT NULL,
    nama_kegiatan VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    lokasi VARCHAR(200),
    waktu_mulai TIME,
    waktu_selesai TIME,
    status ENUM('Selesai', 'Sedang Berlangsung', 'Dibatalkan') DEFAULT 'Sedang Berlangsung',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert data contoh biodata
INSERT INTO biodata (nama, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, email, telepon, pendidikan_terakhir, pekerjaan) VALUES
('Farhan', 'Jakarta', '1995-05-15', 'Laki-laki', 'Jl. Sudirman No. 123, Jakarta Pusat', 'farhan@email.com', '081234567890', 'S1 Teknik Informatika', 'Web Developer');

-- Insert user admin default (password: password123)
INSERT INTO users (name, email, password) VALUES
('Administrator', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert data contoh kehadiran
INSERT INTO kehadiran (tanggal, waktu_masuk, waktu_keluar, status, keterangan) VALUES
(CURDATE(), '08:00:00', '17:00:00', 'Hadir', 'Hadir tepat waktu'),
(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '08:15:00', '17:00:00', 'Hadir', 'Terlambat 15 menit'),
(DATE_SUB(CURDATE(), INTERVAL 2 DAY), NULL, NULL, 'Sakit', 'Sakit flu');

-- Insert data contoh kegiatan
INSERT INTO kegiatan (tanggal, nama_kegiatan, deskripsi, lokasi, waktu_mulai, waktu_selesai, status) VALUES
(CURDATE(), 'Meeting Proyek Website', 'Diskusi tentang pengembangan website baru', 'Ruang Meeting', '09:00:00', '11:00:00', 'Selesai'),
(DATE_SUB(CURDATE(), INTERVAL 1 DAY), 'Pelatihan PHP', 'Pelatihan dasar PHP untuk tim', 'Lab Komputer', '14:00:00', '16:00:00', 'Selesai'),
(CURDATE(), 'Presentasi Laporan', 'Presentasi laporan bulanan', 'Aula', '13:00:00', '15:00:00', 'Sedang Berlangsung'); 