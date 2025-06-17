<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

try {
    require_once "koneksi.php";
    require_once "pesanan.php";
    require_once "detailpesanan.php";
    require_once "transaksi.php";

    if (!isset($_SESSION['ID_USER'])) {
        throw new Exception("User belum login.");
    }

    $db = (new Database())->connection();
    $data = json_decode(file_get_contents("php://input"), true);
    
    file_put_contents("debug_keranjang.txt", print_r($data, true));

    if (!$data || !is_array($data)) {
        throw new Exception("Data tidak valid.");
    }

    if (!isset($data['keranjang']) || !is_array($data['keranjang'])) {
        throw new Exception("Data keranjang tidak valid atau kosong.");
    }
    
    $id_user = $_SESSION['ID_USER'];

    // Tambah ke pesanan
    $pesanan = new Pesanan($db);
    $pesanan->id_user = $id_user;
// 1. Hitung nomor antrian terakhir
$tanggalHariIni = date('Y-m-d');
$stmt = $db->prepare("SELECT MAX(NO_ANTRIAN) FROM antrian WHERE DATE(TANGGAL) = ?");
$stmt->execute([$tanggalHariIni]);
$lastNoAntrian = $stmt->fetchColumn();
$newNoAntrian = ($lastNoAntrian !== false && $lastNoAntrian !== null) ? $lastNoAntrian + 1 : 1;

// 2. Tambahkan ke tabel antrian dulu
$stmt = $db->prepare("INSERT INTO antrian (NO_ANTRIAN, TANGGAL) VALUES (?, NOW())");
$stmt->execute([$newNoAntrian]);
$id_antrian = $db->lastInsertId(); // ← ini adalah ID_ANTRIAN yang valid

// 3. Tambahkan ke pesanan
$pesanan = new Pesanan($db);
$pesanan->id_user = $id_user;
$pesanan->id_antrian = $id_antrian;
$pesanan->tambah();
$id_pesanan = $pesanan->id_pesanan;

    // Tambah ke detail_pesanan
    foreach ($data['keranjang'] as $item) {
        if (!isset($item['id_menu'], $item['jumlah'])) {
            throw new Exception("Item keranjang tidak lengkap (harus ada id_menu dan jumlah).");
        }

        $detail = new DetailPesanan($db);
        $detail->id_pesanan = $id_pesanan;
        $detail->id_menu = $item['id_menu'];
        $detail->jumlah = $item['jumlah'];
        $detail->tambah();
    }
    if (!isset($data['metode_pengambilan'], $data['alamat'], $data['metode_pembayaran'])) {
        throw new Exception("Data transaksi tidak lengkap.");
    }
    // Tambah ke transaksi
    $transaksi = new Transaksi($db);
    $transaksi->id_pesanan = $id_pesanan;
    $transaksi->metode_pengambilan = $data['metode_pengambilan'];
    $transaksi->alamat = $data['alamat'];
    $transaksi->metode_pembayaran = $data['metode_pembayaran'];
    $transaksi->tambah();

    echo json_encode([
        "success" => true,
        "no_antrian" => $pesanan->id_antrian
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}