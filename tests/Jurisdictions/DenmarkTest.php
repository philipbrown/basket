<?php namespace PhilipBrown\Basket\Tests\Jurisdictions;

use Money\Currency;
use PhilipBrown\Basket\Jurisdictions\Denmark;

class DenmarkTest extends \PHPUnit_Framework_TestCase
{
    /** @var Jurisdiction */
    private $jurisdiction;

    public function setUp()
    {
        $this->jurisdiction = new Denmark;
    }

    /** @test */
    public function should_return_the_tax_rate()
    {
        $this->assertInstanceOf(
            'PhilipBrown\Basket\TaxRates\DenmarkValueAddedTax', $this->jurisdiction->rate());
    }

    /** @test */
    public function should_return_the_currency()
    {
         $this->assertEquals(new Currency('DKK'), $this->jurisdiction->currency());
    }
}