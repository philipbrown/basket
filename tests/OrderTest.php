<?php namespace PhilipBrown\Basket\Tests;

use PhilipBrown\Basket\Order;

class OrderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Order */
    private $order;

    public function setUp()
    {
        $this->order = new Order([], []);
    }

    /** @test */
    public function should_have_gettable_totals_and_products_arrays()
    {
        $this->assertTrue(is_array($this->order->totals()));
        $this->assertTrue(is_array($this->order->products()));
    }

    /** @test */
    public function should_return_order_as_an_array()
    {
        $this->assertTrue(is_array($this->order->toArray()));
    }
}
