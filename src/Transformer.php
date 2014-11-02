<?php namespace PhilipBrown\Basket;

interface Transformer
{
    /**
     * Transform the Order
     *
     * @param Order $order
     * @return mixed
     */
    public function transform(Order $order);
}
