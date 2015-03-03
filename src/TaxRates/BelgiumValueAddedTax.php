<?php namespace PhilipBrown\Basket\TaxRates;

use PhilipBrown\Basket\TaxRate;

class BelgiumValueAddedTax implements TaxRate
{
    /**
     * @var float
     */
    private $rate;

    /**
     * Create a new Tax Rate
     */
    public function __construct()
    {
        $this->rate = 0.21;
    }

    /**
     * Return the Tax Rate as a float
     * @return float
     */
    public function float()
    {
        return $this->rate;
    }

    /**
     * Return the Tax Rate as a percentage
     * @return int
     */
    public function percentage()
    {
        return intval($this->rate * 100);
    }
}
