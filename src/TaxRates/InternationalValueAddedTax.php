<?php namespace PhilipBrown\Basket\TaxRates;

use PhilipBrown\Basket\TaxRate;

class InternationalValueAddedTax implements TaxRate
{
    /**
     * @var int
     */
    private $percentage;

    /**
     * Create a new Tax Rate
     *
     * @param int $percentage
     */
    public function __construct($percentage)
    {
        $this->percentage = $percentage;
    }

    /**
     * Return the Tax Rate as a float
     * @return float
     */
    public function float()
    {
        return round($this->percentage / 100, 2);
    }

    /**
     * Return the Tax Rate as a percentage
     * @return int
     */
    public function percentage()
    {
        return intval($this->percentage);
    }
}
