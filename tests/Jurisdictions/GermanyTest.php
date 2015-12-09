<?php namespace PhilipBrown\Basket\Tests\Jurisdictions;

use Money\Currency;
use PhilipBrown\Basket\Jurisdictions\Germany;

class GermanyTest extends \PHPUnit_Framework_TestCase
{
    /** @var Jurisdiction */
    private $jurisdiction;

    public function setUp()
    {
        $this->jurisdiction = new Germany;
    }

    /** @test */
    public function should_return_the_tax_rate()
    {
        $this->assertInstanceOf(
            'PhilipBrown\Basket\TaxRates\GermanyValueAddedTax', $this->jurisdiction->rate());
    }

    /** @test */
    public function should_return_the_currency()
    {
         $this->assertEquals(new Currency('EUR'), $this->jurisdiction->currency());
    }
}
