<?php

namespace spec\Domain;

use Domain\StockSymbolCollection;
use Domain\StockSymbol;
use Domain\StockRateCollection;
use Domain\StockRate;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StockSymbolCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StockSymbolCollection::class);
    }

    function it_can_count_symbols()
    {	
        $symbol_1_yesterday = $this->generateSymbol("SYMBOL_1", new \DateTime("Yesterday"));
        $symbol_1_today     = $this->generateSymbol("SYMBOL_1", new \DateTime("Today"));
        $symbol_2           = $this->generateSymbol("SYMBOL_2", new \DateTime());

        $this->add($symbol_1_today);
        $this->add($symbol_1_yesterday);
        $this->add($symbol_2);

    	$this->count()->shouldEqual(2);
    }

    function it_can_be_merged_with_another_self()
    {
        $symbol_1 = $this->generateSymbol("SYMBOL_1", new \DateTime("Yesterday"));
        $symbol_2 = $this->generateSymbol("SYMBOL_2", new \DateTime("Yesterday"));

        $collection1 = new StockSymbolCollection();
        $collection1->add($symbol_1);
        $collection2 = new StockSymbolCollection();
        $collection2->add($symbol_1);
        $collection2->add($symbol_2);

        $this->add($symbol_2);

        $mergeResult = $this->merge($collection1);
        
        $mergeResult->shouldBeAnInstanceOf(StockSymbolCollection::class);
        $mergeResult->shouldBeLike($collection2);
        $mergeResult->shouldNotBeLike($collection1);
    }

    function it_can_add_symbols_without_duplicating()
    {
        $symbol_1_yesterday = $this->generateSymbol("SYMBOL_1", new \DateTime("Yesterday"));
        $symbol_1_today     = $this->generateSymbol("SYMBOL_1", new \DateTime("Today"));
        $symbol_2           = $this->generateSymbol("SYMBOL_2", new \DateTime());

        $this->add($symbol_1_today);
        $this->add($symbol_1_yesterday);
        $this->add($symbol_2);

        $symbol_1 = $symbol_1_today->merge($symbol_1_yesterday);

        $this->get("SYMBOL_1")->shouldBeLike($symbol_1);
        $this->get("SYMBOL_1")->shouldNotBeLike($symbol_1_today);
        $this->get("SYMBOL_1")->shouldNotBeLike($symbol_1_yesterday);

        $this->get("SYMBOL_2")->shouldBeLike($symbol_2);
    }

    function it_can_get_symbol_by_code()
    {
        $symbol = $this->generateSymbol("SYMBOL_1", new \DateTime("Yesterday"));
        $this->add($symbol);

        $this->get("SYMBOL_1")->shouldBeAnInstanceOf(StockSymbol::class);
    }

    protected function generateSymbol($code, $date)
    {
		$valueOpen = Money::PLN(rand(80,100));
		$valueClose = Money::PLN(rand(80,100));
		$valueMax = Money::PLN(rand(100,120));
		$valueMin = Money::PLN(rand(60,80));

		$stockRate = new StockRate($date, $valueOpen, $valueClose, $valueMin, $valueMax);

        $stockRateCollection = new StockRateCollection();

        $stockRateCollection->add($stockRate);

        $symbol = new StockSymbol($code, $stockRateCollection);

        return $symbol;
    }
}
