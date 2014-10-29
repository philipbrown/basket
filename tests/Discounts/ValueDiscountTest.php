<?php namespace PhilipBrown\Basket\Tests\Discounts;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Product;
use PhilipBrown\Basket\Discounts\ValueDiscount;
use PhilipBrown\Basket\TaxRates\UnitedKingdomValueAddedTax;

class ValueDiscountTest extends \PHPUnit_Framework_TestCase
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
        $amount   = new Money(200, new Currency('GBP'));
        $discount = new ValueDiscount($amount);
        $value    = $discount->product($this->product);

        $this->assertInstanceOf('Money\Money', $value);
        $this->assertEquals($amount, $value);
        $this->assertEquals($amount, $discount->rate());
    }
}
