<?php namespace PhilipBrown\Basket;

use PhilipBrown\Basket\Formatters\MoneyFormatter;
use PhilipBrown\Basket\Formatters\PercentFormatter;
use PhilipBrown\Basket\Formatters\TaxRateFormatter;
use PhilipBrown\Basket\Formatters\CollectionFormatter;

class Converter
{
    /**
     * @var array
     */
    private $formatters;

    /**
     * Create a new Converter
     *
     * @param array $formatters
     * @return void
     */
    public function __construct(array $formatters = [])
    {
        $bootstrap = [
            'Collection'         => new CollectionFormatter,
            'Percent'            => new PercentFormatter,
            'TaxRate'            => new TaxRateFormatter,
            'Money'              => new MoneyFormatter,
            'ValueDiscount'      => new MoneyFormatter,
            'PercentageDiscount' => new PercentFormatter
        ];

        $this->formatters = array_merge($bootstrap, $formatters);
    }

    /**
     * Convert a value using to the appropriate format
     *
     * @param mixed $value
     * @return mixed
     */
    public function convert($value)
    {
        if (! is_object($value)) return $value;

        return $this->formatter($value)->format($value);
    }

    /**
     * Get the Formatter for an object
     *
     * @param mixed $object
     * @return Formatter
     */
    public function formatter($object)
    {
        if ($object instanceOf TaxRate) {
            return $this->formatters['TaxRate'];
        }

        $class = array_pop(explode('\\', get_class($object)));

        return $this->formatters[$class];
    }
}
