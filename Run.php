<?php
require_once(__DIR__.'/vendor/autoload.php');

use Utility\Import\TodaysStockRateImporter;
use Utility\Export\StockRatesFirebaseExporter;
use Utility\CsvFileIterator;

$file = new CsvFileIterator("https://bossa.pl/pub/metastock/mstock/sesjaall/sesjaall.prn");
$importer = new TodaysStockRateImporter($file);
$importer->process();

$symbolCollection = $importer->getCollection();
$stockRateFirebaseExporter = new StockRatesFirebaseExporter(__DIR__.'/firebase_credentials.json');

$stockRateFirebaseExporter->syncWithDatabase($symbolCollection);
