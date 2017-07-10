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
		
		if(array_key_exists($symbol->getCode(), $this->getCollection()))
		{
			$rates = clone($symbol->getRatesCollection());
			foreach($this->get($symbol->getCode())->getRatesCollection() as $rate) {
				$rates->add($rate);
			}

			$newSymbol = new StockSymbol($symbol->getCode(), $rates, $symbol->getName());

			$collection[$symbol->getCode()] = $newSymbol;
		}
		else {
			$collection[$symbol->getCode()] = $symbol;
		}

		$this->setCollection($collection);
	}

	public function get(string $symbol)
	{
		if(array_key_exists($symbol, $this->getCollection()) === false) {
			throw new KeyNotExistException();
		}

		return $this->getCollection()[$symbol];
	}
}