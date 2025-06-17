<?php

use PhpParser\Node\Stmt\Else_;
require_once "koneksi.php";
require_once "query_menu.php";

$db = (new Database())->connection();
$menu = new Menu($db);

if (isset($_GET['delete'])) {
    $menu->ID_MENU = $_GET['delete'];
    $menu->delete();
    header("location:view_menu.php");
    exit;
}
$data = $menu->tampilkan();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manajemen menu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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

    <h2>Manajemen Menu</h2>
    <div class="search-box">
    <form method="GET" action="view_menu.php">
      <input type="text" name="keyword" placeholder="Cari nama atau kategori menu..." 
             value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
      <input type="submit" value="Cari">
      <a href="view_menu.php">Reset</a>
    </form>
    <br>
    <a href="input_menu.php" style="color: #fff; background-color: #28a745; padding: 8px 12px; border-radius: 4px;">+ Input Menu</a>
    </div>

    <div class="container">
    <table>
    <tr>
        <th>No</th>
        <th>Gambar</th>
        <th>Kategori</th>
        <th>Nama Menu</th>
        <th>Harga</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>
        <?php 
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $no = 1;

        if (!empty($keyword)){
            echo "<p style='text-align:center; color:green;'>Menampilkan hasil pencarian untuk: <strong>" .  htmlspecialchars($keyword) . "</strong></p>";
            $query = "SELECT * FROM menu
                        WHERE NAMA_MENU LIKE '%$keyword%'
                        OR KATEGORI LIKE '%$keyword%'
                        ORDER BY NAMA_MENU ASC";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $data = $stmt;
        } else {
            $data = $menu->tampilkan();
        }

        while ($row = $data->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['ID_MENU'] ?></td>
                <td><img src="uploads/<?php echo $row['GAMBAR']; ?>" width='150'></td>
                <td><?php echo $row['KATEGORI'] ?></td>
                <td><?php echo $row['NAMA_MENU'] ?></td>
                <td><?php echo $row['HARGA_MENU'] ?></td>
                <td><?php echo $row['DESKRIPSI'] ?></td>
                <td class="action">
                <a href="input_menu.php?edit=<?php echo $row['ID_MENU']; ?>">Edit</a>
                <a href="view_menu.php?delete=<?php echo $row['ID_MENU']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
            </tr>
        <?php endwhile;
        ?>
    </table>
    </div>
</body>
</html>