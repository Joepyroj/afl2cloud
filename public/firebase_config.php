<?php   
require __DIR__ . '/vendor/autoload.php';
use Kreait\Firebase\Factory;

// Ambil isi credentials dari environment variable
$firebaseCredentials = getenv('FIREBASE_CREDENTIALS_JSON');

if (!$firebaseCredentials) {
    die("Environment variable 'FIREBASE_CREDENTIALS_JSON' tidak ditemukan.");
}

// Decode JSON string
$serviceAccountArray = json_decode($firebaseCredentials, true);

// Inisialisasi Firebase
$factory = (new Factory)->withServiceAccount($serviceAccountArray);

// Inisialisasi Auth dan Database
$auth = $factory->createAuth();
$database = $factory->createDatabase();

?>