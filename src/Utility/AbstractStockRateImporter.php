<?php

namespace Utility;

use Domain\StockSymbolCollection;

abstract class AbstractStockRateImporter
{
	protected $stockRatesArray;
	protected $symbolCollection;
    protected $fileStream;

	abstract protected function processArrayToCollection();
	abstract public function process() : StockSymbolCollection;

    public function __construct(string $fileUrl)
    {
        $this->fileStream = fopen($fileUrl, 'r');
        $this->symbolCollection = new StockSymbolCollection();
    }

    public function getCollection()
    {
        return $this->symbolCollection;
    }

    protected function processStreamToArray()
    {
    	while(($data = fgetcsv($this->fileStream, 10000, ',')) !== false)
    	{
    		$this->stockRatesArray[] = $data;
    	}
    }
}