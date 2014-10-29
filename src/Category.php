<?php namespace PhilipBrown\Basket;

interface Category
{
    /**
     * Categorise a Product
     *
     * @param Product $product
     * @return void
     */
    public function categorise(Product $product);
}
