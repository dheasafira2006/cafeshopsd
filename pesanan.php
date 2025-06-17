<?php
class Pesanan {
    private $conn;
    public$id_antrian;
    public $id_user;
    public $id_pesanan;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function tambah() {
    $query = "INSERT INTO pesanan (ID_ANTRIAN, ID_USER) VALUES (:id_antrian, :id_user)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_antrian', $this->id_antrian);
    $stmt->bindParam(':id_user', $this->id_user);
    
    if (!$stmt->execute()) {
        throw new Exception("Error tambah pesanan: " . implode(" | ", $stmt->errorInfo()));
    }
      $this->id_pesanan = $this->conn->lastInsertId();
}
}