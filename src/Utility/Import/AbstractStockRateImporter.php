<?php

namespace Utility\Import;

use Domain\StockSymbolCollection;
use Domain\StockRateCollection;
use Domain\StockRate;
use Domain\StockSymbol;
use Money\Money;
use Utility\CsvFileIterator;
use Utility\Import\Exception\InvalidDataException;
use Respect\Validation\Validator as v;

abstract class AbstractStockRateImporter
{
	protected $stockRatesArray;
	protected $symbolCollection;
    protected $file;

    public function __construct(CsvFileIterator $file)
    {
        $this->file = $file;
        $this->symbolCollection = new StockSymbolCollection();
    }

    protected function processFileToArray()
    {
        foreach ($this->file as $data) {
            $this->stockRatesArray[] = $data;
        }
    }

    protected function validateArray()
    {
        foreach ($this->stockRatesArray as $data) {
            $validation = v::keySet(
                v::key(0, v::stringType()),
                v::key(1, v::date('Ymd')),
                v::key(2, v::floatVal()),
                v::key(3, v::floatVal()),
                v::key(4, v::floatVal()),
                v::key(5, v::floatVal()),
                v::key(6, null, false),
                v::key(7, null, false)
            )->assert($data);
        }
    }

    protected function processArrayToCollection()
    {
        foreach($this->getStockRatesArray() as $stockRateArray)
        {
            $rate = $this->createRate($stockRateArray);

            $rateCollection = new StockRateCollection();
            $rateCollection->add($rate);

            $symbol = new StockSymbol($stockRateArray[0], $rateCollection);
            $this->symbolCollection->add($symbol);
        }
    }

    public function createRate($stockRateArray)
    {
        $this->processRateArray($stockRateArray);

        $rate = new StockRate(
            new \DateTime($stockRateArray[1]),
            Money::PLN($stockRateArray[2]),
            Money::PLN($stockRateArray[5]),
            Money::PLN($stockRateArray[3]),
            Money::PLN($stockRateArray[4])
        );

        return $rate;
    }

    protected function getStockRatesArray()
    {
        return $this->stockRatesArray;
    }

    public function getCollection()
    {
        return $this->symbolCollection;
    }

    protected function processRateArray(Array &$array)
    {
        for($i = 2; $i <= 5; $i++) {
            $array[$i] = (int)$array[$i]*100;
        }
    }

    public function process()
    {
        $this->processFileToArray();
        $this->validateArray();
        $this->processArrayToCollection();
    }
}