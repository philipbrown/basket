<?php namespace PhilipBrown\Basket;

use Closure;

class Basket
{
    /**
     * @var TaxRate
     */
    private $rate;

    /**
     * @var Money\Currency
     */
    private $currency;

    /**
     * @var Collection
     */
    private $products;

    /**
     * Create a new Basket
     *
     * @param Jurisdiction $jurisdiction
     * @return void
     */
    public function __construct(Jurisdiction $jurisdiction)
    {
        $this->rate       = $jurisdiction->rate();
        $this->currency   = $jurisdiction->currency();
        $this->products   = new Collection;
    }

    /**
     * Get the TaxRate of the Basket
     *
     * @return TaxRate
     */
    public function rate()
    {
        return $this->rate;
    }

    /**
     * Get the Currency of the Basket
     *
     * @return Currency
     */
    public function currency()
    {
        return $this->currency;
    }

    /**
     * Get the products from the basket
     *
     * @return Collection
     */
    public function products()
    {
        return $this->products;
    }

    /**
     * Count the items in the basket
     *
     * @return int
     */
    public function count()
    {
        return $this->products->count();
    }

    /**
     * Pick a product from the basket
     *
     * @param string $sku
     * @return Product
     */
    public function pick($sku)
    {
        return $this->products->get($sku);
    }

    /**
     * Add a product to the basket
     *
     * @param Product $product
     * @return void
     */
    public function add(Product $product)
    {
        $this->products->add($product->sku, $product);
    }

    /**
     * Update a product that is already in the basket
     *
     * @param string $sku
     * @param Closure $action
     * @return void
     */
    public function update($sku, Closure $action)
    {
        $product = $this->pick($sku);

        $product->action($action);
    }

    /**
     * Remove a product from the basket
     *
     * @param string $sku
     * @return void
     */
    public function remove($sku)
    {
        $product = $this->pick($sku);

        $this->products->remove($sku);
    }
}
