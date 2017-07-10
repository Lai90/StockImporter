<?php

namespace Utility;

use Domain\StockRate;
use Domain\StockSymbol;
use Domain\StockSymbolCollection;
use Domain\StockRateCollection;
use Money\Money;
use Utility\AbstractStockRateImporter;

class HistoricStockRateImporter extends AbstractStockRateImporter
{
    protected function processRateArray(Array &$array)
    {
        
    }

    protected function processArrayToCollection()
    {
    	
    }

    public function process() : StockSymbolCollection
    {
    	$this->processStreamToArray();
    	$this->processArrayToCollection();

    	return $this->getCollection();
    }
}
