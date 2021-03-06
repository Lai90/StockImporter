<?php
require_once(__DIR__.'/vendor/autoload.php');

use Utility\Log;
use Domain\StockSymbolCollection;
use Utility\Import\HistoricStockRateImporter;
use Utility\Export\StockRatesFirebaseExporter;
use Utility\CsvFileIterator;
use Respect\Validation\Exceptions\NestedValidationException;

$stockRateFirebaseExporter = new StockRatesFirebaseExporter(__DIR__.'/firebase_credentials.json');

$directory = new \DirectoryIterator(__DIR__."/var/stock_history/");

$symbolCollection = new StockSymbolCollection();

foreach($directory as $file) {
	if($file->getExtension() == 'mst') {
		try {
			$csv = new CsvFileIterator($file->getPathname());

			Log::info("Started Processing.", array($file->getFilename()));

			$importer = new HistoricStockRateImporter($csv, new \DateTime("2017-01-01"));
			$importer->process();

			Log::info("Finished Processing. Saving collection to DB.", array($file->getFilename()));

			$stockRateFirebaseExporter->syncWithDatabase($importer->getCollection(), false);

			Log::info("Finished Saving. Unlinking file.", array($file->getFilename()));

			unlink($file->getPathname());
		}
		catch (NestedValidationException $e) {
			Log::error("Failed to process file - validation error.", array($e->getMessages(), $file->getFilename()));
		}
		catch (\Exception $e) {
			Log::error("Failed to process file.", array($e->getMessage(), $file->getFilename()));
		}
	}
}
