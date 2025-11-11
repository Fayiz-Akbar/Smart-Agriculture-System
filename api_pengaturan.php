<?php
header('Content-Type: application/json');
include 'koneksi.php';

$response = array();

// Cek metode request
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    // --- MODE GET: Mengambil pengaturan saat ini ---
    
    // Kita selalu ambil pengaturan dari id = 1
    $sql = "SELECT ambang_batas_tanah, durasi_siram_menit FROM tb_pengaturan WHERE id = 1";
    $hasil = $koneksi->query($sql);

    if ($hasil && $hasil->num_rows > 0) {
        $data = $hasil->fetch_assoc();
        $response['status'] = 'success';
        $response['data'] = $data;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Pengaturan default tidak ditemukan.';
    }

} elseif ($method == 'POST') {
    // --- MODE POST: Menyimpan pengaturan baru ---
    
    // Ambil data JSON yang dikirim dari JavaScript
    $data_input = json_decode(file_get_contents('php://input'), true);

    if (isset($data_input['ambang_batas_tanah']) && isset($data_input['durasi_siram_menit'])) {
        
        $ambang_batas = $data_input['ambang_batas_tanah'];
        $durasi_siram = $data_input['durasi_siram_menit'];

        // Kita UPDATE pengaturan di id = 1
        $sql = "UPDATE tb_pengaturan SET 
                ambang_batas_tanah = ?, 
                durasi_siram_menit = ? 
                WHERE id = 1";
        
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("di", $ambang_batas, $durasi_siram);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Pengaturan berhasil disimpan.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal menyimpan pengaturan: ' . $stmt->error;
        }
        $stmt->close();
        
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Parameter tidak lengkap.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Metode request tidak valid.';
}

echo json_encode($response);
$koneksi->close();
?>