<?php
session_start();
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="style.css">
  <title>Café Sugar Daddy</title>
  
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

<div class="hero">
    <h1>Selamat Datang di Café Sugar Daddy</h1>
    <p>Temukan kehangatan dan ketenangan dalam setiap<br> tegukan di cafe sugar daddy. Suasana premium, <br> kopi berkualitas, dan layanan terbaik menanti anda</p>
  </div>
  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Café Sugar Daddy | Follow us: Instagram, TikTok, WhatsApp</p>
  </footer>
</body>
</html>