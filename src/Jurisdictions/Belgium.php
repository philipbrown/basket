<?php namespace PhilipBrown\Basket\Jurisdictions;

use Money\Currency;
use PhilipBrown\Basket\TaxRate;
use PhilipBrown\Basket\Jurisdiction;

class Belgium implements Jurisdiction
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
     * @return void
     */
    public function __construct()
    {
        $this->tax      = new TaxRate(0.21);
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
     * @return Currency
     */
    public function currency()
    {
        return $this->currency;
    }
}
