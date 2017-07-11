<?php

namespace Utility\Import;

use Utility\Import\AbstractStockRateImporter;
use Utility\CsvFileIterator;

class HistoricStockRateImporter extends AbstractStockRateImporter
{
    public function __construct(CsvFileIterator $file)
    {
        parent::__construct($file);

        unset($this->stockRatesArray[0]);
    }
}
