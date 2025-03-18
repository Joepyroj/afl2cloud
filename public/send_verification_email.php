<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

function sendVerificationEmail($toEmail, $verificationLink) {
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'youremail@gmail.com';         // Ganti dengan email kamu
        $mail->Password   = 'your_app_password';           // Ganti dengan App Password dari langkah 1
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('youremail@gmail.com', 'Admin Website');
        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Email Anda';
        $mail->Body    = "Silakan klik link berikut untuk verifikasi:<br><a href='$verificationLink'>$verificationLink</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}
