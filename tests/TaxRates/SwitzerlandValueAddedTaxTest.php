<?php namespace PhilipBrown\Basket\Tests\TaxRates;

use PhilipBrown\Basket\TaxRates\SwitzerlandValueAddedTax;

class SwitzerlandValueAddedTaxTest extends \PHPUnit_Framework_TestCase
{
    /** @var TaxRate */
    private $rate;

    public function setUp()
    {
        $this->rate = new SwitzerlandValueAddedTax;
    }

    /** @test */
    public function should_return_rate_as_float()
    {
        $this->assertEquals(0.08, $this->rate->float());
    }

    /** @test */
    public function should_return_rate_as_percentage()
    {
        $this->assertEquals(8, $this->rate->percentage());
    }
}