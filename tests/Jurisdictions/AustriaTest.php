<?php namespace PhilipBrown\Basket\Tests\Jurisdictions;

use Money\Currency;
use PhilipBrown\Basket\Jurisdictions\Austria;

class AustriaTest extends \PHPUnit_Framework_TestCase
{
    /** @var Jurisdiction */
    private $jurisdiction;

    public function setUp()
    {
        $this->jurisdiction = new Austria;
    }

    /** @test */
    public function should_return_the_tax_rate()
    {
        $this->assertInstanceOf(
            'PhilipBrown\Basket\TaxRates\AustriaValueAddedTax', $this->jurisdiction->rate());
    }

    /** @test */
    public function should_return_the_currency()
    {
         $this->assertEquals(new Currency('EUR'), $this->jurisdiction->currency());
    }
}