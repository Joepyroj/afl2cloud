<?php
require_once 'firebase_config.php';

use Kreait\Firebase\Exception\Auth\EmailExists;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $userProperties = [
            'email' => $email,
            'emailVerified' => false,
            'password' => $password,
            'disabled' => false,
        ];

        $createdUser = $auth->createUser($userProperties);

        // Kirim link verifikasi email
        $verifyLink = $auth->getEmailVerificationLink($email);

        // Kirim email menggunakan mail()
        $subject = "Verifikasi Email Anda";
        $headers = "From: admin@domainanda.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body = "Hai,<br>Silakan klik link berikut untuk verifikasi email kamu:<br><a href='$verifyLink'>$verifyLink</a>";

        if (mail($email, $subject, $body, $headers)) {
            $message = "Akun berhasil dibuat. Silakan cek email untuk verifikasi.";
        } else {
            $message = "Akun dibuat, tapi gagal mengirim email verifikasi.";
        }

    } catch (EmailExists $e) {
        $message = "Email sudah terdaftar.";
    } catch (\Throwable $e) {
        $message = "Terjadi kesalahan: " . $e->getMessage();
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
