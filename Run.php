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

$stockRateFirebaseExporter = new StockRatesFirebaseExporter(__DIR__.'/firebase_credentials.json');

Log::info("Sending today rates to Firebase", array(new \DateTime()->format("Y-m-d")));

$stockRateFirebaseExporter->syncWithDatabase($symbolCollection);

Log::info("Sending today rates to Firebase finished.", array(new \DateTime()->format("Y-m-d")));
