<?php
require_once "koneksi.php";

// Buat koneksi dengan PDO
$db = (new Database())->connection();

$nama = $_POST['nama'] ?? '';
$telepon = $_POST['telepon'] ?? '';
$jumlah_orang = $_POST['jumlah'] ?? 0;
$tanggal = $_POST['tanggal'] ?? '';
$jam = $_POST['jam'] ?? '';
$area = $_POST['area'] ?? '';
$catatan = $_POST['catatan'] ?? '';

if ($nama && $telepon && $jumlah_orang && $tanggal && $jam && $area) {
    $query = "INSERT INTO reservasi (nama, telepon, jumlah_orang, tanggal, jam, area, catatan) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $db->prepare($query);
    if ($stmt->execute([$nama, $telepon, $jumlah_orang, $tanggal, $jam, $area, $catatan])) {
        header("Location: reservasi.php?success=1");
        exit();
    } else {
        echo "Gagal menyimpan: " . implode(" ", $stmt->errorInfo());
    }
} else {
    echo "Semua data wajib diisi!";
}
?>