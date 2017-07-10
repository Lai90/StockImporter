<?php

namespace Domain;

use Domain\StockRateCollection;
use Domain\Exception\StockRateCollection\EmptyException;
use Domain\Exception\StockSymbol\CodeNotMatchingException;

class StockSymbol implements \JsonSerializable
{
	protected $code;
	protected $name;
	protected $rates;

	public function __construct(string $code, StockRateCollection $rates, string $name = null)
	{
		if (!$rates->count()) {
			throw new EmptyException();
		}

		$this->code = $code;
		$this->name = $name;
		$this->rates = $rates;
	}

	public function getCode() : string
	{
		return $this->code;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getRatesCollection() : StockRateCollection
	{
		return $this->rates;
	}

	public function jsonSerialize()
	{
		return [
			"rates" => $this->getRatesCollection(),
			"name" => $this->getName()
		];
	}

	public function merge(StockSymbol $symbol) : self
	{
		if($symbol->getCode() != $this->getCode()) {
			throw new CodeNotMatchingException();
		}

		$rateCollection = $this->getRatesCollection()->merge($symbol->getRatesCollection());

		return new self($this->getCode(), $rateCollection, $this->getName());
	}
}