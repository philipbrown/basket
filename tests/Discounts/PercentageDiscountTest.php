<?php namespace PhilipBrown\Basket\Tests\Discounts;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Percent;
use PhilipBrown\Basket\Product;
use PhilipBrown\Basket\Discounts\PercentageDiscount;
use PhilipBrown\Basket\TaxRates\UnitedKingdomValueAddedTax;

class PercentageDiscountTest extends \PHPUnit_Framework_TestCase
{
    /** @var Product */
    private $product;

    public function setUp()
    {
        $sku   = '1';
        $name  = 'iPhone 6';
        $rate  = new UnitedKingdomValueAddedTax;
        $price = new Money(60000, new Currency('GBP'));
        $this->product = new Product($sku, $name, $price, $rate);
    }

    /** @test */
    public function should_get_value_discount()
    {
        $discount = new PercentageDiscount(20);
        $value    = $discount->product($this->product);

        $this->assertInstanceOf('Money\Money', $value);
        $this->assertEquals(new Money(12000, new Currency('GBP')), $value);
        $this->assertEquals(new Percent(20), $discount->rate());
    }
}
