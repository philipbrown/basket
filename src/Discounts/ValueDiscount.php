<?php namespace PhilipBrown\Basket\Discounts;

use Money\Money;
use PhilipBrown\Basket\Product;
use PhilipBrown\Basket\Discount;

class ValueDiscount implements Discount
{
    /**
     * @var Money
     */
    private $rate;

    /**
     * Create a new Discount
     *
     * @param Money $rate
     * @return void
     */
    public function __construct(Money $rate)
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
        return $this->rate;
    }

    /**
     * Return the rate of the Discount
     *
     * @return mixed
     */
    public function rate()
    {
        return $this->rate;
    }
}
