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
    
    /**
     * Return the name of the Category
     *
     * @return string
     */
    public function name();
}
