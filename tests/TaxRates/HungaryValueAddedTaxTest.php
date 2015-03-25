<?php namespace PhilipBrown\Basket\Tests\TaxRates;

use PhilipBrown\Basket\TaxRate;
use PhilipBrown\Basket\TaxRates\HungaryValueAddedTax;

class HungaryValueAddedTaxTest extends \PHPUnit_Framework_TestCase
{
    /** @var TaxRate */
    private $rate;

    public function setUp()
    {
        $this->rate = new HungaryValueAddedTax();
    }

    /** @test */
    public function should_return_rate_as_float()
    {
        $this->assertEquals(0.27, $this->rate->float());
    }

    /** @test */
    public function should_return_rate_as_percentage()
    {
        $this->assertEquals(27, $this->rate->percentage());
    }
}
