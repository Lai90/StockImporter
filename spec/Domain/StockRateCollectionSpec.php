<?php

namespace spec\Domain;

use Domain\StockRateCollection;
use Domain\StockRate;
use Money\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StockRateCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StockRateCollection::class);
    }

    function it_can_add_rates()
    {
    	$rate = $this->generateRateWithSetDate(new \DateTime());

    	$this->add($rate);
    	$this->getCurrentRate()->shouldBeAnInstanceOf(StockRate::class);
    }

    function it_can_sort_rates()
    {
    	$rate1 = $this->generateRateWithSetDate(new \DateTime("Today"));
    	$rate2 = $this->generateRateWithSetDate(new \DateTime("Yesterday"));
    	$rate3 = $this->generateRateWithSetDate(new \DateTime("3 days ago"));
    	$rate4 = $this->generateRateWithSetDate(new \DateTime("5 days ago"));

    	$this->add($rate4);
    	$this->add($rate2);
    	$this->add($rate3);
    	$this->add($rate1);

    	$this->getCurrentRate()->shouldEqual($rate1);
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
