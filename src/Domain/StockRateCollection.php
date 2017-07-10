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
		$this->sortRatesByDate();
	}

	public function getCurrentRate() : StockRate
	{
		return $this->last();
	}

	public function getByDate(\DateTime $date)
	{
		return $this->getCollection()[$date->format("Y-m-d")];
	}

	protected function sortRatesByDate()
	{
		$array = $this->getCollection();
		usort($array, array($this, "compareRatesByDate"));
		$this->setCollection($array);
	}

	protected function compareRatesByDate(StockRate $firstRate, StockRate $secondRate) : bool
	{
		return ($firstRate->getDate() > $secondRate->getDate());
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
		
		$this->sortRatesByDate();

		return $newCollection;
	}
}