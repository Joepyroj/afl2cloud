<?php
require 'firebase_config.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $userRef = $database->getReference('users/' . $userId);
    $user = $userRef->getValue();

    if (!$user) {
        echo "Data tidak ditemukan.";
        exit;
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $kelas = $_POST['kelas'];

    $userRef = $database->getReference('users/' . $userId);
    $userRef->update([
        'name' => $name,
        'email' => $email,
        'age' => $age,
        'kelas' => $kelas,
    ]);

    // Redirect ke read.php setelah pembaruan berhasil
    header("Location: read.php");
    exit;
} else {
    echo "Akses tidak sah.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengguna</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="container"> 
        <h2>Edit Pengguna</h2>
        <form method="POST" action="edit.php" class="edit-form">
            <input type="hidden" name="id" value="<?php echo $userId; ?>">
            <input type="text" name="name" placeholder="Nama" value="<?php echo $user['name']; ?>" required class="form-input"><br>
            <input type="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" required class="form-input"><br>
            <input type="text" name="age" placeholder="Usia" value="<?php echo $user['age']; ?>" required class="form-input"><br>
            <input type="number" name="kelas" placeholder="Kelas" value="<?php echo $user['kelas']; ?>" required class="form-input"><br>
            <button type="submit" class="form-button">Submit</button>
        </form>

        <form method="GET" action="read.php" class="back-form">
            <button type="submit" class="back-button">Back</button>
        </form>
    </div>
</body>
</html>