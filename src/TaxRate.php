<?php namespace PhilipBrown\Basket;

interface TaxRate
{
    /**
     * Return the Tax Rate as a float
     *
     * @return float
     */
    public function float();

    /**
     * Return the Tax Rate as a percentage
     *
     * @return int
     */
    public function percentage();
}
