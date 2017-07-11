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
    function let()
    {
        $symbol_sp500_yesterday = $this->generateSymbol("ETFSP500", new \DateTime("Yesterday"));
        $symbol_sp500_today     = $this->generateSymbol("ETFSP500", new \DateTime("Today"));
        $symbol_wig20           = $this->generateSymbol("ETFWIG20", new \DateTime());

        $this->add($symbol_sp500_today);
        $this->add($symbol_sp500_yesterday);
        $this->add($symbol_wig20);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StockSymbolCollection::class);
    }

    function it_can_count_symbols()
    {	
    	$this->count()->shouldEqual(2);
    }

    function it_can_be_merged_with_another_self()
    {
        // todo
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
        $this->get("ETFSP500")->shouldBeAnInstanceOf(StockSymbol::class);
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
