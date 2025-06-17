<?php
require_once "koneksi.php";

// Koneksi database menggunakan PDO
$db = (new Database())->connection();

// Ambil data reservasi
$query = "SELECT * FROM reservasi ORDER BY ID_RESERVASI DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$reservasi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Reservasi | Café Sugar Daddy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    <h1>Café Sugar Daddy</h1>
    <p>Beranda karyawan</p>
    </header>

    <!-- Navbar -->
  <nav>
  <a href="dashboard_user.php">Dashboard</a>
  <a href="view_menu.php">Produk</a>
  <a href="view_pesanPelanggan.php">Pesanan</a>
  <a href="view_reservasi.php">Reservasi</a>
  <a href="profil.php">Profil</a>
  <a href="index.php">Logout</a>
</nav>

<h2>📋 Daftar Reservasi Café Sugar Daddy</h2>
<div class="container">
    <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Jumlah Orang</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Area</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($reservasi) > 0): ?>
            <?php foreach ($reservasi as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['id_reservasi']) ?></td>
                    <td><?= htmlspecialchars($r['nama']) ?></td>
                    <td><?= htmlspecialchars($r['telepon']) ?></td>
                    <td><?= htmlspecialchars($r['jumlah_orang']) ?></td>
                    <td><?= htmlspecialchars($r['tanggal']) ?></td>
                    <td><?= htmlspecialchars($r['jam']) ?></td>
                    <td><?= htmlspecialchars($r['area']) ?></td>
                    <td><?= htmlspecialchars($r['catatan']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8">Belum ada reservasi.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</div>
</body>
</html>
