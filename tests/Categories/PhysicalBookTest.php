<?php namespace PhilipBrown\Basket\Tests\Categories;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Product;
use PhilipBrown\Basket\Categories\PhysicalBook;
use PhilipBrown\Basket\TaxRates\UnitedKingdomValueAddedTax;

class PhysicalBookTest extends \PHPUnit_Framework_TestCase
{
    /** @var Product */
    private $product;

    /** @var Category */
    private $category;

    public function setUp()
    {
        $sku   = '1';
        $name  = 'Fooled By Randomness';
        $rate  = new UnitedKingdomValueAddedTax;
        $price = new Money(1000, new Currency('GBP'));
        $this->product = new Product($sku, $name, $price, $rate);

        $this->category = new PhysicalBook;
    }

    /** @test */
    public function should_categorise_as_physicalbook()
    {
        $this->category->categorise($this->product);

        $this->assertFalse($this->product->taxable);
    }

    /** @test */
    public function should_return_the_name_of_the_category()
    {
        $this->assertEquals('Physical Book', $this->category->name());
    }
}
