USE smart_agriculture

CREATE TABLE tb_data_sensor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    suhu_udara DECIMAL(5, 2),
    kelembapan_udara DECIMAL(5, 2),
    kelembapan_tanah DECIMAL(5, 2),
    status_hujan BOOLEAN,
    status_pompa BOOLEAN
);

CREATE TABLE tb_pengaturan (
  id INT PRIMARY KEY DEFAULT 1,
  ambang_batas_tanah DECIMAL(5, 2) DEFAULT 35.0,
  durasi_siram_menit INT DEFAULT 15
);

INSERT INTO tb_pengaturan (id, ambang_batas_tanah, durasi_siram_menit) 
VALUES (1, 35.0, 15);


-- Pastikan menggunakan database yang benar
USE smart_agriculture;

-- 1. BUAT TABEL DATA SENSOR (Jika belum ada)
CREATE TABLE IF NOT EXISTS tb_data_sensor (
    id INT PRIMARY KEY AUTO_INCREMENT,
    suhu_udara DECIMAL(5,2),
    kelembapan_udara DECIMAL(5,2),
    kelembapan_tanah DECIMAL(5,2),
    status_hujan TINYINT(1), -- 0 = Tidak Hujan, 1 = Hujan
    status_pompa TINYINT(1), -- 0 = Mati, 1 = Hidup
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. BUAT TABEL PENGATURAN (Jika belum ada)
CREATE TABLE IF NOT EXISTS tb_pengaturan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ambang_batas_tanah DECIMAL(5,2) DEFAULT 35.00,
    durasi_siram_menit INT DEFAULT 15
);

-- 3. ISI PENGATURAN DEFAULT (Penting untuk halaman Pengaturan)
INSERT INTO tb_pengaturan (id, ambang_batas_tanah, durasi_siram_menit)
VALUES (1, 35.0, 15)
ON DUPLICATE KEY UPDATE id=id;

-- 4. ISI 20 DATA DUMMY (Untuk Grafik & Analisis)
-- Data ini dibuat bervariasi agar grafiknya terlihat naik-turun cantik

-- Data 1 (Pagi hari, tanah lembap)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (26.5, 85.0, 60.5, 0, 0, DATE_SUB(NOW(), INTERVAL 19 HOUR));

-- Data 2
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (27.0, 83.0, 58.0, 0, 0, DATE_SUB(NOW(), INTERVAL 18 HOUR));

-- Data 3
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (28.2, 80.0, 55.5, 0, 0, DATE_SUB(NOW(), INTERVAL 17 HOUR));

-- Data 4
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (29.5, 75.0, 53.0, 0, 0, DATE_SUB(NOW(), INTERVAL 16 HOUR));

-- Data 5 (Siang mulai panas)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (31.0, 70.0, 50.0, 0, 0, DATE_SUB(NOW(), INTERVAL 15 HOUR));

-- Data 6
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (32.5, 65.0, 48.0, 0, 0, DATE_SUB(NOW(), INTERVAL 14 HOUR));

-- Data 7
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (33.0, 60.0, 45.5, 0, 0, DATE_SUB(NOW(), INTERVAL 13 HOUR));

-- Data 8 (Tanah mulai kering)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (33.5, 58.0, 42.0, 0, 0, DATE_SUB(NOW(), INTERVAL 12 HOUR));

-- Data 9
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (34.0, 55.0, 40.0, 0, 0, DATE_SUB(NOW(), INTERVAL 11 HOUR));

-- Data 10
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (33.8, 57.0, 38.0, 0, 0, DATE_SUB(NOW(), INTERVAL 10 HOUR));

-- Data 11 (Tanah Kritis -> Pompa ON)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (33.0, 58.0, 30.0, 0, 1, DATE_SUB(NOW(), INTERVAL 9 HOUR));

-- Data 12 (Pompa masih ON, tanah mulai naik)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (32.5, 60.0, 45.0, 0, 1, DATE_SUB(NOW(), INTERVAL 8 HOUR));

-- Data 13 (Pompa OFF, tanah sudah basah)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (31.0, 65.0, 70.0, 0, 0, DATE_SUB(NOW(), INTERVAL 7 HOUR));

-- Data 14 (Sore hari)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (29.0, 70.0, 68.0, 0, 0, DATE_SUB(NOW(), INTERVAL 6 HOUR));

-- Data 15 (Hujan Turun!)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (27.0, 85.0, 75.0, 1, 0, DATE_SUB(NOW(), INTERVAL 5 HOUR));

-- Data 16 (Masih Hujan)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (26.0, 90.0, 85.0, 1, 0, DATE_SUB(NOW(), INTERVAL 4 HOUR));

-- Data 17 (Hujan reda)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (25.5, 88.0, 82.0, 0, 0, DATE_SUB(NOW(), INTERVAL 3 HOUR));

-- Data 18 (Malam hari)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (25.0, 85.0, 80.0, 0, 0, DATE_SUB(NOW(), INTERVAL 2 HOUR));

-- Data 19
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (24.5, 86.0, 78.0, 0, 0, DATE_SUB(NOW(), INTERVAL 1 HOUR));

-- Data 20 (DATA SAAT INI / TERBARU - Tampil di Dashboard Utama)
INSERT INTO tb_data_sensor (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa, waktu) 
VALUES (24.2, 87.5, 76.5, 0, 0, NOW());

