<?php

date_default_timezone_set('Asia/Jakarta');
require_once 'firebase_config.php';
require_once 'send_verification_email.php';

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

        // Buat pengguna baru
        $createdUser = $auth->createUser($userProperties);
        error_log("User created successfully: " . $createdUser->uid); // Log keberhasilan

        // Kirim link verifikasi email
        $verifyLink = $auth->getEmailVerificationLink($email);

        // Kirim email menggunakan mail()
        $mailResult = sendVerificationEmail($email, $verifyLink);

        if ($mailResult === true) {
            $message = "Akun berhasil dibuat. Silakan cek email untuk verifikasi.";
        } else {
            $message = "Akun dibuat, tapi gagal mengirim email verifikasi. Error: " . $mailResult;
        }

    } catch (EmailExists $e) {
        $message = "Email sudah terdaftar.";
        error_log("Signup error: " . $e->getMessage() . " | Stack trace: " . $e->getTraceAsString()); // Log error khusus
    } catch (\Throwable $e) {
        error_log("Signup error: " . $e->getMessage() . " | Stack trace: " . $e->getTraceAsString()); // Log error umum
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