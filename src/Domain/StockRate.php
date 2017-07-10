<?php

namespace Domain;

use Domain\StockSymbol;
use Money\Money;

class StockRate implements \JsonSerializable
{
	protected $date;
	protected $valueOpen;
	protected $valueClose;
	protected $valueMax;
	protected $valueMin;

	public function __construct(
		\DateTime $date, 
		Money $valueOpen, 
		Money $valueClose,
		Money $valueMax,
		Money $valueMin
	)
	{
		$this->date = $date;
		$this->valueOpen = $valueOpen;
		$this->valueClose = $valueClose;
		$this->valueMax = $valueMax;
		$this->valueMin = $valueMin;
	}

	public function getDate() : \DateTime
	{
		return $this->date;
	}

	public function getValueOpen() : Money
	{
		return $this->valueOpen;
	}

	public function getValueClose() : Money
	{
		return $this->valueClose;
	}

	public function getValueMax() : Money
	{
		return $this->valueMax;
	}

	public function getValueMin() : Money
	{
		return $this->valueMin;
	}

	public function jsonSerialize()
	{
		return [
			"date" 		 => $this->getDate()->format("Y-m-d"),
			"valueOpen"  => $this->getValueOpen(),
			"valueClose" => $this->getValueClose(),
			"valueMax" 	 => $this->getValueMax(),
			"valueMin" 	 => $this->getValueMin()
		];
	}
}