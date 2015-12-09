<?php namespace PhilipBrown\Basket\Tests\TaxRates;

use PhilipBrown\Basket\TaxRates\GermanyValueAddedTax;

class GermanyValueAddedTaxTest extends \PHPUnit_Framework_TestCase
{
    /** @var TaxRate */
    private $rate;

    public function setUp()
    {
        $this->rate = new GermanyValueAddedTax;
    }

    /** @test */
    public function should_return_rate_as_float()
    {
        $this->assertEquals(0.19, $this->rate->float());
    }

    /** @test */
    public function should_return_rate_as_percentage()
    {
        $this->assertEquals(19, $this->rate->percentage());
    }
}