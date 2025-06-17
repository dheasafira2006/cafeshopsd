
<?php
session_start();
require_once "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kodeInput = $_POST['kode'];
    $email = $_SESSION['reset_email'] ?? null;

    if ($email) {
        $db = (new Database())->connection();
        $stmt = $db->prepare("SELECT token_ganti FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $kodeInput == $user['token_ganti']) {
            header("Location: passwordbaru.php");
            exit;
        } else {
            echo "<script>alert('Kode salah!'); window.location='verifikasikode.php';</script>";
        }
    } else {
        echo "<script>alert('Sesi tidak ditemukan'); window.location='lupapassword.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Kode</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<div class="container">
    <h2>Verifikasi Kode</h2>
    <form method="post">
        <input type="text" name="kode" placeholder="Masukkan kode OTP" required maxlength="6">
        <input type="submit" value="Verifikasi">
    </form>
</div>
</body>
</html>