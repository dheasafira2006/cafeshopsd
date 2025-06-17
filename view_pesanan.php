<?php
session_start();
require 'koneksi.php'; // Pastikan file ini mengandung koneksi $conn = new PDO(...);

$db = new Database();
$conn = $db->connection();
// Ambil ID_USER dari session
if (!isset($_SESSION['ID_USER'])) {
    echo "Anda belum login.";
    exit;
}
$id_user = $_SESSION['ID_USER'];

$sql = "
    SELECT 
        a.NO_ANTRIAN,
        a.TANGGAL AS TGL_ANTRIAN,
        m.NAMA_MENU,
        dp.JUMLAH,
        m.HARGA_MENU,
        t.METODE_PENGAMBILAN,
        t.METODE_PEMBAYARAN,
        t.ALAMAT
    FROM pesanan p
    JOIN antrian a ON p.ID_ANTRIAN = a.ID_ANTRIAN
    JOIN detail_pesanan dp ON p.ID_PESANAN = dp.ID_PESANAN
    JOIN menu m ON dp.ID_MENU = m.ID_MENU
    JOIN transaksi t ON p.ID_PESANAN = t.ID_PESANAN
    WHERE p.ID_USER = ?
    ORDER BY a.TANGGAL DESC, p.ID_PESANAN DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_user]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view pesanan</title>
    <link rel="stylesheet" href="style.css">
<header>
    <h1>Café Sugar Daddy</h1>
    <p>Rasakan cita rasa terbaik dari biji kopi pilihan dan camilan spesial kami.</p>
  </header>

</head>
<body>
    <!-- Navbar -->
  <nav>
    <a href="beranda.php">Beranda</a>
    <a href="menu.php">Menu</a>
    <a href="keranjang.php">Keranjang</a>
    <a href="reservasi.php">Reservasi</a>
    <a href="view_pesanan.php">Riwayat</a>
    <a href="profil.php">Profil</a>
  </nav>
    <h2>Riwayat Pesanan Anda</h2>
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

<footer>
  <p>&copy; 2025 Café Sugar Daddy | Follow us: Instagram, TikTok, WhatsApp</p>
</footer>