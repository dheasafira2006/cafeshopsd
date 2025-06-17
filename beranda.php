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
    <h1>Caffe Sugar Daddy</h1>
    <p>Kopi & Kenyamanan di Satu Tempat</p>
  </header>

  <!-- Navbar -->
  <nav>
    <a href="beranda.php">Beranda</a>
    <a href="menu.php">Menu</a>
    <a href="keranjang.php">Keranjang</a>
    <a href="reservasi.php">Reservasi</a>
    <a href="view_pesanan.php">Riwayat</a>
    <a href="profil.php">Profil</a>
    <a href="index.php">Logout</a>
  </nav>

 <!-- Hero Section -->
 <div class="hero">
    <h1>Selamat Datang di Caffe Sugar Daddy</h1>
    <p>Temukan kehangatan dan ketenangan dalam setiap<br> tegukan di cafe sugar daddy. Suasana premium, <br> kopi berkualitas, dan layanan terbaik menanti anda</p>
  </div>

 
  <!-- Menu Preview -->
  <section>
    <h2 class="section-title">Menu Favorit</h2>
    <div class="menu-preview">
      <div class="menu-item">
        <img src="foto/cappucino.jpg" alt="Cappuccino" />
        <h3>Cappuccino</h3>
        <p>Rp 25.000</p>
      </div>
      <div class="menu-item">
        <img src="foto/butter croissants.jpg" alt="Croissant" />
        <h3>Croissant</h3>
        <p>Rp 18.000</p>
      </div>
      <div class="menu-item">
        <img src="foto/caramel latte.jpg" alt="Latte" />
        <h3>Caramel Latte</h3>
        <p>Rp 30.000</p>
      </div>
    </div>
  </section>

  <!-- Galeri -->
  <section>
    <h2 class="section-title">Suasana Café</h2>
    <div class="gallery">
      <div class="gallery-item"><img src="foto/suasana1.jpg" /></div>
      <div class="gallery-item"><img src="foto/suasana3.jpg" /></div>
      <div class="gallery-item"><img src="foto/suasana4.jpg" /></div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Caffe Sugar Daddy | Follow us: Instagram, TikTok, WhatsApp</p>
  </footer>
</body>
</html>