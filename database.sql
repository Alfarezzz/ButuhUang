-- ===================================================
-- Skema Database ButuhUang (MySQL / MariaDB Compatible)
-- Project: ButuhUang Fintech Platform
-- ===================================================

CREATE DATABASE IF NOT EXISTS `butuhuang_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `butuhuang_db`;

-- Tabel Pengguna (Borrower / Nasabah)
DROP TABLE IF EXISTS `bills`;
DROP TABLE IF EXISTS `loans`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(150) NOT NULL,
    `nik` VARCHAR(20) UNIQUE NOT NULL,
    `telepon` VARCHAR(20) UNIQUE NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `sandi` VARCHAR(255) NOT NULL,
    `limit_total` DECIMAL(15,2) DEFAULT 69696666.00,
    `limit_sisa` DECIMAL(15,2) DEFAULT 69696666.00,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Pengajuan Pinjaman (Loan Application)
CREATE TABLE `loans` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `nominal` DECIMAL(15,2) NOT NULL,
    `tenor` INT NOT NULL COMMENT 'Tenor dalam bulan',
    `bunga_persen` DECIMAL(5,2) NOT NULL COMMENT 'Bunga maksimal 10% pertahun/flat',
    `total_pinjaman` DECIMAL(15,2) NOT NULL,
    `cicilan_per_bulan` DECIMAL(15,2) NOT NULL,
    `status` VARCHAR(30) DEFAULT 'disetujui' COMMENT 'pending, disetujui, lunas, ditolak',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_loans_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Tagihan / Jadwal Cicilan Bulanan (Loan Bills / Installments)
CREATE TABLE `bills` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `loan_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `bulan_ke` INT NOT NULL,
    `nominal_cicilan` DECIMAL(15,2) NOT NULL,
    `jatuh_tempo` DATE NOT NULL,
    `status` ENUM('belum_bayar', 'sudah_bayar') DEFAULT 'belum_bayar',
    `tanggal_bayar` DATETIME DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_bills_loan` FOREIGN KEY (`loan_id`) REFERENCES `loans` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_bills_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seeder Data Demo Akun (Sandi: password123)
INSERT INTO `users` (`nama`, `nik`, `telepon`, `email`, `sandi`, `limit_total`, `limit_sisa`) 
VALUES (
    'Kelana Mahasiswa',
    '3172010101990001',
    '081234567890',
    'kelana@butuhuang.id',
    '$2y$12$EaZU2Ox4WSBrJmEwM7ULjugFBUbQi5g5do/b1nFF6YdeUVSooC/we',
    69696666.00,
    69696666.00
);
