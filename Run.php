<?php
require_once(__DIR__.'/vendor/autoload.php');

use Utility\TodaysStockRateImporter;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$importer = new TodaysStockRateImporter("https://bossa.pl/pub/metastock/mstock/sesjaall/sesjaall.prn");
$importer->process();

$symbolCollection = $importer->getCollection();


$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/firebase_credentials.json');
$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->create();


$database = $firebase->getDatabase();
