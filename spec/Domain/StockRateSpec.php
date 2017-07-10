<?php

namespace spec\Domain;

use Domain\StockRate;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StockRateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
		$date = new \DateTime();
		$valueOpen = Money::PLN(400);
		$valueClose = Money::PLN(500);
		$valueMax = Money::PLN(550);
		$valueMin = Money::PLN(350);

    	$this->beConstructedWith($date, $valueOpen, $valueClose, $valueMax, $valueMin);
        $this->shouldHaveType(StockRate::class);
    }
}
