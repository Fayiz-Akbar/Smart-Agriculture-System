<?php
header('Content-Type: application/json');

include 'koneksi.php'; 

$response = array();

if (isset($_GET['suhu_udara']) &&
    isset($_GET['kelembapan_udara']) &&
    isset($_GET['kelembapan_tanah']) &&
    isset($_GET['status_hujan']) &&
    isset($_GET['status_pompa'])) {

    $suhu = $_GET['suhu_udara'];
    $kelembapan_udara = $_GET['kelembapan_udara'];
    $kelembapan_tanah = $_GET['kelembapan_tanah'];
    $status_hujan = $_GET['status_hujan'];
    $status_pompa = $_GET['status_pompa'];

    $sql = "INSERT INTO tb_data_sensor 
            (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa) 
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("dddii", $suhu, $kelembapan_udara, $kelembapan_tanah, $status_hujan, $status_pompa);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Data sensor berhasil disimpan.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Gagal menyimpan data: ' . $stmt->error;
    }
    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Parameter tidak lengkap.';
}

echo json_encode($response);

$koneksi->close();
?>