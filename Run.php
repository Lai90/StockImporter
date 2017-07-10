<?php
require_once(__DIR__.'/vendor/autoload.php');

use Utility\TodaysStockRateImporter;
use Utility\StockRatesFirebaseExporter;

$importer = new TodaysStockRateImporter("https://bossa.pl/pub/metastock/mstock/sesjaall/sesjaall.prn");
$importer->process();

$symbolCollection = $importer->getCollection();
$stockRateFirebaseExporter = new StockRatesFirebaseExporter(__DIR__.'/firebase_credentials.json');

$stockRateFirebaseExporter->syncWithDatabase($symbolCollection);
