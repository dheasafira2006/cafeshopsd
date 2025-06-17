<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'koneksi.php';
require_once 'user.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

$db = (new Database())->connection();
$userObj = new User($db);

$email = $_SESSION['email'];
$user = $userObj->getByEmail($email);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['tipe'] === 'karyawan' && empty($_POST['jabatan'])) {
        echo "<script>alert('Jabatan harus diisi untuk karyawan'); window.history.back();</script>";
        exit;
    }

    // Set semua nilai
    $userObj->setNama($_POST['nama']);
    $userObj->setEmail($_POST['email']);
    $userObj->setPassword($_POST['password']); // Kosongkan jika tidak ingin diubah
    $userObj->setNoHp($_POST['no_hp']);
    $userObj->setAlamat($_POST['alamat']);
    $userObj->setTipe($_POST['tipe']);
    $userObj->setJabatan($_POST['tipe'] === 'karyawan' ? $_POST['jabatan'] : '');

    $updateSuccess = $userObj->updateByEmail($email);

    if ($updateSuccess) {
        $_SESSION['email'] = $_POST['email']; // Perbarui session jika email berubah
        echo "<script>alert('Profil berhasil diperbarui'); window.location='profil.php';</script>";
        exit;
    } else {
        echo "<script>alert(" . json_encode("Gagal memperbarui profil: " . $userObj->getLastError()) . ");</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Profil</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function toggleJabatan() {
      const tipe = document.getElementById('tipe').value;
      const jabatanField = document.getElementById('jabatanField');
      jabatanField.style.display = (tipe === 'karyawan') ? 'block' : 'none';
    }
    window.onload = toggleJabatan;
  </script>
</head>
<body>

<div class="container small">
  <h2 class="riwayat">Edit Profil</h2>
  <p style="text-align: center;">Perbarui data pribadi Anda di bawah ini.</p>

  <form class="profile-form" method="post">
    <input type="hidden" id="tipe" name="tipe" value="<?= htmlspecialchars($user['TIPE']) ?>">

    <label>Nama Lengkap:</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($user['NAMA']) ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['EMAIL']) ?>" required>

    <label>Password:</label>
    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ubah password">

    <label>No. HP:</label>
    <input type="text" name="no_hp" value="<?= htmlspecialchars($user['NO_HP']) ?>">

    <label>Alamat:</label>
    <input type="text" name="alamat" value="<?= htmlspecialchars($user['ALAMAT']) ?>">

    <div id="jabatanField" style="display: <?= isset($user['TIPE']) && $user['TIPE'] == 'karyawan' ? 'block' : 'none' ?>;">
      <label>Jabatan (Untuk Karyawan):</label>
      <input type="text" name="jabatan" value="<?= isset($user['JABATAN']) ? htmlspecialchars($user['JABATAN']) : '' ?>">
    </div>

    <div class="button-group">
      <button type="submit">📂 Simpan Perubahan</button>
      <a href="profil.php"><button type="button">BATAL</button></a>
    </div>
  </form>
</div>
</body>
</html>