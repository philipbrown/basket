<?php namespace PhilipBrown\Basket\Tests\Jurisdictions;

use Money\Currency;
use PhilipBrown\Basket\Jurisdictions\Belgium;

class BelgiumTest extends \PHPUnit_Framework_TestCase
{
    /** @var Jurisdiction */
    private $jurisdiction;

    /** @return void */
    public function setUp()
    {
        $this->jurisdiction = new Belgium;
    }

    /** @test */
    public function should_return_the_tax_rate()
    {
        $this->assertInstanceOf(
            'PhilipBrown\Basket\TaxRate', $this->jurisdiction->rate());
    }

    /** @test */
    public function should_return_the_currency()
    {
        $this->assertEquals(new Currency('EUR'), $this->jurisdiction->currency());
    }
}
