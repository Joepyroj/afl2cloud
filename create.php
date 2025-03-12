<?php
require 'firebase_config.php';

if ($_SERVER['REQUEST_METHOD']== 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $kelas = $_POST['kelas'];

    $newPostRef = $database->getReference('users')->push([
        'name'=>$name,
        'email'=>$email,
        'age'=>$age,
        'kelas'=>$kelas,
    ]);

    $message = "Data berhasil disimpan!";
} 
include 'form.php'; // Sertakan template HTML
?>

 


