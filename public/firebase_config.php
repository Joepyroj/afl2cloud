<?php
require __DIR__ . '/../vendor/autoload.php';

use Kreait\Firebase\Factory;

// Ambil isi credentials dari environment variable
$firebaseCredentials = getenv('FIREBASE_CREDENTIALS_JSON');

if (!$firebaseCredentials) {
    die("Environment variable 'FIREBASE_CREDENTIALS_JSON' tidak ditemukan.");
}

$serviceAccountArray = json_decode($firebaseCredentials, true);

// Tambahkan database URI secara eksplisit
$databaseUri = 'https://aflcloudjulius-default-rtdb.asia-southeast1.firebasedatabase.app/'; // Ganti sesuai milikmu

$factory = (new Factory)
    ->withServiceAccount($serviceAccountArray)
    ->withDatabaseUri($databaseUri); // <--- Tambahkan ini

$auth = $factory->createAuth();
$database = $factory->createDatabase();
