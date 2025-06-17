<?php
// File: User.php (refactor OOP full)
class User {
    private $conn;
    private $nama;
    private $email;
    private $password;
    private $noHp;
    private $alamat;
    private $tipe;
    private $jabatan;
    private $lastError = '';

public function getLastError() {
    return $this->lastError;
}

    public function __construct($db) {
        $this->conn = $db;
    }

    // Getter dan Setter
    public function setNama($nama)       { $this->nama = $nama; }
    public function setEmail($email)     { $this->email = $email; }
    public function setPassword($pw)     { $this->password = $pw; }
    public function setNoHp($noHp)       { $this->noHp = $noHp; }
    public function setAlamat($alamat)   { $this->alamat = $alamat; }
    public function setTipe($tipe)   { $this->tipe = $tipe; }
    public function setJabatan($jabatan) { $this->jabatan = $jabatan; }

    public function getByEmail($email) {
        $query = "SELECT * FROM users WHERE EMAIL = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateByEmail($emailLama) {
        try {
            $sql = "UPDATE users SET 
                        NAMA = :nama,
                        EMAIL = :email,
                        NO_HP = :no_hp,
                        ALAMAT = :alamat,
                        TIPE = :tipe,
                        JABATAN = :jabatan";

            if (!empty($this->password)) {
                $sql .= ", PASSWORD = :password";
            }

            $sql .= " WHERE EMAIL = :email_condition";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nama', $this->nama);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':no_hp', $this->noHp);
            $stmt->bindParam(':alamat', $this->alamat);
            $stmt->bindParam(':tipe', $this->tipe);
            $stmt->bindParam(':jabatan', $this->jabatan);
            $stmt->bindParam(':email_condition', $emailLama);

            if (!empty($this->password)) {
                $hashed = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $hashed);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage(); // Simpan error
        return false;
        }
    }
}