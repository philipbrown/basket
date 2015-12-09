<?php namespace PhilipBrown\Basket\Tests\Jurisdictions;

use Money\Currency;
use PhilipBrown\Basket\Jurisdictions\Switzerland;

class SwitzerlandTest extends \PHPUnit_Framework_TestCase
{
    /** @var Jurisdiction */
    private $jurisdiction;

    public function setUp()
    {
        $this->jurisdiction = new Switzerland;
    }

    /** @test */
    public function should_return_the_tax_rate()
    {
        $this->assertInstanceOf(
            'PhilipBrown\Basket\TaxRates\SwitzerlandValueAddedTax', $this->jurisdiction->rate());
    }

    /** @test */
    public function should_return_the_currency()
    {
         $this->assertEquals(new Currency('CHF'), $this->jurisdiction->currency());
    }
}
