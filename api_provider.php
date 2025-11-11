<?php
// Set header agar outputnya berupa JSON
header('Content-Type: application/json');

// 1. Include file koneksi database
include 'koneksi.php';

// 2. Tentukan mode data (terbaru atau riwayat)
$mode = isset($_GET['data']) ? $_GET['data'] : 'terbaru'; // Default ke 'terbaru'

// 3. Siapkan array untuk menampung data
$data = array();

// 4. Siapkan SQL Query berdasarkan mode
if ($mode == 'riwayat') {
    // Ambil 20 data terakhir untuk grafik, urutkan dari yang TERLAMA ke TERBARU
    // (Ini penting agar sumbu X di grafik benar)
    $sql = "SELECT * FROM (
                SELECT * FROM tb_data_sensor 
                ORDER BY id DESC 
                LIMIT 20
            ) AS sub 
            ORDER BY id ASC"; // Di-subquery agar urutannya benar untuk grafik

} else {
    // Ambil 1 data paling baru untuk status 'real-time'
    $sql = "SELECT * FROM tb_data_sensor 
            ORDER BY id DESC 
            LIMIT 1";
}

// 5. Eksekusi Query
$hasil = $koneksi->query($sql);

// 6. Ambil data (Fetch)
if ($hasil) {
    if ($hasil->num_rows > 0) {
        // Masukkan semua baris hasil query ke array $data
        while ($baris = $hasil->fetch_assoc()) {
            $data[] = $baris;
        }
    }
}

// 7. Tampilkan hasil dalam format JSON
// Jika modenya 'terbaru' dan ada datanya, kita kirim objeknya langsung
// (bukan array di dalam array) agar lebih mudah dibaca frontend.
if ($mode == 'terbaru' && !empty($data)) {
    echo json_encode($data[0]);
} else {
    // Untuk mode riwayat, kita kirim array datanya
    echo json_encode($data);
}

// 8. Tutup koneksi database
$koneksi->close();

?>