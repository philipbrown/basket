<?php namespace PhilipBrown\Basket\Tests\TaxRates;

use PhilipBrown\Basket\TaxRates\DenmarkValueAddedTax;

class DenmarkValueAddedTaxTest extends \PHPUnit_Framework_TestCase
{
    /** @var TaxRate */
    private $rate;

    public function setUp()
    {
        $this->rate = new DenmarkValueAddedTax;
    }

    /** @test */
    public function should_return_rate_as_float()
    {
        $this->assertEquals(0.25, $this->rate->float());
    }

    /** @test */
    public function should_return_rate_as_percentage()
    {
        $this->assertEquals(25, $this->rate->percentage());
    }
}