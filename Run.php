<?php

require_once("vendor/autoload.php");

use Utility\TodaysStockRateImporter;

$importer = new TodaysStockRateImporter("http://bossa.pl/pub/metastock/mstock/sesjaall/sesjaall.prn");
$importer->process();