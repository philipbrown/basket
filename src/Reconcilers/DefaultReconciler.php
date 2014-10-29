<?php namespace PhilipBrown\Basket\Reconcilers;

use Money\Money;
use PhilipBrown\Basket\Product;
use PhilipBrown\Basket\Reconciler;

class DefaultReconciler implements Reconciler
{
    /**
     * Return the value of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function value(Product $product)
    {
        return $product->price->multiply($product->quantity);
    }

    /**
     * Return the discount of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function discount(Product $product)
    {
        $discount = $this->money($product);

        if ($product->discount) {
            $discount = $product->discount->product($product);
            $discount = $discount->multiply($product->quantity);
        }

        return $discount;
    }

    /**
     * Return the delivery charge of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function delivery(Product $product)
    {
        $delivery = $product->delivery->multiply($product->quantity);

        return $delivery;
    }

    /**
     * Return the tax of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function tax(Product $product)
    {
        $tax = $this->money($product);

        if (! $product->taxable || $product->freebie) {
            return $tax;
        }

        $value    = $this->value($product);
        $discount = $this->discount($product);

        $value = $value->subtract($discount);
        $tax   = $value->multiply($product->rate->float());

        return $tax;
    }

    /**
     * Return the subtotal of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function subtotal(Product $product)
    {
        $subtotal = $this->money($product);

        if (! $product->freebie) {
            $value    = $this->value($product);
            $discount = $this->discount($product);
            $subtotal = $subtotal->add($value)->subtract($discount);
        }

        $delivery = $this->delivery($product);
        $subtotal = $subtotal->add($delivery);

        return $subtotal;
    }

    /**
     * Return the total of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function total(Product $product)
    {
        $tax      = $this->tax($product);
        $subtotal = $this->subtotal($product);
        $total    = $subtotal->add($tax);

        return $total;
    }

    /**
     * Create an initial zero money value
     *
     * @param Product $product
     * @return Money
     */
    private function money(Product $product)
    {
        return new Money(0, $product->price->getCurrency());
    }
}
