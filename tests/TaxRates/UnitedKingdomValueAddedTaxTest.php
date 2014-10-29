<?php namespace PhilipBrown\Basket\Tests\TaxRates;

use PhilipBrown\Basket\TaxRates\UnitedKingdomValueAddedTax;

class UnitedKingdomValueAddedTaxTest extends \PHPUnit_Framework_TestCase
{
    /** @var TaxRate */
    private $rate;

    public function setUp()
    {
        $this->rate = new UnitedKingdomValueAddedTax;
    }

    /** @test */
    public function should_return_rate_as_float()
    {
        $this->assertEquals(0.20, $this->rate->float());
    }

    /** @test */
    public function should_return_rate_as_percentage()
    {
        $this->assertEquals(20, $this->rate->percentage());
    }
}
