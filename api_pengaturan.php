<?php
header('Content-Type: application/json');
include 'koneksi.php';

$response = array();
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $sql = "SELECT ambang_batas_tanah, status_sistem, mode_pompa FROM tb_pengaturan WHERE id = 1";
    $hasil = $koneksi->query($sql);

    if ($hasil && $hasil->num_rows > 0) {
        $data = $hasil->fetch_assoc();
        $response['status'] = 'success';
        $response['data'] = $data;
    } else {
        $response['status'] = 'error';
    }

} elseif ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    // 1. Update Khusus Mode Pompa (dari Tombol Dashboard)
    if (isset($input['mode_pompa'])) {
        $mode = $input['mode_pompa'];
        $sql = "UPDATE tb_pengaturan SET mode_pompa = ? WHERE id = 1";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $mode);
        if($stmt->execute()) {
             $response['status'] = 'success';
        }
        $stmt->close();
    } 
    // 2. Update Pengaturan Umum (Tanpa Durasi)
    else if (isset($input['ambang_batas_tanah']) && isset($input['status_sistem'])) {
        $ambang = $input['ambang_batas_tanah'];
        $status = $input['status_sistem'];
        
        // Kita HAPUS 'durasi_siram_menit' dari query update
        $sql = "UPDATE tb_pengaturan SET ambang_batas_tanah = ?, status_sistem = ? WHERE id = 1";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("di", $ambang, $status);

        if ($stmt->execute()) {
            $response['status'] = 'success';
        } else {
            $response['status'] = 'error';
        }
        $stmt->close();
    } 
    else {
        $response['status'] = 'error';
        $response['message'] = 'Data tidak lengkap.';
    }
}

echo json_encode($response);
$koneksi->close();
?>