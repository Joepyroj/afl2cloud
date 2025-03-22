<?php
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

// Ambil ENV variable
$firebaseCredentials = getenv('FIREBASE_CREDENTIALS_JSON');

if (!$firebaseCredentials) {
    die("FIREBASE_CREDENTIALS_JSON env not found.");
}

$serviceAccountArray = json_decode($firebaseCredentials, true);

// ✅ Tambahkan konversi fix \n → newline (INI KRUSIAL!)
if (isset($serviceAccountArray['private_key'])) {
    $serviceAccountArray['private_key'] = str_replace(["\\n", "\r\n", "\r"], "\n", $serviceAccountArray['private_key']);
}

// ✅ Simpan ulang ke file sementara (REKOMENDASI TERAKHIR)
$tempFile = sys_get_temp_dir() . '/firebase_cred.json';
file_put_contents($tempFile, json_encode($serviceAccountArray));

// Buat koneksi Firebase
$factory = (new Factory)
    ->withServiceAccount($tempFile)
    ->withDatabaseUri('https://aflcloudjulius-default-rtdb.asia-southeast1.firebasedatabase.app/');

$auth = $factory->createAuth();
$database = $factory->createDatabase();
