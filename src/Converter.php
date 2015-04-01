<?php namespace PhilipBrown\Basket;

use PhilipBrown\Basket\Formatters\MoneyFormatter;
use PhilipBrown\Basket\Formatters\PercentFormatter;
use PhilipBrown\Basket\Formatters\TaxRateFormatter;
use PhilipBrown\Basket\Formatters\CategoryFormatter;
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
            'Category'           => new CategoryFormatter,
            'PercentageDiscount' => new PercentFormatter,
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

        if ($value instanceof Collection) {
            return $value->map(function ($item) {
                return $this->formatter($item)->format($item);
            })->toArray();
        }

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
        $interfaces = class_implements($object);

        foreach ($interfaces as $interface) {
            $class = $this->getClassName($interface);

            if (isset($this->formatters[$class])) {
                return $this->formatters[$class];
            }
        }

        $class = $this->getClassName(get_class($object));

        return $this->formatters[$class];
    }

    /**
     * Get the class name from the full namespace
     *
     * @param string $namespace
     * @return string
     */
    private function getClassName($namespace)
    {
        $namespace = explode('\\', $namespace);

        return array_pop($namespace);
    }
}
