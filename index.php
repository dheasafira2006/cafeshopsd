<?php
session_start();
require_once "koneksi.php";

$error = "";

try {
    $db = (new Database())->connection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Ambil data user berdasarkan email
        $stmt = $db->prepare("SELECT * FROM users WHERE EMAIL = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['PASSWORD'])) {
            $_SESSION['email'] = $user['EMAIL'];
            $_SESSION['role']  = $user['TIPE']; // 'karyawan' atau 'pelanggan'
            $_SESSION['nama']  = $user['NAMA'];
            $_SESSION['ID_USER'] = $user['ID_USER'];
            echo "Login sukses: ID = " . $_SESSION['ID_USER'];

            // Redirect sesuai role
            if ($user['TIPE'] === 'karyawan') {
                header("Location: dashboard_user.php");
            } else {
                header("Location: beranda.php");
            }
            exit;
        }

        $error = "Email atau password salah.";
    }
} catch (Exception $e) {
    $error = "Terjadi kesalahan koneksi: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Login - Sugar Daddy Caffe Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <h1>Caffe Shop Sugar Daddy</h1>
        <h2>Login</h2>
        
        <?php if (!empty($error)) { echo "<p style='color: red;'>$error</p>"; } ?>

        <form method="POST">
            <table>
                <tr>
                    <td><label for="email">Email</label></td>
                    <td><input type="email" id="email" name="email" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td><label for="password">Kata Sandi</label></td>
                    <td><input type="password" id="password" name="password" required autocomplete="off"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Masuk</button>
                    </td>
                </tr>
            </table>
        </form>

        <div class="link-container">
            <a href="lupapassword.php" class="forgot-password">Lupa Password?</a>
            <a href="daftar.php" class="register-link">Belum Punya Akun?</a>
        </div>
    </div>
</body>
</html>