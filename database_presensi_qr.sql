-- Database: presensi_qr_code
-- Aplikasi Presensi Menggunakan QR Code
-- Created by: Sifa Barqilah

-- Buat database
CREATE DATABASE IF NOT EXISTS presensi_qr_code;
USE presensi_qr_code;

-- Tabel roles (peran pengguna)
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel users (pengguna/pegawai)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nip VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    address TEXT,
    position VARCHAR(100),
    department VARCHAR(100),
    photo VARCHAR(255),
    role_id INT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- Tabel qr_codes (kode QR untuk presensi)
CREATE TABLE qr_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(255) UNIQUE NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    location VARCHAR(100),
    valid_from DATETIME NOT NULL,
    valid_until DATETIME NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id)
);

-- Tabel attendance (presensi)
CREATE TABLE attendance (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    qr_code_id INT NOT NULL,
    check_in DATETIME,
    check_out DATETIME,
    status ENUM('present', 'late', 'absent', 'half_day') DEFAULT 'present',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (qr_code_id) REFERENCES qr_codes(id)
);

-- Tabel settings (pengaturan aplikasi)
CREATE TABLE settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel work_schedules (jadwal kerja)
CREATE TABLE work_schedules (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    late_threshold INT DEFAULT 15, -- menit
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel holidays (hari libur)
CREATE TABLE holidays (
    id INT PRIMARY KEY AUTO_INCREMENT,
    date DATE NOT NULL,
    description VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel attendance_reports (laporan presensi)
CREATE TABLE attendance_reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    report_date DATE NOT NULL,
    total_present INT DEFAULT 0,
    total_late INT DEFAULT 0,
    total_absent INT DEFAULT 0,
    total_half_day INT DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert data awal

-- Insert roles
INSERT INTO roles (name, description) VALUES
('admin', 'Administrator dengan akses penuh'),
('manager', 'Manager dengan akses laporan'),
('employee', 'Pegawai biasa');

-- Insert settings default
INSERT INTO settings (setting_key, setting_value, description) VALUES
('company_name', 'PT. Contoh Perusahaan', 'Nama perusahaan'),
('company_address', 'Jl. Contoh No. 123, Jakarta', 'Alamat perusahaan'),
('company_phone', '+62 21 1234567', 'Telepon perusahaan'),
('company_email', 'info@contoh.com', 'Email perusahaan'),
('work_start_time', '08:00:00', 'Jam mulai kerja'),
('work_end_time', '17:00:00', 'Jam selesai kerja'),
('late_threshold', '15', 'Batas keterlambatan (menit)'),
('qr_validity_hours', '24', 'Masa berlaku QR Code (jam)');

-- Insert work schedule default
INSERT INTO work_schedules (name, start_time, end_time, late_threshold) VALUES
('Jadwal Standar', '08:00:00', '17:00:00', 15);

-- Insert admin user default (password: admin123)
INSERT INTO users (nip, name, email, password, position, department, role_id) VALUES
('ADMIN001', 'Administrator', 'admin@contoh.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'IT', 1);

-- Insert sample employees (password: employee123)
INSERT INTO users (nip, name, email, password, position, department, role_id) VALUES
('EMP001', 'John Doe', 'john@contoh.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Staff', 'HR', 3),
('EMP002', 'Jane Smith', 'jane@contoh.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Manager', 'Finance', 2),
('EMP003', 'Bob Johnson', 'bob@contoh.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Staff', 'Marketing', 3);

-- Insert sample QR codes
INSERT INTO qr_codes (code, title, description, location, valid_from, valid_until, created_by) VALUES
('QR001-2024-01-01', 'Presensi Pagi', 'QR Code untuk presensi pagi', 'Gedung A Lantai 1', '2024-01-01 07:00:00', '2024-01-01 09:00:00', 1),
('QR002-2024-01-01', 'Presensi Siang', 'QR Code untuk presensi siang', 'Gedung A Lantai 1', '2024-01-01 12:00:00', '2024-01-01 14:00:00', 1),
('QR003-2024-01-01', 'Presensi Sore', 'QR Code untuk presensi sore', 'Gedung A Lantai 1', '2024-01-01 16:00:00', '2024-01-01 18:00:00', 1);

-- Insert sample holidays
INSERT INTO holidays (date, description) VALUES
('2024-01-01', 'Tahun Baru'),
('2024-01-25', 'Hari Raya Idul Fitri'),
('2024-08-17', 'Hari Kemerdekaan RI');

-- Buat index untuk optimasi query
CREATE INDEX idx_users_nip ON users(nip);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_attendance_user_date ON attendance(user_id, DATE(created_at));
CREATE INDEX idx_attendance_qr_code ON attendance(qr_code_id);
CREATE INDEX idx_qr_codes_validity ON qr_codes(valid_from, valid_until);
CREATE INDEX idx_attendance_reports_user_date ON attendance_reports(user_id, report_date); 