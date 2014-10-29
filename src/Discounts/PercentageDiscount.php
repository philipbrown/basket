<?php namespace PhilipBrown\Basket\Discounts;

use PhilipBrown\Basket\Product;
use PhilipBrown\Basket\Percent;
use PhilipBrown\Basket\Discount;

class PercentageDiscount implements Discount
{
    /**
     * @var int
     */
    private $rate;

    /**
     * Create a new Discount
     *
     * @param int $rate
     * @return void
     */
    public function __construct($rate)
    {
        $this->rate = $rate;
    }

    /**
     * Calculate the discount on a Product
     *
     * @param Product
     * @return Money\Money
     */
    public function product(Product $product)
    {
        return $product->price->multiply($this->rate / 100);
    }

    /**
     * Return the rate of the Discount
     *
     * @return mixed
     */
    public function rate()
    {
        return new Percent($this->rate);
    }
}
