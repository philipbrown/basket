<?php namespace PhilipBrown\Basket;

class TaxRate
{
    /**
     * @var float
     */
    private $rate;

    /**
     * @param float $rate
     * @return void
     */
    public function __construct($rate)
    {
        $this->rate = $rate;
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
