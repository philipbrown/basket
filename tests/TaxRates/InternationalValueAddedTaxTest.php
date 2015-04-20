<?php namespace PhilipBrown\Basket\Tests\TaxRates;

use PhilipBrown\Basket\TaxRate;
use PhilipBrown\Basket\TaxRates\InternationalValueAddedTax;

class InternationalValueAddedTaxTest extends \PHPUnit_Framework_TestCase
{
    /** @var TaxRate */
    private $rate;

    public function setUp()
    {
        $this->rate = new InternationalValueAddedTax(27);
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
