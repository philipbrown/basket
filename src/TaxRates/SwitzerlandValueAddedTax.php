<?php namespace PhilipBrown\Basket\TaxRates;

use PhilipBrown\Basket\TaxRate;

class SwitzerlandValueAddedTax implements TaxRate
{
    /**
     * @var float
     */
    private $rate;

    /**
     * Create a new Tax Rate
     *
     * @return void
     */
    public function __construct()
    {
        $this->rate = 0.08;
    }

    /**
     * Return the Tax Rate as a float
     *
     * @return float
     */
    public function float()
    {
        return $this->rate;
    }

    /**
     * Return the Tax Rate as a percentage
     *
     * @return int
     */
    public function percentage()
    {
        return intval($this->rate * 100);
    }
}