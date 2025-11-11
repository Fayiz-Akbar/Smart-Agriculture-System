<?php
$suhu = $_GET['suhu_udara'];                 // Misal: 27.5
$kelembapan_udara = $_GET['kelembapan_udara']; // Misal: 65.0
$kelembapan_tanah = $_GET['kelembapan_tanah']; // Misal: 55.8
$status_hujan = $_GET['status_hujan'];         // Misal: 0 (false)
$status_pompa = $_GET['status_pompa'];         // Misal: 1 (true)

/* --- Inilah query yang aman (Prepared Statement) --- */

// 1. Siapkan template SQL
$sql = "INSERT INTO tb_data_sensor 
        (suhu_udara, kelembapan_udara, kelembapan_tanah, status_hujan, status_pompa) 
        VALUES (?, ?, ?, ?, ?)";

// 2. Siapkan statement dari koneksi
$stmt = $koneksi->prepare($sql);

// 3. Bind parameter (ini bagian pentingnya)
// "dddii" artinya:
// d = double/decimal (untuk suhu)
// d = double/decimal (untuk kelembapan udara)
// d = double/decimal (untuk kelembapan tanah)
// i = integer (untuk status hujan, 0 atau 1)
// i = integer (untuk status pompa, 0 atau 1)
$stmt->bind_param("dddii", 
    $suhu, 
    $kelembapan_udara, 
    $kelembapan_tanah, 
    $status_hujan, 
    $status_pompa
);

// 4. Eksekusi query
if ($stmt->execute()) {
    echo "Data berhasil disimpan.";
} else {
    echo "Error: " . $stmt->error;
}

// 5. Tutup statement
$stmt->close();
?>