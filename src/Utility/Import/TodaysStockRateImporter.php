<?php

namespace Utility\Import\Import;

use Domain\StockRate;
use Domain\StockSymbol;
use Domain\StockSymbolCollection;
use Domain\StockRateCollection;
use Money\Money;
use Utility\Import\AbstractStockRateImporter;

class TodaysStockRateImporter extends AbstractStockRateImporter
{
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

    public function process()
    {
    	$this->processArrayToCollection();

        return $this;
    }
}
