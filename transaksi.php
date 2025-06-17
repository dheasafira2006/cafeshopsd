<?php
class Transaksi {
    private $conn;
    public $id_pesanan;
    public $metode_pembayaran;
    public $metode_pengambilan;
    public $alamat;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function tambah() {
    $query = "INSERT INTO transaksi (ID_PESANAN, METODE_PENGAMBILAN, ALAMAT, METODE_PEMBAYARAN) 
              VALUES (:id_pesanan, :metode_pengambilan, :alamat, :metode_pembayaran)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_pesanan', $this->id_pesanan);
    $stmt->bindParam(':metode_pengambilan', $this->metode_pengambilan);
    $stmt->bindParam(':alamat', $this->alamat);
    $stmt->bindParam(':metode_pembayaran', $this->metode_pembayaran);
    if (!$stmt->execute()) {
        throw new Exception("Error tambah transaksi: " . implode(" | ", $stmt->errorInfo()));
    }
}}