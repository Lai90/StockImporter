<?php

namespace Utility\Import;

use Utility\Import\AbstractStockRateImporter;
use Utility\CsvFileIterator;

class HistoricStockRateImporter extends AbstractStockRateImporter
{
    public function processFileToArray()
    {
        parent::processFileToArray();

        unset($this->stockRatesArray[0]);
    }
}
