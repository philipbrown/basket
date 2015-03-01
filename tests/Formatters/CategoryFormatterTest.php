<?php namespace PhilipBrown\Basket\Tests\Formatters;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Product;
use PhilipBrown\Basket\Categories\PhysicalBook;
use PhilipBrown\Basket\Formatters\CategoryFormatter;
use PhilipBrown\Basket\TaxRates\UnitedKingdomValueAddedTax;

class CategoryFormatterTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function should_format_category()
    {
        $sku     = '0';
        $name    = 'Back to the Future Blu-ray';
        $rate    = new UnitedKingdomValueAddedTax;
        $price   = new Money(1000, new Currency('GBP'));
        $product = new Product($sku, $name, $price, $rate);

        $formatter = new CategoryFormatter;

        $this->assertEquals('Physical Book', $formatter->format(new PhysicalBook($product)));
    }
}
