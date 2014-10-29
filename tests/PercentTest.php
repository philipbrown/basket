<?php namespace PhilipBrown\Basket\Tests;

use PhilipBrown\Basket\Percent;

class PercentTest extends \PHPUnit_Framework_TestCase
{
    /** @var Percent */
    private $percent;

    public function setUp()
    {
        $this->percent = new Percent(20);
    }

    /** @test */
    public function should_return_percent_as_int()
    {
        $this->assertEquals(20, $this->percent->int());
    }
}
