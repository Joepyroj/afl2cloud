<?php
require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

$firebaseCredentials = getenv('FIREBASE_CREDENTIALS_JSON');
$serviceAccountArray = json_decode($firebaseCredentials, true);
$factory = (new Factory)->withServiceAccount($serviceAccountArray);

$auth = $factory->createAuth();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $user = $auth->createUserWithEmailAndPassword($email, $password);
        $message = 'User berhasil dibuat. Silakan login.';
    } catch (\Kreait\Firebase\Exception\Auth\EmailExists $e) {
        $message = 'Email sudah terdaftar.';
    } catch (\Throwable $e) {
        $message = 'Terjadi kesalahan: '.$e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container_signup">
    <h2>Sign Up</h2>
    <?php if ($message): ?>
        <p style="color: red; text-align: center;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="POST" class="user-formsignup">
        <input type="email" name="email" placeholder="Email" class="form-input" required>
        <input type="password" name="password" placeholder="Password" class="form-input" required>
        <button type="submit" class="form-buttonsignup">Sign Up</button>
    </form>
    <p style="text-align:center;">Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>
</body>
</html>
