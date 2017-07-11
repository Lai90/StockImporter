<?php
require_once(__DIR__.'/vendor/autoload.php');

use Domain\StockSymbolCollection;
use Utility\Import\HistoricStockRateImporter;
use Utility\Export\StockRatesFirebaseExporter;
use Utility\CsvFileIterator;

$stockRateFirebaseExporter = new StockRatesFirebaseExporter(__DIR__.'/firebase_credentials.json');

$directory = new \DirectoryIterator(__DIR__."/var/stock_history/");

$symbolCollection = new StockSymbolCollection();

$i = 0;
foreach($directory as $file) {
	if($file->getExtension() == 'mst') {
		$csv = new CsvFileIterator($file->getPathname());
		echo "Processing ".$file->getFilename()."\n";
		$importer = new HistoricStockRateImporter($csv);
		$importer->process();
		echo "Processed. Saving collection to DB.\n";
		$stockRateFirebaseExporter->syncWithDatabase($importer->getCollection());
	}
	
	$i++;
	if($i > 3) { break; }
}
