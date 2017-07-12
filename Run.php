<?php
require_once(__DIR__.'/vendor/autoload.php');

use Utility\Import\TodaysStockRateImporter;
use Utility\Export\StockRatesFirebaseExporter;
use Utility\CsvFileIterator;
use Utility\Log;

$file = new CsvFileIterator("https://bossa.pl/pub/metastock/mstock/sesjaall/sesjaall.prn");
$importer = new TodaysStockRateImporter($file);
$importer->process();

$symbolCollection = $importer->getCollection();

var_dump($symbolCollection);
//$stockRateFirebaseExporter = new StockRatesFirebaseExporter(__DIR__.'/firebase_credentials.json');

Log::info("Sending today rates to Firebase");

//$stockRateFirebaseExporter->syncWithDatabase($symbolCollection);

Log::info("Sending today rates to Firebase finished.");
