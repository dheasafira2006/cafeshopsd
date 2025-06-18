
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once "koneksi.php";

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

function kirim_email($to, $name, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'alamatemail';
        $mail->Password   = 'password';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('alamatemail', 'Email Verifikasi');
        $mail->addAddress($to, $name);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    } catch (Exception $e) {
        echo "Gagal kirim email: {$mail->ErrorInfo}";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $db = (new Database())->connection();

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $kode = rand(100000, 999999);

        // Simpan kode ke database
        $stmt = $db->prepare("UPDATE users SET token_ganti = ? WHERE email = ?");
        $stmt->execute([$kode, $email]);

        $_SESSION['reset_email'] = $email;

        $subjek = "Kode Reset Password";
        $isi = "Kode OTP Anda adalah: <b>$kode</b>";
        kirim_email($email, $email, $subjek, $isi);

        header("Location: verifikasikode.php");
        exit();
    } else {
        echo "<script>alert('Email tidak ditemukan!'); window.location='lupapassword.php';</script>";
    }
}
?>
