<?php

namespace Utility;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Domain\StockSymbolCollection;

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

	public function syncWithDatabase(StockSymbolCollection $collection)
	{
		foreach($collection as $symbol) {
			$this->getDb()->getReference('stockSymbols/'.$symbol->getCode())->update($symbol->jsonSerialize());
		}
	}
}