<?php namespace PhilipBrown\Basket\Formatters;

use PhilipBrown\Basket\Formatter;

class CategoryFormatter implements Formatter
{
    /**
     * Format an input to an output
     *
     * @param mixed $value
     * @return mixed
     */
    public function format($value)
    {
        $class = array_pop(explode('\\', get_class($value)));
        $regex = '/(?<!^)((?<![[:upper:]])[[:upper:]]|[[:upper:]](?![[:upper:]]))/';

        return preg_replace($regex, ' $1', $class);
    }
}

