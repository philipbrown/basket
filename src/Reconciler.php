<?php namespace PhilipBrown\Basket;

interface Reconciler
{
    /**
     * Return the value of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function value(Product $product);

    /**
     * Return the discount of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function discount(Product $product);

    /**
     * Return the delivery charge of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function delivery(Product $product);

    /**
     * Return the tax of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function tax(Product $product);

    /**
     * Return the subtotal of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function subtotal(Product $product);

    /**
     * Return the total of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function total(Product $product);
}
