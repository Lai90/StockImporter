<?php

require_once("vendor/autoload.php");

use Utility\TodaysStockRateImporter;

$importer = new TodaysStockRateImporter();
$importer->process();