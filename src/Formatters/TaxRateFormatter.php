<?php namespace PhilipBrown\Basket\Formatters;

use PhilipBrown\Basket\Formatter;

class TaxRateFormatter implements Formatter
{
    /**
     * Format an input to an output
     *
     * @param mixed $value
     * @return mixed
     */
    public function format($value)
    {
        return $value->percentage().'%';
    }
}
