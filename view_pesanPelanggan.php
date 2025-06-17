<?php
session_start();
require 'koneksi.php';

$db = new Database();
$conn = $db->connection();

// Cek apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'karyawan') {
    echo "Akses ditolak. Hanya karyawan yang bisa melihat halaman ini.";
    exit;
}

$sql = "
    SELECT 
        u.NAMA AS NAMA_USER,
        a.NO_ANTRIAN,
        a.TANGGAL AS TGL_ANTRIAN,
        m.NAMA_MENU,
        dp.JUMLAH,
        m.HARGA_MENU,
        t.METODE_PENGAMBILAN,
        t.METODE_PEMBAYARAN,
        t.ALAMAT
    FROM pesanan p
    LEFT JOIN antrian a ON p.ID_ANTRIAN = a.ID_ANTRIAN
    LEFT JOIN detail_pesanan dp ON p.ID_PESANAN = dp.ID_PESANAN
    LEFT JOIN menu m ON dp.ID_MENU = m.ID_MENU
    LEFT JOIN transaksi t ON p.ID_PESANAN = t.ID_PESANAN
    LEFT JOIN users u ON p.ID_USER = u.ID_USER
    ORDER BY a.TANGGAL DESC, p.ID_PESANAN DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view pesanan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
  <header>
    <h1>Café Sugar Daddy</h1>
    <p>Beranda karyawan</p>
  </header>

  <!-- Navbar -->
  <nav>
  <a href="dashboard_user.php">Beranda</a>
  <a href="view_menu.php">Produk</a>
  <a href="view_pesanPelanggan.php">Pesanan</a>
  <a href="view_reservasi.php">Reservasi</a>
  <a href="profil.php">Profil</a>
  <a href="index.php">Logout</a>
</nav>
    <h2>Semua Riwayat Pesanan</h2>
    <div class="container">
        <?php if (empty($rows)): ?>
  <p>Belum ada pesanan.</p>
<?php else: ?>

  <table>
    <thead>
      <tr>
        <th>No. Antrian</th>
        <th>Tanggal Pesanan</th>
        <th>Menu</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
        <th>Metode</th>
        <th>Alamat (jika delivery)</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= htmlspecialchars($r['NO_ANTRIAN']) ?></td>
          <td><?= htmlspecialchars($r['TGL_ANTRIAN']) ?></td>
          <td><?= htmlspecialchars($r['NAMA_MENU']) ?></td>
          <td><?= htmlspecialchars($r['JUMLAH']) ?></td>
          <td>Rp <?= number_format($r['JUMLAH'] * $r['HARGA_MENU'],0,',','.') ?></td>
          <td>
            <?= htmlspecialchars($r['METODE_PENGAMBILAN']) ?> /
            <?= htmlspecialchars($r['METODE_PEMBAYARAN']) ?>
          </td>
          <td><?= htmlspecialchars($r['ALAMAT'] ?: '-') ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
</div>
</body>
</html>