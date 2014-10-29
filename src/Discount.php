<?php namespace PhilipBrown\Basket;

interface Discount
{
    /**
     * Calculate the discount on a Product
     *
     * @param Product
     * @return Money\Money
     */
    public function product(Product $product);

    /**
     * Return the rate of the Discount
     *
     * @return mixed
     */
    public function rate();
}
