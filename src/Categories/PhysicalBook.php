<?php namespace PhilipBrown\Basket\Categories;

use PhilipBrown\Basket\Product;
use PhilipBrown\Basket\Category;

class PhysicalBook implements Category
{
    /**
     * Categorise a Product
     *
     * @param Product $product
     * @return void
     */
    public function categorise(Product $product)
    {
        $product->taxable(false);
    }

    /**
     * Return the name of the Category
     *
     * @return string
     */
    public function name()
    {
        return 'Physical Book';
    }
}
