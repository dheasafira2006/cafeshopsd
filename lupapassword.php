<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <h2>Lupa Password</h2>
        <p>Masukkan email anda:</p>
        <form action="kodereset.php" method="post">
        <input type="email" name="email" placeholder="email@gmail.com" required>
        <input type="submit" name="kirim" value="Kirim Reset Password">
</form>

    <div class="message">
        <p>Sudah ingat password? <a href="index.php"><br>Kembali ke halaman masuk</a></p>
    </div>
</body>
</html>