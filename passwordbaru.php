<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasipassword'];

    if ($password !== $konfirmasi) {
        echo "<script>alert('Password tidak sama!'); window.location='passwordbaru.php';</script>";
        exit;
    }

    // Ubah password di database
    $email = $_SESSION['reset_email'];

    if (!$email) {
        echo "<script>alert('Sesi tidak valid. Silakan ulangi proses.'); window.location='lupapassword.php';</script>";
        exit;
    }

    try {
        $db = (new Database())->connection();
        $query = "UPDATE users SET PASSWORD = :password WHERE EMAIL = :email";
        $stmt = $db->prepare($query);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        unset($_SESSION['reset_email']);
        unset($_SESSION['reset_kode']);

        echo "<script>alert('Password berhasil diubah. Silakan login.'); window.location='index.php';</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <div class="password">
            <h3>Atur ulang Password</h3>
            <p>Masukkan Password</p>
    
            <form action="passwordbaru.php" method="post">
                <div class="passwordbaru">
                    <label for="Password">Password Baru:</label><br>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="konfirmasi">
                    <label for="konfirmasipassword">konfirmasi Password:</label><br>
                    <input type="password" id="konfirmasipassword" name="konfirmasipassword" required>
                </div>
                <input type="submit" name="kirim" value="Simpan Password" onclick="resetPassword()">
            </form>
        </div>
        <div class="message">
            <p>Sudah ingat password? <a href="index.php"><br>Kembali ke halaman masuk</a></p>
        </div>
    </div>
</body>
</html>