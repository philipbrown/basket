<?php namespace PhilipBrown\Basket;

interface MetaData
{
    /**
     * Generate the Meta Data
     *
     * @param Basket $basket
     * @return mixed
     */
    public function generate(Basket $basket);

    /**
     * Return the name of the Meta Data
     *
     * @return string
     */
    public function name();
}
