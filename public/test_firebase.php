<?php
require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;

$firebaseCredentials = getenv('FIREBASE_CREDENTIALS_JSON');
if (!$firebaseCredentials) {
    die("ENV FIREBASE_CREDENTIALS_JSON not found");
}

$serviceAccountArray = json_decode($firebaseCredentials, true);
$serviceAccountArray['private_key'] = str_replace("\\n", "\n", $serviceAccountArray['private_key']);

$factory = (new Factory)->withServiceAccount($serviceAccountArray);
$auth = $factory->createAuth();

echo "Firebase Auth berhasil konek!";
