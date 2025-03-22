<?php
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

// Ambil isi credentials dari environment variable
$firebaseCredentials = getenv('FIREBASE_CREDENTIALS_JSON');

if (!$firebaseCredentials) {
    die("Environment variable 'FIREBASE_CREDENTIALS_JSON' tidak ditemukan.");
}

// Decode JSON string ke array
$serviceAccountArray = json_decode($firebaseCredentials, true);

// Cek dan fix jika private_key masih dalam format \n
if (isset($serviceAccountArray['private_key'])) {
    $serviceAccountArray['private_key'] = str_replace("\\n", "\n", $serviceAccountArray['private_key']);
}

// Simpan ke file sementara
$tempFilePath = sys_get_temp_dir() . '/firebase_credentials.json';
file_put_contents($tempFilePath, json_encode($serviceAccountArray));

// Tambahkan database URI secara eksplisit
$databaseUri = 'https://aflcloudjulius-default-rtdb.asia-southeast1.firebasedatabase.app/';

// Buat instance Firebase
$factory = (new Factory)
    ->withServiceAccount($tempFilePath)
    ->withDatabaseUri($databaseUri);

$auth = $factory->createAuth();
$database = $factory->createDatabase();
