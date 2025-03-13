<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulir Pengguna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="containerform">
        <form method="POST" action="create.php" class="user-form">
            <input type="text" name="name" placeholder="Nama" required class="form-input"><br>
            <input type="email" name="email" placeholder="Email" required class="form-input"><br>
            <input type="text" name="age" placeholder="Usia" required class="form-input"><br>
            <input type="number" name="kelas" placeholder="Kelas" required class="form-input"><br>
            <button type="submit" class="form-button">Submit</button>
        </form>

        <form method="GET" action="read.php" class="view-data-form">
            <button type="submit" class="view-data-button">Tampilkan Data</button>
        </form>
    </div>
</body>
</html>