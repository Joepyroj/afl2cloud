<?php   
require __DIR__ . '/vendor/autoload.php';
use Kreait\Firebase\Factory;

$factory = (new Factory) 
    ->withServiceAccount(__DIR__ . '/firebase_credentials.json') //Ganti dengan file JSON firebase anda
    ->withDatabaseUri('https://aflcloudjulius-default-rtdb.asia-southeast1.firebasedatabase.app/');

    $database = $factory->createDatabase();
?>