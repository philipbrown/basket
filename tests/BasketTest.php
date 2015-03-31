<?php namespace PhilipBrown\Basket\Tests;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Basket;
use PhilipBrown\Basket\Jurisdictions\UnitedKingdom;
use PhilipBrown\Basket\Product;

class BasketTest extends \PHPUnit_Framework_TestCase
{
    /** @var Basket */
    private $basket;

    public function setUp()
    {
        $this->basket = new Basket(new UnitedKingdom);

        $sku  = '1';
        $name = 'The Lion King';
        $product = new Product($sku, $name, new Money(1000, new Currency('GBP')), $this->basket->rate());

        $this->basket->add($product);
    }

    /** @test */
    public function should_return_the_rate()
    {
        $this->assertInstanceOf(
            'PhilipBrown\Basket\TaxRates\UnitedKingdomValueAddedTax', $this->basket->rate());
    }

    /** @test */
    public function should_return_the_currency()
    {
        $this->assertEquals(new Currency('GBP'), $this->basket->currency());
    }

    /** @test */
    public function should_return_the_products_collection()
    {
        $this->assertInstanceOf('PhilipBrown\Basket\Collection', $this->basket->products());
    }

    /** @test */
    public function should_count_the_products()
    {
        $this->assertEquals(1, $this->basket->count());
    }

    /** @test */
    public function should_pick_a_product()
    {
        $this->assertInstanceOf('PhilipBrown\Basket\Product', $this->basket->pick('1'));
    }

    /** @test */
    public function should_add_a_product()
    {
        $product = new Product('2', 'Die Hard', new Money(1000, new Currency('GBP')), $this->basket->rate());

        $this->basket->add($product);

        $this->assertEquals(2, $this->basket->count());
    }

    /** @test */
    public function should_update_an_existing_product()
    {
        $this->basket->update('1', function ($product) {
            $product->increment();
        });

        $product = $this->basket->pick('1');

        $this->assertEquals(2, $product->quantity);
    }

    /** @test */
    public function should_remove_product_from_basket()
    {
        $this->basket->remove('1');

        $this->assertEquals(0, $this->basket->count());
    }
}
