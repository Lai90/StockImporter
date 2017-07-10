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

        if (file_exists($this->getCacheFile()) && (filemtime($this->getCacheFile()) > (time() - 21600))) {
            $this->fileStream = fopen($this->getCacheFile(), 'r');
        }
        else {
            $this->fileStream = fopen($this->fileUrl, 'r');
            file_put_contents($this->getCacheFile(), $this->fileStream);
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

    public function getCacheFile()
    {
        return __DIR__."/../../var/cache/".basename($this->fileUrl);
    }
}