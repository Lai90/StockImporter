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

    function it_can_add_and_count_symbols()
    {
    	$symbol = $this->generateSymbol("ETFSP500", new \DateTime("Yesterday"));
        $symbol2 = $this->generateSymbol("ETFSP500", new \DateTime("Today"));
        $symbol3 = $this->generateSymbol("ETFWIG20", new \DateTime());

    	$this->add($symbol);
        $this->add($symbol2);
        $this->add($symbol3);
    	$this->count()->shouldEqual(2);
    }

    function it_can_get_symbols_by_code()
    {
        $symbol = $this->generateSymbol("ETFSP500", new \DateTime("Yesterday"));
        $symbol2 = $this->generateSymbol("ETFSP500", new \DateTime("Today"));
        $symbol3 = $this->generateSymbol("ETFWIG20", new \DateTime());

        $this->add($symbol);
        $this->add($symbol2);
        $this->add($symbol3);

        $symbolMerged = $symbol->merge($symbol2);

        $this->get("ETFSP500")->shouldBeLike($symbolMerged);
        $this->get("ETFSP500")->shouldNotBeLike($symbol);
        $this->get("ETFSP500")->shouldNotBeLike($symbol2);
        $this->get("ETFWIG20")->shouldBeLike($symbol3);
    }

    function generateSymbol($code, $date)
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
