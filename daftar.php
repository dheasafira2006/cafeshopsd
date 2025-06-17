<?php
require_once 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $NAMA       = $_POST['nama'];
    $EMAIL      = $_POST['email'];
    $PASSWORD   = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $NO_HP      = $_POST['no_hp'];
    $TIPE       = $_POST['tipe'];
    $JABATAN    = ($_POST['tipe'] === 'karyawan') ? $_POST['jabatan'] : null;
    $ALAMAT     = $_POST['alamat'];

    $db = new Database();
    $conn = $db->connection();

    try {
        $cek = $conn->prepare("SELECT ID_USER FROM users WHERE EMAIL = :email");
        $cek->execute([':email' => $EMAIL]);

        if ($cek->rowCount() > 0) {
            echo "<script>alert('Email sudah terdaftar!');</script>";
            exit;
        }

        $query = "INSERT INTO users (NAMA, EMAIL, PASSWORD, NO_HP, TIPE, JABATAN, ALAMAT) 
                VALUES (:nama, :email, :password, :no_hp, :tipe, :jabatan, :alamat)";

        $stmt = $conn->prepare($query);
        $stmt->execute([
            ':nama'     => $NAMA,
            ':email'    => $EMAIL,
            ':password' => $PASSWORD,
            ':no_hp'    => $NO_HP,
            ':tipe'     => $TIPE,
            ':jabatan'  => $JABATAN,
            ':alamat'   => $ALAMAT
        ]);

        echo "<script>alert('Pendaftaran berhasil!'); window.location='index.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Gagal mendaftar: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Caffe Sugar Daddy</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <section>
        <div class="form-container">
            <h1 class="pendaftaran">Formulir Pendaftaran</h1>
            <form method="POST">
                <label for="tipe">Daftar Sebagai:</label>
                <select name="tipe" id="tipe" onchange="toggleJabatan()" required>
                    <option value="">-- Pilih Jenis Akun --</option>
                    <option value="pelanggan">Pelanggan</option>
                    <option value="karyawan">Karyawan</option>
                </select> 
                
                <br>
                <br>

                <label>Nama Lengkap:</label>
                <input type="text" name="nama" required>

                <label>Email:</label>
                <input type="email" name="email" required>

                <label>Password:</label>
                <input type="password" name="password" required>

                <label>No. HP:</label>
                <input type="text" name="no_hp">

                <label>Alamat:</label>
                <input type="text" name="alamat">

                <div id="jabatanField" style="display: none;">
                    <label>Jabatan (Untuk Karyawan):</label>
                    <input type="text" name="jabatan">
                </div>

                <div class="button-group">
                    <button type="submit">DAFTAR</button>
                    <a href="index.php"><button type="button">BATAL</button></a>
                </div>
            </form>
        </div>
    </section>

    <script>
        function toggleJabatan() {
            var tipe = document.getElementById('tipe').value;
            var jabatanField = document.getElementById('jabatanField');
            jabatanField.style.display = (tipe === 'karyawan') ? 'block' : 'none';
        }
    </script>
</body>
</html>