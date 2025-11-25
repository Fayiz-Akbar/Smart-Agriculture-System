<?php
header('Content-Type: application/json');
include 'koneksi.php';

$response = array();
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    // Ambil semua pengaturan termasuk mode_pompa
    $sql = "SELECT ambang_batas_tanah, durasi_siram_menit, status_sistem, mode_pompa FROM tb_pengaturan WHERE id = 1";
    $hasil = $koneksi->query($sql);

    if ($hasil && $hasil->num_rows > 0) {
        $data = $hasil->fetch_assoc();
        $response['status'] = 'success';
        $response['data'] = $data;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Pengaturan tidak ditemukan.';
    }

} elseif ($method == 'POST') {
    // Simpan pengaturan baru
    $input = json_decode(file_get_contents('php://input'), true);

    // Cek parameter apa yang dikirim (bisa update parsial)
    if (isset($input['mode_pompa'])) {
        // Update Khusus Mode Pompa (dari Dashboard)
        $mode = $input['mode_pompa'];
        $sql = "UPDATE tb_pengaturan SET mode_pompa = ? WHERE id = 1";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $mode);
    } 
    else if (isset($input['ambang_batas_tanah']) && isset($input['durasi_siram_menit']) && isset($input['status_sistem'])) {
        // Update Pengaturan Umum (dari Halaman Pengaturan)
        $ambang = $input['ambang_batas_tanah'];
        $durasi = $input['durasi_siram_menit'];
        $status = $input['status_sistem'];
        
        $sql = "UPDATE tb_pengaturan SET ambang_batas_tanah = ?, durasi_siram_menit = ?, status_sistem = ? WHERE id = 1";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("dii", $ambang, $durasi, $status);
    } 
    else {
        $response['status'] = 'error';
        $response['message'] = 'Data tidak lengkap.';
        echo json_encode($response);
        exit;
    }

    if (isset($stmt) && $stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Berhasil disimpan.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Gagal menyimpan.';
    }
    if (isset($stmt)) $stmt->close();
}

echo json_encode($response);
$koneksi->close();
?>