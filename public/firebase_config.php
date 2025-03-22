<?php
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

date_default_timezone_set('Asia/Jakarta'); // Fix timezone issue

$base64Credentials = getenv('FIREBASE_CREDENTIALS_BASE64');

if (!$base64Credentials) {
    die('FIREBASE_CREDENTIALS_BASE64 env variable not found.');
}

// Decode base64
$credentialsJson = base64_decode($base64Credentials);

// Cek validitas JSON
$jsonData = json_decode($credentialsJson, true);
if (!$jsonData || !isset($jsonData['type']) || $jsonData['type'] !== 'service_account') {
    die('Invalid or corrupted service account credentials. Check FIREBASE_CREDENTIALS_BASE64.');
}

// Simpan sementara
$tmpFile = tempnam(sys_get_temp_dir(), 'firebase_credentials_');
file_put_contents($tmpFile, $credentialsJson);

// Init Firebase
$factory = (new Factory)->withServiceAccount($tmpFile);
$auth = $factory->createAuth();
