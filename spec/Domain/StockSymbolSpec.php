<?php

namespace spec\Domain;

use Domain\StockSymbol;
use Domain\StockRateCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Money\Money;
use Domain\StockRate;

class StockSymbolSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
    	$rates = new StockRateCollection();

    	$rate1 = $this->generateRateWithSetDate(new \DateTime("Today"));
    
    	$rates->add($rate1);

    	$this->beConstructedWith("ETFSP500", $rates);
        $this->shouldHaveType(StockSymbol::class);
    }

    function it_cannot_be_created_without_rates()
    {
    	$rates = new StockRateCollection();

    	$this->beConstructedWith("ETFSP500", $rates);
    	$this->shouldThrow('Domain\Exception\StockRateCollection\EmptyException')->duringInstantiation();
    }

    function it_can_be_merged_with_matching_code_symbol()
    {
        $rates = new StockRateCollection();
        $rates->add($this->generateRateWithSetDate(new \DateTime()));

        $this->beConstructedWith("SYMBOL_1", $rates);

        $rates2 = new StockRateCollection();
        $rates2->add($this->generateRateWithSetDate(new \DateTime("Yesterday")));

        $symbol = new StockSymbol("SYMBOL_1", $rates2);

        $symbol_merged = new StockSymbol("SYMBOL_1", $rates->merge($rates2));

        $this->merge($symbol)->shouldBeLike($symbol_merged);
    }

    function it_cannot_be_merged_with_different_code_symbol()
    {
        $rates = new StockRateCollection();
        $rates->add($this->generateRateWithSetDate(new \DateTime()));

        $this->beConstructedWith("SYMBOL_1", $rates);

        $symbol = new StockSymbol("SYMBOL_2", $rates);

        $this->shouldThrow('Domain\Exception\StockSymbol\CodeNotMatchingException')->duringMerge($symbol);
    }

    function generateRateWithSetDate(\DateTime $date)
    {
		$valueOpen = Money::PLN(rand(80,100));
		$valueClose = Money::PLN(rand(80,100));
		$valueMax = Money::PLN(rand(100,120));
		$valueMin = Money::PLN(rand(60,80));

		return new StockRate($date, $valueOpen, $valueClose, $valueMin, $valueMax);
    }
}
