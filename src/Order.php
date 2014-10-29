<?php namespace PhilipBrown\Basket;

class Order
{
    /**
     * @var array
     */
    private $totals;

    /**
     * @var array
     */
    private $products;

    /**
     * Create a new Order
     *
     * @param array $totals
     * @param array $products
     * @return void
     */
    public function __construct(array $totals, array $products)
    {
        $this->totals   = $totals;
        $this->products = $products;
    }

    /**
     * Return the totals
     *
     * @return array
     */
    public function totals()
    {
        return $this->totals;
    }

    /**
     * Return the products
     *
     * @return array
     */
    public function products()
    {
        return $this->products;
    }

    /**
     * Return the Order as an array
     *
     * @return array
     */
    public function toArray()
    {
        return array_merge($this->totals, ['products' => $this->products]);
    }
}
