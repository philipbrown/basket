<?php namespace PhilipBrown\Basket\Jurisdictions;

use Money\Currency;
use PhilipBrown\Basket\Jurisdiction;
use PhilipBrown\Basket\TaxRates\SpainValueAddedTax;

class Spain implements Jurisdiction
{
    /**
     * @var Currency
     */
    private $currency;

    /**
     * @var TaxRate
     */
    private $tax;

    /**
     * Create a new Jurisdiction
     *
     * @return void
     */
    public function __construct()
    {
        $this->tax      = new SpainValueAddedTax;
        $this->currency = new Currency('EUR');
    }

    /**
     * Return the Tax Rate
     *
     * @return TaxRate
     */
    public function rate()
    {
        return $this->tax;
    }

    /**
     * Return the currency
     *
     * @return Money\Currency
     */
    public function currency()
    {
        return $this->currency;
    }
}
