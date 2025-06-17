 <?php
session_start();
if (!isset($_SESSION['ID_USER'])) {
    echo "<script>alert('Silakan login dahulu'); window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Belanja</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Café Sugar Daddy</h1>
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
  </nav>

<h2>Keranjang Belanja</h2>
<div class="container">
<table>
  <thead>
    <tr>
      <th>Id Menu</th>
      <th>Menu</th>
      <th>Harga</th>
      <th>Jumlah</th>
      <th>Total</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody id="tabelKeranjang"></tbody>
</table>

<p id="totalKeseluruhan"></p>

<button onclick="checkout()">Checkout</button>
</div>

<script>
function tampilkanKeranjang() {
    const keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
    const tabel = document.getElementById("tabelKeranjang");
    let total = 0;

    tabel.innerHTML = "";

    keranjang.forEach((item, index) => {
        const subtotal = item.harga * item.jumlah;
        total += subtotal;

        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${item.id_menu ?? "undefined"}</td>
            <td>${item.nama}</td>
            <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
            <td>${item.jumlah}</td>
            <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
            <td><button onclick="hapusItem(${index})">Hapus</button></td>
        `;
        tabel.appendChild(row);
    });

    document.getElementById("totalKeseluruhan").innerText = `Total: Rp ${total.toLocaleString('id-ID')}`;
}

function hapusItem(index) {
    const keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
    keranjang.splice(index, 1);
    localStorage.setItem("keranjang", JSON.stringify(keranjang));
    tampilkanKeranjang();
}

function checkout() {
    window.location.href = "checkout.php";
}

window.onload = tampilkanKeranjang;
</script>
</body>
</html>