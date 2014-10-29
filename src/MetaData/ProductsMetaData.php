<?php namespace PhilipBrown\Basket\MetaData;

use PhilipBrown\Basket\Basket;
use PhilipBrown\Basket\MetaData;

class ProductsMetaData implements MetaData
{
    /**
     * Generate the Meta Data
     *
     * @param Basket $basket
     * @return mixed
     */
    public function generate(Basket $basket)
    {
        $total = 0;

        foreach ($basket->products() as $product) {
            $total = $total + $product->quantity;
        }

        return $total;
    }

    /**
     * Return the name of the Meta Data
     *
     * @return string
     */
    public function name()
    {
        return 'products_count';
    }
}
