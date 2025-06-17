<?php
class Database {
    private $host = "sql200.infinityfree.com";
    private $username = "if0_39235891";      
    private $password = "wQdwPufgCQ4cc";
    private $dbname = "if0_39235891_CRUD";
    private $port = 3306;
    private $conn;

    public function connection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
    throw new Exception("Koneksi ke database gagal: " . $exception->getMessage());
    }
        return $this->conn;
    }
}