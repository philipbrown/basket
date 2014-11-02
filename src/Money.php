<?php namespace PhilipBrown\Basket;

interface Money
{
    /**
     * Return the object as an instance of Money
     *
     * @return Money
     */
    public function toMoney();
}
