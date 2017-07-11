<?php

namespace Domain;

use Domain\StockSymbol;
use Domain\Exception\StockSymbolCollection\KeyNotExistException;
use Domain\AbstractCollection;

class StockSymbolCollection extends AbstractCollection
{
	public function add(StockSymbol $symbol)
	{
		$collection = $this->getCollection();
		
		if($this->get($symbol->getCode())) {
			$collection[$symbol->getCode()] = $this->get($symbol->getCode())->merge($symbol);
		}
		else {
			$collection[$symbol->getCode()] = $symbol;
		}

		$this->setCollection($collection);
	}

	public function merge(StockSymbolCollection $collection) : self
	{
		$newCollection = new self();
		
		foreach($this->getCollection() as $symbol) {
			$newCollection->add($symbol);
		}
		
		foreach($collection->getCollection() as $symbol) {
			$newCollection->add($symbol);
		}

		return $newCollection;
	}

	public function get(string $symbol)
	{
		if(array_key_exists($symbol, $this->getCollection()) === false) {
			return false;
		}

		return $this->getCollection()[$symbol];
	}
}