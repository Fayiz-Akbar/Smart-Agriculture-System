<?php
$suhu = $_GET['suhu_udara'];                 // Misal: 27.5
$kelembapan_udara = $_GET['kelembapan_udara']; // Misal: 65.0
$kelembapan_tanah = $_GET['kelembapan_tanah']; // Misal: 55.8
$status_hujan = $_GET['status_hujan'];         // Misal: 0 (false)
$status_pompa = $_GET['status_pompa'];         // Misal: 1 (true)

$sql = "INSERT INTO tb_data_sensor 
        (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $koneksi->prepare($sql);

$stmt->bind_param("dddii", 
    $suhu, 
    $kelembapan_udara, 
    $kelembapan_tanah, 
    $status_hujan, 
    $status_pompa
);

if ($stmt->execute()) {
    echo "Data berhasil disimpan.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>