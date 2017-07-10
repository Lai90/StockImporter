<?php

namespace Utility;

use Domain\StockSymbolCollection;

abstract class AbstractStockRateImporter
{
	protected $stockRatesArray;
	protected $symbolCollection;

	abstract protected function processArrayToCollection();
	abstract public function process() : StockSymbolCollection;

    public function __construct()
    {
         $this->symbolCollection = new StockSymbolCollection();
    }

    public function getCollection()
    {
        return $this->symbolCollection;
    }

    protected function processStreamToArray()
    {
    	while(($data = fgetcsv($this->ratesFileStream, 10000, ',')) !== false)
    	{
    		$this->stockRatesArray[] = $data;
    	}
    }
}