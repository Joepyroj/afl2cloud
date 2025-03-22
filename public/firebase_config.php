<?php
date_default_timezone_set('Asia/Jakarta');
echo "Server time: " . date('c') . "<br>";
require __DIR__ . '/vendor/autoload.php';

use Kreait\Firebase\Factory;

$base64 = getenv("FIREBASE_CREDENTIALS_BASE64");
if (!$base64) {
    die("FIREBASE_CREDENTIALS_BASE64 not found.");
}

$jsonCredentials = base64_decode($base64);
$tempFile = sys_get_temp_dir() . '/firebase_credentials.json';
file_put_contents($tempFile, $jsonCredentials);

$factory = (new Factory)
    ->withServiceAccount($tempFile)
    ->withDatabaseUri('https://aflcloudjulius-default-rtdb.asia-southeast1.firebasedatabase.app/');

$auth = $factory->createAuth();
$database = $factory->createDatabase();
