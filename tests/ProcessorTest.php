<?php namespace PhilipBrown\Basket\Processor;

use PhilipBrown\Basket\Processor;
use PhilipBrown\Basket\Fixtures\BasketFixture;
use PhilipBrown\Basket\MetaData\TotalMetaData;
use PhilipBrown\Basket\MetaData\ProductsMetaData;
use PhilipBrown\Basket\Reconcilers\DefaultReconciler;

class ProcessorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Processor */
    private $processor;

    /** @var BasketFixture */
    private $fixtures;

    public function setUp()
    {
        $reconciler  = new DefaultReconciler;

        $calculators = [
            new TotalMetaData($reconciler),
            new ProductsMetaData
        ];

        $this->processor = new Processor($reconciler, $calculators);
        $this->fixtures  = new BasketFixture;
    }

    /** @test */
    public function should_create_array_of_processed_totals()
    {
        $basket = $this->fixtures->one();

        $totals = $this->processor->totals($basket);

        $this->assertTrue(is_array($totals));
        $this->assertEquals(2, count($totals));
    }

    /** @test */
    public function should_create_array_of_processed_products()
    {
        $basket = $this->fixtures->one();

        $products = $this->processor->products($basket);

        $this->assertTrue(is_array($products));
        $this->assertEquals(2, count($products));
    }

    /** @test */
    public function should_return_processed_payload()
    {
        $basket = $this->fixtures->one();

        $order = $this->processor->process($basket);

        $this->assertInstanceOf('PhilipBrown\Basket\Order', $order);
    }
}
