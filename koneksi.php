<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "smart_agriculture";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>