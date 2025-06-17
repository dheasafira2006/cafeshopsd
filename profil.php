<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'koneksi.php';
require_once 'user.php';

$db = (new Database())->connection();
$userObj = new User($db);

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location='index.php';</script>";
    exit;
}

$email = $_SESSION['email'];
$user = $userObj->getByEmail($email);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profil Saya</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Café Sugar Daddy</h1>
  <p>Kopi & Kenyamanan di Satu Tempat</p>
</header>

<nav>
  <?php if ($user['TIPE'] === 'karyawan'): ?>
    <a href="dashboard_user.php">Beranda</a>
  <?php else: ?>
    <a href="beranda.php">Beranda</a>
  <?php endif; ?>
  <a href="profil.php">Profil</a>
  <a href="index.php">Logout</a>
</nav>
<h2 class="riwayat">Profil Saya</h2>
<div class="container">
  <table >
    <tr>
      <td style="padding: 10px; text-align: left;"><strong>Nama Lengkap</strong></td>
      <td style="padding: 10px; text-align: left;">: <?= htmlspecialchars($user['NAMA']) ?></td>
    </tr>
    <tr>
      <td style="padding: 10px; text-align: left;"><strong>Email</strong></td>
      <td style="padding: 10px; text-align: left;">: <?= htmlspecialchars($user['EMAIL']) ?></td>
    </tr>
    <tr>
      <td style="padding: 10px; text-align: left;"><strong>No. HP</strong></td>
      <td style="padding: 10px; text-align: left;">: <?= htmlspecialchars($user['NO_HP']) ?></td>
    </tr>
    <tr>
      <td style="padding: 10px; text-align: left;"><strong>Alamat</strong></td>
      <td style="padding: 10px; text-align: left;">: <?= htmlspecialchars($user['ALAMAT']) ?></td>
    </tr>
    <?php if (isset($user['TIPE'])): ?>
    <tr>
      <td style="padding: 10px; text-align: left;"><strong>Tipe Akun</strong></td>
      <td style="padding: 10px; text-align: left;">: <?= htmlspecialchars(ucfirst($user['TIPE'])) ?></td>
    </tr>
      <?php if ($user['TIPE'] === 'karyawan'): ?>
      <tr>
        <td style="padding: 10px; text-align: left;"><strong>Jabatan</strong></td>
        <td style="padding: 10px; text-align: left;">: <?= htmlspecialchars($user['JABATAN']) ?></td>
      </tr>
      <?php endif; ?>
    <?php endif; ?>
    <tr>
      <td colspan="2" style="text-align: center; padding-top: 20px;">
        <a href="editprofil.php"><button type="button">Edit Profil</button></a>
      </td>
    </tr>
  </table>
</div>

<footer>
  <p>&copy; 2025 Café Sugar Daddy | Follow us: Instagram, TikTok, WhatsApp</p>
</footer>
</body>
</html>