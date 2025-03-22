<?php
require_once 'firebase_config.php';

use Kreait\Firebase\Exception\Auth\InvalidPassword;
use Kreait\Firebase\Exception\Auth\UserNotFound;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Coba login
        $signInResult = $auth->signInWithEmailAndPassword($email, $password);
        $user = $auth->getUserByEmail($email);

        // Cek email sudah diverifikasi?
        if (!$user->emailVerified) {
            $message = "Email belum diverifikasi. Cek inbox kamu.";
        } else {
            // Login sukses
            session_start();
            $_SESSION['user'] = $user->uid;
            $_SESSION['email'] = $email;
            header("Location: form.php");
            exit;
        }

    } catch (InvalidPassword $e) {
        $message = "Password salah.";
    } catch (UserNotFound $e) {
        $message = "Akun tidak ditemukan.";
    } catch (\Throwable $e) {
        $message = "Terjadi kesalahan: " . $e->getMessage();
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
