<?php
session_start();
require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

$factory = (new Factory)->withServiceAccount(__DIR__.'/firebase_credentials.json');
$auth = $factory->createAuth();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
        $_SESSION['user'] = $signInResult->firebaseUserId();
        header('Location: form.php');
        exit;
    } catch (\Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
        $message = 'Password salah.';
    } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
        $message = 'User tidak ditemukan.';
    } catch (\Throwable $e) {
        $message = 'Login gagal: '.$e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="containerlogin">
    <h2>Login</h2>
    <?php if ($message): ?>
        <p style="color: red; text-align: center;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="POST" class="user-formlogin">
        <input type="email" name="email" placeholder="Email" class="form-input" required>
        <input type="password" name="password" placeholder="Password" class="form-input" required>
        <button type="submit" class="form-buttonlogin">Login</button>
    </form>
    <p style="text-align:center;">Belum punya akun? <a href="sign-up.php">Daftar di sini</a></p>
</div>
</body>
</html>
