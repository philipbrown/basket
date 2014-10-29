<?php namespace PhilipBrown\Basket;

interface Formatter
{
    /**
     * Format an input to an output
     *
     * @param mixed $value
     * @return mixed
     */
    public function format($value);
}
