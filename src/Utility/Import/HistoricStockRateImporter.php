<?php

namespace Utility\Import;

use Domain\StockRate;
use Domain\StockSymbol;
use Domain\StockSymbolCollection;
use Domain\StockRateCollection;
use Money\Money;
use Utility\Import\AbstractStockRateImporter;

class HistoricStockRateImporter extends AbstractStockRateImporter
{
    public function __construct(string $fileUrl)
    {
        parent::__construct($fileUrl);

        unset($this->stockRatesArray[0]);
    }

    protected function processArrayToCollection()
    {
        foreach($this->stockRatesArray as $stockRateArray)
        {
            $this->processRateArray($stockRateArray);

            $rate = new StockRate(
                new \DateTime($stockRateArray[1]),
                Money::PLN($stockRateArray[2]),
                Money::PLN($stockRateArray[5]),
                Money::PLN($stockRateArray[3]),
                Money::PLN($stockRateArray[4])
            );

            $rateCollection = new StockRateCollection();
            $rateCollection->add($rate);

            $symbol = new StockSymbol($stockRateArray[0], $rateCollection);

            $this->symbolCollection->add($symbol);
        }
    }

    public function process() : StockSymbolCollection
    {
    	$this->processArrayToCollection();

    	return $this->getCollection();
    }
}
