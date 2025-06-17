<?php
session_start();
require_once 'koneksi.php';
require_once 'user.php';

// Gunakan satu koneksi database saja
$database = new Database();
$db = $database->connection();
$userObj = new User($db);

if (!isset($_SESSION['ID_USER'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location='index.php';</script>";
    exit;
}

$id_user = $_SESSION['ID_USER'];

// Gunakan PDO untuk query
try {
    $stmt_minuman = $db->prepare("SELECT * FROM menu WHERE kategori = 'minuman'");
    $stmt_minuman->execute();
    $minuman = $stmt_minuman->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt_makanan = $db->prepare("SELECT * FROM menu WHERE kategori = 'makanan'");
    $stmt_makanan->execute();
    $makanan = $stmt_makanan->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Café Sugar Daddy</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Café Sugar Daddy</h1>
        <p>Rasakan cita rasa terbaik dari biji kopi pilihan dan camilan spesial kami.</p>
    </header>

    <nav>
        <a href="beranda.php">Beranda</a>
        <a href="menu.php">Menu</a>
        <a href="keranjang.php">Keranjang</a>
        <a href="reservasi.php">Reservasi</a>
        <a href="view_pesanan.php">Riwayat</a>
        <a href="profil.php">Profil</a>
    </nav>

    <div class="container1">
        <h2>☕ Minuman</h2>
        <div class="menu-grid">
            <?php if (!empty($minuman)): ?>
                <?php foreach ($minuman as $row): ?>
                    <div class="menu-item">
                        <img src="uploads/<?= htmlspecialchars($row['GAMBAR']) ?>" 
                             alt="<?= htmlspecialchars($row['NAMA_MENU']) ?>" 
                             width="500" height="500">
                        <h3><?= htmlspecialchars($row['NAMA_MENU']) ?></h3>
                        <p><?= htmlspecialchars($row['DESKRIPSI']) ?></p>
                        <div class="HARGA_MENU">Rp <?= number_format($row['HARGA_MENU'], 0, ',', '.') ?></div>
                        <button class="order-btn" data-id="<?= $row['ID_MENU'] ?>">Pesan Sekarang</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada minuman tersedia.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="container1">
        <h2>🍰 Makanan Ringan</h2>
        <div class="menu-grid">
            <?php if (!empty($makanan)): ?>
                <?php foreach ($makanan as $row): ?>
                    <div class="menu-item">
                        <img src="uploads/<?= htmlspecialchars($row['GAMBAR']) ?>" 
                             alt="<?= htmlspecialchars($row['NAMA_MENU']) ?>" 
                             width="500" height="500">
                        <h3><?= htmlspecialchars($row['NAMA_MENU']) ?></h3>
                        <p><?= htmlspecialchars($row['DESKRIPSI']) ?></p>
                        <div class="HARGA_MENU">Rp <?= number_format($row['HARGA_MENU'], 0, ',', '.') ?></div>
                        <button class="order-btn" data-id="<?= $row['ID_MENU'] ?>">Pesan Sekarang</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada makanan tersedia.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Café Sugar Daddy | Follow us: Instagram, TikTok, WhatsApp</p>
    </footer>

    <script>
        const buttons = document.querySelectorAll(".order-btn");
        buttons.forEach((btn) => {
            btn.addEventListener("click", function () {
                const menuItem = this.closest(".menu-item");
                const nama = menuItem.querySelector("h3").innerText;
                const hargaText = menuItem.querySelector(".HARGA_MENU").innerText;
                const harga = parseInt(hargaText.replace(/[^\d]/g, ""));
                const id_menu = parseInt(this.dataset.id);
                
                let keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
                const index = keranjang.findIndex(item => item.id_menu === id_menu);
                
                if (index !== -1) {
                    keranjang[index].jumlah += 1;
                } else {
                    keranjang.push({ id_menu, nama, harga, jumlah: 1 });
                }
                
                localStorage.setItem("keranjang", JSON.stringify(keranjang));
                alert(`${nama} ditambahkan ke keranjang!`);
            });
        });
    </script>
</body>
</html>