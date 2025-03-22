<?php
// Pastikan tidak ada output sebelumnya yang mengganggu
if (ob_get_length()) {
    ob_end_clean();
}

require __DIR__ . '/vendor/autoload.php';

// Gunakan stderr untuk logging agar terlihat di Render.com
file_put_contents('php://stderr', "Starting firebase_config.php initialization\n");

use Kreait\Firebase\Factory;

// Tampilkan waktu server untuk debugging (akan muncul di log Render)
file_put_contents('php://stderr', "Server Time (UTC): " . gmdate("Y-m-d H:i:s") . "\n");
file_put_contents('php://stderr', "Server Time (Local): " . date("Y-m-d H:i:s") . "\n");

// Ambil isi credentials dari environment variable
$firebaseCredentials = getenv('FIREBASE_CREDENTIALS_JSON');
if (!$firebaseCredentials) {
    file_put_contents('php://stderr', "Error: Environment variable 'FIREBASE_CREDENTIALS_JSON' tidak ditemukan.\n");
    die("Environment variable 'FIREBASE_CREDENTIALS_JSON' tidak ditemukan.");
}

// Log kredensial mentah untuk memastikan diterima (hanya sebagian untuk keamanan)
file_put_contents('php://stderr', "Raw credentials (partial): " . substr($firebaseCredentials, 0, 50) . "...\n");

// Decode JSON string ke array
$serviceAccountArray = json_decode($firebaseCredentials, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    file_put_contents('php://stderr', "JSON decode error: " . json_last_error_msg() . "\n");
    die("Invalid JSON in FIREBASE_CREDENTIALS_JSON: " . json_last_error_msg());
}

// Log isi array kredensial untuk debugging (tanpa private_key penuh untuk keamanan)
file_put_contents('php://stderr', "Credentials decoded: " . print_r(array_diff_key($serviceAccountArray, ['private_key' => '']), true) . "\n");

// Cek dan fix jika private_key masih dalam format \n
if (isset($serviceAccountArray['private_key'])) {
    $serviceAccountArray['private_key'] = str_replace("\\n", "\n", $serviceAccountArray['private_key']);
    file_put_contents('php://stderr', "Private key processed (partial): " . substr($serviceAccountArray['private_key'], 0, 50) . "...\n");
} else {
    file_put_contents('php://stderr', "Error: private_key tidak ditemukan dalam credentials.\n");
    die("private_key tidak ditemukan dalam FIREBASE_CREDENTIALS_JSON.");
}

// Simpan ke file sementara untuk debugging
$tempFilePath = sys_get_temp_dir() . '/firebase_credentials.json';
if (file_put_contents($tempFilePath, json_encode($serviceAccountArray)) === false) {
    file_put_contents('php://stderr', "Error: Gagal menyimpan kredensial ke file sementara di $tempFilePath\n");
    die("Gagal menyimpan kredensial ke file sementara.");
} else {
    file_put_contents('php://stderr', "Credentials saved to temp file: $tempFilePath\n");
}

// Tambahkan database URI secara eksplisit
$databaseUri = 'https://aflcloudjulius-default-rtdb.asia-southeast1.firebasedatabase.app/';

try {
    $factory = (new Factory)
        ->withServiceAccount($serviceAccountArray)
        ->withDatabaseUri($databaseUri);

    $auth = $factory->createAuth();
    $database = $factory->createDatabase();
    file_put_contents('php://stderr', "Firebase Auth dan Database berhasil diinisialisasi.\n");
} catch (\Throwable $e) {
    file_put_contents('php://stderr', "Error inisialisasi Firebase: " . $e->getMessage() . " | Stack trace: " . $e->getTraceAsString() . "\n");
    die("Gagal menginisialisasi Firebase: " . $e->getMessage());
}