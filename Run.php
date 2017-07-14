<?php
require_once(__DIR__.'/vendor/autoload.php');

use Utility\Import\TodaysStockRateImporter;
use Utility\Export\StockRatesFirebaseExporter;
use Utility\CsvFileIterator;
use Utility\Log;
use Respect\Validation\Exceptions\NestedValidationException;

try {
	$file = new CsvFileIterator("https://bossa.pl/pub/metastock/mstock/sesjaall/sesjaall.prn");
	$importer = new TodaysStockRateImporter($file);
	$importer->process();

	$symbolCollection = $importer->getCollection();

	$stockRateFirebaseExporter = new StockRatesFirebaseExporter(__DIR__.'/firebase_credentials.json');

	Log::info("Sending today rates to Firebase");

	$stockRateFirebaseExporter->syncWithDatabase($symbolCollection, true);

	Log::info("Sending today rates to Firebase finished.");
}
catch (NestedValidationException $e) {
	Log::error("Failed to process file - validation error.", array($e->getMessages()));
}
catch (\Exception $e) {
	Log::error("Failed to process file.", array($e->getMessage()));
}
