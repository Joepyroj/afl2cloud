<?php
require_once 'firebase_config.php';


if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $userRef = $database->getReference('users/' . $userId);
    $userRef->remove();

    // Redirect ke read.php setelah penghapusan berhasil
    header("Location: read.php");
    exit;
} else {
    echo "Akses tidak sah.";
}
?>