<?php namespace PhilipBrown\Basket\Tests\Formatters;

use PhilipBrown\Basket\Collection;
use PhilipBrown\Basket\Formatters\CollectionFormatter;

class CollectionFormatterTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_format_collection()
    {
        $formatter = new CollectionFormatter;

        $this->assertEquals([1,2,3], $formatter->format(new Collection([1,2,3])));
    }
}
