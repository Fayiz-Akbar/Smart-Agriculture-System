-- Active: 1753257938710@@127.0.0.1@3306@smart_agriculture
-- 1. Buat Database (Jika belum ada)
CREATE DATABASE IF NOT EXISTS smart_agriculture;

-- 2. Pilih Database
USE smart_agriculture;

-- 3. Buat Tabel Data Sensor (Untuk menampung kiriman dari ESP8266)
CREATE TABLE IF NOT EXISTS tb_data_sensor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    suhu_udara DECIMAL(5,2),
    kelembapan_udara DECIMAL(5,2),
    kelembapan_tanah DECIMAL(5,2),
    status_hujan TINYINT(1), -- 0 = Tidak Hujan, 1 = Hujan
    status_pompa TINYINT(1), -- 0 = Mati, 1 = Hidup
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Buat Tabel Pengaturan (Untuk menyimpan setting dari Web)
-- Sudah termasuk kolom 'status_sistem' untuk fitur ON/OFF
CREATE TABLE IF NOT EXISTS tb_pengaturan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ambang_batas_tanah DECIMAL(5,2) DEFAULT 35.00,
    durasi_siram_menit INT DEFAULT 15,
    status_sistem TINYINT(1) DEFAULT 1 -- 1 = Sistem Aktif, 0 = Sistem Mati
);

-- 5. Isi Pengaturan Default
-- (Agar halaman Pengaturan tidak error saat pertama kali dibuka)
INSERT INTO tb_pengaturan (id, ambang_batas_tanah, durasi_siram_menit, status_sistem)
VALUES (1, 35.0, 15, 1)
ON DUPLICATE KEY UPDATE id=id;

-- 6. Isi Data Dummy (20 Data Terakhir)
-- Data ini dibuat bervariasi agar grafik di menu Analisis terlihat naik-turun
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES 
(26.5, 85.0, 60.5, 0, 0, DATE_SUB(NOW(), INTERVAL 19 HOUR)),
(27.0, 83.0, 58.0, 0, 0, DATE_SUB(NOW(), INTERVAL 18 HOUR)),
(28.2, 80.0, 55.5, 0, 0, DATE_SUB(NOW(), INTERVAL 17 HOUR)),
(29.5, 75.0, 53.0, 0, 0, DATE_SUB(NOW(), INTERVAL 16 HOUR)),
(31.0, 70.0, 50.0, 0, 0, DATE_SUB(NOW(), INTERVAL 15 HOUR)),
(32.5, 65.0, 48.0, 0, 0, DATE_SUB(NOW(), INTERVAL 14 HOUR)),
(33.0, 60.0, 45.5, 0, 0, DATE_SUB(NOW(), INTERVAL 13 HOUR)),
(33.5, 58.0, 42.0, 0, 0, DATE_SUB(NOW(), INTERVAL 12 HOUR)),
(34.0, 55.0, 40.0, 0, 0, DATE_SUB(NOW(), INTERVAL 11 HOUR)),
(33.8, 57.0, 38.0, 0, 0, DATE_SUB(NOW(), INTERVAL 10 HOUR)),
(33.0, 58.0, 30.0, 0, 1, DATE_SUB(NOW(), INTERVAL 9 HOUR)),
(32.5, 60.0, 45.0, 0, 1, DATE_SUB(NOW(), INTERVAL 8 HOUR)),
(31.0, 65.0, 70.0, 0, 0, DATE_SUB(NOW(), INTERVAL 7 HOUR)),
(29.0, 70.0, 68.0, 0, 0, DATE_SUB(NOW(), INTERVAL 6 HOUR)),
(27.0, 85.0, 75.0, 1, 0, DATE_SUB(NOW(), INTERVAL 5 HOUR)),
(26.0, 90.0, 85.0, 1, 0, DATE_SUB(NOW(), INTERVAL 4 HOUR)),
(25.5, 88.0, 82.0, 0, 0, DATE_SUB(NOW(), INTERVAL 3 HOUR)),
(25.0, 85.0, 80.0, 0, 0, DATE_SUB(NOW(), INTERVAL 2 HOUR)),
(24.5, 86.0, 78.0, 0, 0, DATE_SUB(NOW(), INTERVAL 1 HOUR)),
(24.2, 87.5, 76.5, 0, 0, NOW());

ALTER TABLE tb_pengaturan ADD COLUMN mode_pompa TINYINT(1) DEFAULT 0;