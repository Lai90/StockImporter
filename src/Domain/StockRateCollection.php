<?php

namespace Domain;

use Domain\StockRate;
use Domain\AbstractCollection;

class StockRateCollection extends AbstractCollection
{
	public function add(StockRate $rate)
	{
		$collection = $this->getCollection();
		$collection[$rate->getDate()->format("Y-m-d")] = $rate;
		$this->setCollection($collection);
	}

	public function getCurrentRate() : StockRate
	{
		return $this->last();
	}

	public function getByDate(\DateTime $date)
	{
		return $this->getCollection()[$date->format("Y-m-d")];
	}

	public function merge(StockRateCollection $collection) : self
	{
		$newCollection = new self();
		
		foreach($this->getCollection() as $rate) {
			$newCollection->add($rate);
		}
		
		foreach($collection->getCollection() as $rate) {
			$newCollection->add($rate);
		}

		return $newCollection;
	}
}