<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css">
  <title>Reservasi Meja | Café Sugar Daddy</title>
  <style>
    #notifikasi {
      color: green;
      font-weight: bold;
      margin-top: 20px;
      padding: 10px;
      border: 1px solid green;
      border-radius: 5px;
      background-color: #e0ffe0;
    }
  </style>
</head>
<body>
  <header>
    <h1>Café Sugar Daddy</h1>
    <p>Rasakan cita rasa terbaik dari biji kopi pilihan dan camilan spesial kami.</p>
  </header>

  <!-- Navbar -->
  <nav>
    <a href="beranda.php">Beranda</a>
    <a href="menu.php">Menu</a>
    <a href="keranjang.php">Keranjang</a>
    <a href="reservasi.php">Reservasi</a>
    <a href="view_pesanan.php">Riwayat</a>
    <a href="profil.php">Profil</a>
  </nav>

  <div class="containerh2">
    <h1 class="reservasi">Reservasi Meja</h1>

    <!-- Notifikasi (jika ada) -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
      <div id="notifikasi">✅ Reservasi berhasil dikirim!</div>
    <?php endif; ?>

    <!-- Form -->
    <form action="simpanreservasi.php" method="POST">
      <label for="nama">Nama Lengkap</label>
      <input type="text" name="nama" id="nama" required />

      <label for="telepon">Nomor WhatsApp</label>
      <input type="tel" name="telepon" id="telepon" required />

      <label for="jumlah">Jumlah Orang</label>
      <input type="number" name="jumlah" id="jumlah" min="1" max="20" required />

      <label for="tanggal">Tanggal</label>
      <input type="date" name="tanggal" id="tanggal" required />

      <label for="jam">Jam</label>
      <input type="time" name="jam" id="jam" required />

      <label for="area">Area yang Diinginkan</label>
      <select name="area" id="area" required>
        <option value="">Pilih Area</option>
        <option value="Indoor">Indoor</option>
        <option value="Outdoor">Outdoor</option>
        <option value="Smoking">Smoking Area</option>
      </select>

      <label for="catatan">Catatan Tambahan (Opsional)</label>
      <textarea name="catatan" id="catatan" rows="3"></textarea>

      <button type="submit">Kirim Reservasi</button>

      <p class="note">Kami akan mengonfirmasi melalui WhatsApp dalam 1x24 jam.</p>
    </form>
  </div>

  <footer>
    <p>&copy; 2025 Café Sugar Daddy | Follow us: Instagram, TikTok, WhatsApp</p>
  </footer>
</body>
</html>