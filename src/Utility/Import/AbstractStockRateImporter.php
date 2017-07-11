<?php

namespace Utility;

use Domain\StockSymbolCollection;

abstract class AbstractStockRateImporter
{
	protected $stockRatesArray;
	protected $symbolCollection;
    protected $fileStream;
    protected $fileUrl;

	abstract protected function processArrayToCollection();
	abstract public function process();

    public function __construct(string $fileUrl)
    {
        $this->fileUrl = $fileUrl;
        $this->symbolCollection = new StockSymbolCollection();

        if ($this->isFileExternal() && file_exists($this->getCacheFile()) && (filemtime($this->getCacheFile()) > (time() - 21600))) {
            $this->fileStream = fopen($this->getCacheFile(), 'r');
        }
        else {
            $this->fileStream = fopen($this->fileUrl, 'r');
            if($this->isFileExternal()) {
                file_put_contents($this->getCacheFile(), $this->fileStream);
            }
        }

        $this->processStreamToArray();
    }

    public function getCollection()
    {
        return $this->symbolCollection;
    }

    protected function processStreamToArray()
    {
        while (($data = fgetcsv($this->fileStream, 10000, ',')) !== false) {
            $this->stockRatesArray[] = $data;
        }
    }

    protected function processRateArray(Array &$array)
    {
        for($i = 2; $i <= 5; $i++) {
            $array[$i] = (int)$array[$i]*100;
        }
    }

    public function isFileExternal()
    {
        if(stristr($this->fileUrl, "http")) {
            return true;
        }

        return false;
    }

    public function getCacheFile()
    {
        return __DIR__."/../../var/cache/".basename($this->fileUrl);
    }
}