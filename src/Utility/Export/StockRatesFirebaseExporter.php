<?php

namespace Utility\Export;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Domain\StockSymbolCollection;
use Utility\Log;

class StockRatesFirebaseExporter
{
	protected $firebase;

	public function __construct($configuration)
	{			
		$serviceAccount = ServiceAccount::fromJsonFile($configuration);
		$this->firebase = (new Factory)
		    ->withServiceAccount($serviceAccount)
		    ->create();
	}

	public function getDb()
	{
		return $this->firebase->getDatabase();
	}

	public function syncWithDatabase(StockSymbolCollection $collection, bool $onlyNew = false)
	{
		foreach($collection as $symbol) {
			if(!$this->getDb()->getReference('stockSymbols/'.$symbol->getCode())->getSnapshot()->exists()) {
				$this->getDb()->getReference('stockSymbols/'.$symbol->getCode())->update($symbol->jsonSerialize());
			}
			else {
				Log::info("Skipped symbol ".$symbol->getCode()." - already in database");
			}
		}
	}
}