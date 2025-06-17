<?php
require_once "koneksi.php";
require_once "query_menu.php";

$db = (new Database())->connection();
$menu = new Menu($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $menu->ID_MENU = $_POST['ID_MENU'] ?? null;
    $menu->KATEGORI = $_POST['KATEGORI'];
    $menu->NAMA_MENU = $_POST['NAMA_MENU'];
    $menu->HARGA_MENU = $_POST['HARGA_MENU'] ;
    $menu->DESKRIPSI = $_POST['DESKRIPSI'] ;
    $menu->GAMBAR = $_POST['GAMBAR'] ;
    $menu->OLDID_MENU = $_POST['OLDID_MENU'] ?? null;

    $uploadDir = 'uploads/';
    if (isset($_FILES['GAMBAR']) && $_FILES['GAMBAR']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['GAMBAR']['tmp_name'];
    $fileName = time() . '_' . basename($_FILES['GAMBAR']['name']); // pakai time() agar unik
    $destination = $uploadDir . $fileName;

    move_uploaded_file($fileTmpPath, $destination);
    $menu->GAMBAR = $fileName;
    } else {
    $menu->GAMBAR = $editData['GAMBAR'] ?? '';
    }

    if(!empty($_POST['isEdit'])){
        $menu->update();
    }else{
        $menu->create();
    }
    header("location:view_menu.php");
    exit;
}
$editData = null;

if (isset($_GET['edit'])){
    $editData = $menu->cari($_GET['edit']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>input menu</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h2><?= $editData ? 'Edit' : 'Tambah' ?> Menu</h2>
    <div class="container">
    <form method="POST" enctype="multipart/form-data">
        <?php if ($editData): ?>
            <input type="hidden" name="OLDID_MENU" value="<?= $editData['ID_MENU'] ?>">
        <?php endif; ?>
            <label >ID_MENU:</label>
            <input type="text" name="ID_MENU" value=" <?= $editData['ID_MENU'] ?? '' ?>" required>
        
        <label>Kategori:</label>
        <select name="KATEGORI" id="KATEGORI" required>
            <option value="minuman" <?= isset($editData['KATEGORI']) && $editData['KATEGORI'] == 'minuman' ? 'selected' : '' ?>>Minuman</option>
            <option value="makanan" <?= isset($editData['KATEGORI']) && $editData['KATEGORI'] == 'makanan' ? 'selected' : '' ?>>Makanan</option>
        </select>
 
        
        <label>Nama Menu:</label>
        <input type="text" name="NAMA_MENU" value="<?= $editData['NAMA_MENU'] ?? '' ?>" required>

        <label>Harga:</label>
        <input type="number" name="HARGA_MENU" value="<?= $editData['HARGA_MENU'] ?? '' ?>" required>

        <label>Deskripsi:</label>
        <input type="text" name="DESKRIPSI" id="<?= $editData['DESKRIPSI'] ?? '' ?>" required>

        <label>GAMBAR:</label>
        <input type="file" name="GAMBAR" <?= $editData ? '' : 'required' ?>>

        <?php if ($editData): ?>
            <input type="hidden" name="isEdit" value="1">
        <?php endif; ?>

        <button type="submit"><?= $editData ? 'Update' : 'Simpan' ?></button>
    </form>
    <a href="view_menu.php">← Kembali ke daftar</a>
    </div>
</body>
</html>