<?php namespace PhilipBrown\Basket\Formatters;

use PhilipBrown\Basket\Formatter;
use PhilipBrown\Basket\Percentage;

class PercentFormatter implements Formatter
{
    /**
     * Format an input to an output
     *
     * @param mixed $value
     * @return mixed
     */
    public function format($value)
    {
        if ($value instanceOf Percentage) {
            $value = $value->toPercent();
        }

        return $value->int().'%';
    }
}
