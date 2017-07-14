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

	public function syncWithDatabase(StockSymbolCollection $collection, bool $updateExistingOnly = false)
	{
		foreach($collection as $symbol) {
			if($updateExistingOnly && !$this->getDb()->getReference('stockSymbols/'.$symbol->getCode())->getSnapshot()->exists()) {
				Log::info("Not saving symbol. It does not exist in database.", array($symbol->getCode()));
				continue;
			}

			$this->getDb()->getReference('stockSymbols/'.$symbol->getCode())->update($symbol->jsonSerialize());
		}
	}
}