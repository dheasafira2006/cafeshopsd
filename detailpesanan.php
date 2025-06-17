<?php
class DetailPesanan {
    private $conn;
      public $id_pesanan;
    public $id_menu;
    public $jumlah;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function tambah() {
    $query = "INSERT INTO detail_pesanan (ID_PESANAN, ID_MENU, JUMLAH) VALUES (:id_pesanan, :id_menu, :jumlah)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_pesanan', $this->id_pesanan);
    $stmt->bindParam(':id_menu', $this->id_menu);
    $stmt->bindParam(':jumlah', $this->jumlah);
    if (!$stmt->execute()) {
        throw new Exception("Error tambah detail: " . implode(" | ", $stmt->errorInfo()));
    }
}}