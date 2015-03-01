<?php namespace PhilipBrown\Basket\Tests\Formatters;

use PhilipBrown\Basket\Percent;
use PhilipBrown\Basket\Formatters\TaxRateFormatter;
use PhilipBrown\Basket\TaxRates\UnitedKingdomValueAddedTax;

class TaxRateFormatterTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_return_formatted_tax_rate()
    {
        $formatter = new TaxRateFormatter;

        $this->assertEquals('20%', $formatter->format(new UnitedKingdomValueAddedTax));
    }
}
