<?php namespace PhilipBrown\Basket\Tests\Formatters;

use PhilipBrown\Basket\Percent;
use PhilipBrown\Basket\Formatters\PercentFormatter;

class PercentFormatterTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_return_formatted_percent()
    {
        $formatter = new PercentFormatter;

        $this->assertEquals('20%', $formatter->format(new Percent(20)));
    }
}
