<?php namespace PhilipBrown\Basket\MetaData;

use Money\Money;
use PhilipBrown\Basket\Basket;
use PhilipBrown\Basket\MetaData;
use PhilipBrown\Basket\Reconciler;

class ValueMetaData implements MetaData
{
    /**
     * @var Reconciler
     */
    private $reconciler;

    /**
     * Create a new Value MetaData
     *
     * @param Reconciler $reconciler
     * @return void
     */
    public function __construct(Reconciler $reconciler)
    {
        $this->reconciler = $reconciler;
    }

    /**
     * Generate the Meta Data
     *
     * @param Basket $basket
     * @return mixed
     */
    public function generate(Basket $basket)
    {
        $total = new Money(0, $basket->currency());

        foreach ($basket->products() as $product) {
            $total = $total->add($this->reconciler->value($product));
        }

        return $total;
    }

    /**
     * Return the name of the MetaData
     *
     * @return string
     */
    public function name()
    {
        return 'value';
    }
}
