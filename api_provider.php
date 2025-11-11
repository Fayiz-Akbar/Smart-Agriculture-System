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
    }
}

if ($mode == 'terbaru' && !empty($data)) {
    echo json_encode($data[0]);
} else {
    echo json_encode($data);
}

$koneksi->close();

?>