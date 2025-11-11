<?php
header('Content-Type: application/json');

include 'koneksi.php';

$mode = isset($_GET['data']) ? $_GET['data'] : 'terbaru'; 

$data = array();

if ($mode == 'riwayat') {
    $sql = "SELECT * FROM (
                SELECT * FROM tb_data_sensor 
                ORDER BY id DESC 
                LIMIT 20
            ) AS sub 
            ORDER BY id ASC"; 

} else {
    $sql = "SELECT * FROM tb_data_sensor 
            ORDER BY id DESC 
            LIMIT 1";
}

$hasil = $koneksi->query($sql);

if ($hasil) {
    if ($hasil->num_rows > 0) {
        while ($baris = $hasil->fetch_assoc()) {
            $data[] = $baris;
        }
    } else {
        // Jika tidak ada data, kirim array kosong
    }
} else {
    // Handle error query jika perlu
    $data = array("error" => "Query gagal: " . $koneksi->error);
}

// Logika JSON encode yang lebih baik
if ($mode == 'terbaru' && !empty($data)) {
    echo json_encode($data[0]); // Kirim objek tunggal
} else {
    echo json_encode($data); // Kirim array (meskipun kosong)
}

$koneksi->close();
?>