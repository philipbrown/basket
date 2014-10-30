<?php namespace PhilipBrown\Basket;

class Order
{
    /**
     * @var array
     */
    private $meta;

    /**
     * @var array
     */
    private $products;

    /**
     * Create a new Order
     *
     * @param array $meta
     * @param array $products
     * @return void
     */
    public function __construct(array $meta, array $products)
    {
        $this->meta   = $meta;
        $this->products = $products;
    }

    /**
     * Return the meta
     *
     * @return array
     */
    public function meta()
    {
        return $this->meta;
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
        return array_merge($this->meta, ['products' => $this->products]);
    }
}
