<?php
class Menu{

    private $conn;
    private $table = "menu";
    public $ID_MENU, $NAMA_MENU, $KATEGORI, $HARGA_MENU, $GAMBAR, $DESKRIPSI, $OLDID_MENU;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} (ID_MENU, NAMA_MENU, KATEGORI, HARGA_MENU, GAMBAR, DESKRIPSI) VALUES (?,?,?,?,?,?)";
        $statement = $this->conn->prepare($query);
        return $statement->execute([$this->ID_MENU,$this->NAMA_MENU,$this->KATEGORI,$this->HARGA_MENU,$this->GAMBAR,$this->DESKRIPSI]);
    }

    public function update() {
        $query = "UPDATE {$this->table} SET ID_MENU =?, NAMA_MENU=?, KATEGORI=?, HARGA_MENU=?, GAMBAR=?, DESKRIPSI=? WHERE ID_MENU = ?";
        $statement = $this->conn->prepare($query);
        return $statement->execute([$this->ID_MENU,$this->NAMA_MENU,$this->KATEGORI,$this->HARGA_MENU,$this->GAMBAR,$this->DESKRIPSI,$this->OLDID_MENU]);
    }
    public function tampilkan() {
        return $this->conn->query("SELECT * FROM {$this->table}");
    }

    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE ID_MENU = ?";
        $statement = $this->conn->prepare($query);
        return $statement->execute([$this->ID_MENU]);
    }

    public function cari($id) {
        $statement = $this->conn->prepare("SELECT * FROM {$this->table} WHERE ID_MENU =?");
        $statement->execute([$id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
?>
