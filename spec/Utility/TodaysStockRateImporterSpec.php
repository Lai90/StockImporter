<?php

namespace spec\Utility;

use Utility\TodaysStockRateImporter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Domain\StockSymbolCollection;

class TodaysStockRateImporterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TodaysStockRateImporter::class);
    }

    function it_returns_stock_symbol_collection()
    {
    	$this->getCollection()->shouldHaveType(StockSymbolCollection::class);
    }
}
