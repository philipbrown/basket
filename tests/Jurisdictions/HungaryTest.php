<?php namespace PhilipBrown\Basket\Tests\Jurisdictions;

use Money\Currency;
use PhilipBrown\Basket\Jurisdiction;
use PhilipBrown\Basket\Jurisdictions\Hungary;

class HungaryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Jurisdiction */
    private $jurisdiction;

    public function setUp()
    {
        $this->jurisdiction = new Hungary;
    }

    /** @test */
    public function should_return_the_tax_rate()
    {
        $this->assertInstanceOf(
            'PhilipBrown\Basket\TaxRates\HungaryValueAddedTax', $this->jurisdiction->rate());
    }

    /** @test */
    public function should_return_the_currency()
    {
        $this->assertEquals(new Currency('HUF'), $this->jurisdiction->currency());
    }
}
