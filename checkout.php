<?php
session_start();
if (!isset($_SESSION['ID_USER'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location='index.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Checkout Pembayaran</h2>
<div class="container">
<form onsubmit="prosesPembayaran(event)">
  <label>Metode Pengambilan:</label>
  <select id="metode_pengambilan" required>
    <option value="">-- Pilih --</option>
    <option value="Dine-in">Dine-in</option>
    <option value="Delivery">Delivery</option>
  </select><br>

  <input type="text" id="alamat" placeholder="Alamat (jika Delivery)" /><br>

  <label>Metode Pembayaran:</label>
  <select id="metode_pembayaran" required>
    <option value="">-- Pilih --</option>
    <option value="Cash">Cash</option>
    <option value="Transfer Bank">Transfer Bank</option>
  </select><br>

  <button type="submit">Konfirmasi & Bayar</button>
</form>
</div>

<script>
function prosesPembayaran(e) {
    e.preventDefault();

    const keranjang = JSON.parse(localStorage.getItem("keranjang")) || [];
    const metode_pengambilan = document.getElementById("metode_pengambilan").value;
    const alamat = document.getElementById("alamat").value;
    const metode_pembayaran = document.getElementById("metode_pembayaran").value;

    if (!keranjang.length || !keranjang.every(item => item.id_menu && item.jumlah)) {
        alert("Item keranjang tidak lengkap.");
        return;
    }

    if (!metode_pengambilan || !metode_pembayaran) {
        alert("Lengkapi metode pengambilan dan pembayaran.");
        return;
    }

    if (metode_pengambilan === "Delivery" && !alamat) {
        alert("Alamat wajib untuk pengambilan Delivery.");
        return;
    }

    fetch("prosespembayaran.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ keranjang, metode_pengambilan, alamat, metode_pembayaran })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Pembayaran berhasil. No Antrian Anda: " + data.no_antrian);
            localStorage.removeItem("keranjang");
            window.location.href = "beranda.php";
        } else {
            alert("Gagal: " + data.message);
        }
    })
    .catch(err => {
        alert("Terjadi kesalahan: " + err.message);
    });
}
</script>
</body>
</html>