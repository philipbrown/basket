<?php namespace PhilipBrown\Basket\Tests\Reconcilers;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Fixtures\ProductFixture;
use PhilipBrown\Basket\Reconcilers\DefaultReconciler;

class DefaultReconcilerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ProductFixture */
    private $fixtures;

    /** @var Reconciler */
    private $reconciler;

    public function setUp()
    {
        $this->fixtures   = new ProductFixture;
        $this->reconciler = new DefaultReconciler;
    }

    /** @test */
    public function should_reconcile_product_fixture_zero()
    {
        $product = $this->fixtures->zero();

        $value    = $this->reconciler->value($product);
        $discount = $this->reconciler->discount($product);
        $delivery = $this->reconciler->delivery($product);
        $tax      = $this->reconciler->tax($product);
        $subtotal = $this->reconciler->subtotal($product);
        $total    = $this->reconciler->total($product);

        $this->assertEquals(new Money(1000, new Currency('GBP')), $value);
        $this->assertEquals(new Money(0,    new Currency('GBP')), $discount);
        $this->assertEquals(new Money(0,    new Currency('GBP')), $delivery);
        $this->assertEquals(new Money(200,  new Currency('GBP')), $tax);
        $this->assertEquals(new Money(1000, new Currency('GBP')), $subtotal);
        $this->assertEquals(new Money(1200, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_reconcile_product_fixture_one()
    {
        $product = $this->fixtures->one();

        $value    = $this->reconciler->value($product);
        $discount = $this->reconciler->discount($product);
        $delivery = $this->reconciler->delivery($product);
        $tax      = $this->reconciler->tax($product);
        $subtotal = $this->reconciler->subtotal($product);
        $total    = $this->reconciler->total($product);

        $this->assertEquals(new Money(1500, new Currency('GBP')), $value);
        $this->assertEquals(new Money(0,    new Currency('GBP')), $discount);
        $this->assertEquals(new Money(0,    new Currency('GBP')), $delivery);
        $this->assertEquals(new Money(0,    new Currency('GBP')), $tax);
        $this->assertEquals(new Money(1500, new Currency('GBP')), $subtotal);
        $this->assertEquals(new Money(1500, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_reconcile_product_fixture_two()
    {
        $product = $this->fixtures->two();

        $value    = $this->reconciler->value($product);
        $discount = $this->reconciler->discount($product);
        $delivery = $this->reconciler->delivery($product);
        $tax      = $this->reconciler->tax($product);
        $subtotal = $this->reconciler->subtotal($product);
        $total    = $this->reconciler->total($product);

        $this->assertEquals(new Money(29997, new Currency('GBP')), $value);
        $this->assertEquals(new Money(0,     new Currency('GBP')), $discount);
        $this->assertEquals(new Money(0,     new Currency('GBP')), $delivery);
        $this->assertEquals(new Money(5999,  new Currency('GBP')), $tax);
        $this->assertEquals(new Money(29997, new Currency('GBP')), $subtotal);
        $this->assertEquals(new Money(35996, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_reconcile_product_fixture_three()
    {
        $product = $this->fixtures->three();

        $value    = $this->reconciler->value($product);
        $discount = $this->reconciler->discount($product);
        $delivery = $this->reconciler->delivery($product);
        $tax      = $this->reconciler->tax($product);
        $subtotal = $this->reconciler->subtotal($product);
        $total    = $this->reconciler->total($product);

        $this->assertEquals(new Money(499, new Currency('GBP')), $value);
        $this->assertEquals(new Money(0,   new Currency('GBP')), $discount);
        $this->assertEquals(new Money(0,   new Currency('GBP')), $delivery);
        $this->assertEquals(new Money(0,   new Currency('GBP')), $tax);
        $this->assertEquals(new Money(0,   new Currency('GBP')), $subtotal);
        $this->assertEquals(new Money(0,   new Currency('GBP')), $total);
    }

    /** @test */
    public function should_reconcile_product_fixture_four()
    {
        $product = $this->fixtures->four();

        $value    = $this->reconciler->value($product);
        $discount = $this->reconciler->discount($product);
        $delivery = $this->reconciler->delivery($product);
        $tax      = $this->reconciler->tax($product);
        $subtotal = $this->reconciler->subtotal($product);
        $total    = $this->reconciler->total($product);

        $this->assertEquals(new Money(99999,  new Currency('GBP')), $value);
        $this->assertEquals(new Money(10000,  new Currency('GBP')), $discount);
        $this->assertEquals(new Money(0,      new Currency('GBP')), $delivery);
        $this->assertEquals(new Money(18000,  new Currency('GBP')), $tax);
        $this->assertEquals(new Money(89999,  new Currency('GBP')), $subtotal);
        $this->assertEquals(new Money(107999, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_reconcile_product_fixture_five()
    {
        $product = $this->fixtures->five();

        $value    = $this->reconciler->value($product);
        $discount = $this->reconciler->discount($product);
        $delivery = $this->reconciler->delivery($product);
        $tax      = $this->reconciler->tax($product);
        $subtotal = $this->reconciler->subtotal($product);
        $total    = $this->reconciler->total($product);

        $this->assertEquals(new Money(4950, new Currency('GBP')), $value);
        $this->assertEquals(new Money(1500, new Currency('GBP')), $discount);
        $this->assertEquals(new Money(0,    new Currency('GBP')), $delivery);
        $this->assertEquals(new Money(690,  new Currency('GBP')), $tax);
        $this->assertEquals(new Money(3450, new Currency('GBP')), $subtotal);
        $this->assertEquals(new Money(4140, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_reconcile_product_fixture_six()
    {
        $product = $this->fixtures->six();

        $value    = $this->reconciler->value($product);
        $discount = $this->reconciler->discount($product);
        $delivery = $this->reconciler->delivery($product);
        $tax      = $this->reconciler->tax($product);
        $subtotal = $this->reconciler->subtotal($product);
        $total    = $this->reconciler->total($product);

        $this->assertEquals(new Money(89999,  new Currency('GBP')), $value);
        $this->assertEquals(new Money(0,      new Currency('GBP')), $discount);
        $this->assertEquals(new Money(6000,   new Currency('GBP')), $delivery);
        $this->assertEquals(new Money(18000,  new Currency('GBP')), $tax);
        $this->assertEquals(new Money(95999,  new Currency('GBP')), $subtotal);
        $this->assertEquals(new Money(113999, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_reconcile_product_fixture_seven()
    {
        $product = $this->fixtures->seven();

        $value    = $this->reconciler->value($product);
        $discount = $this->reconciler->discount($product);
        $delivery = $this->reconciler->delivery($product);
        $tax      = $this->reconciler->tax($product);
        $subtotal = $this->reconciler->subtotal($product);
        $total    = $this->reconciler->total($product);

        $this->assertEquals(new Money(13196, new Currency('GBP')), $value);
        $this->assertEquals(new Money(1320,  new Currency('GBP')), $discount);
        $this->assertEquals(new Money(2796,  new Currency('GBP')), $delivery);
        $this->assertEquals(new Money(2375,  new Currency('GBP')), $tax);
        $this->assertEquals(new Money(14672, new Currency('GBP')), $subtotal);
        $this->assertEquals(new Money(17047, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_reconcile_product_fixture_eight()
    {
        $product = $this->fixtures->eight();

        $value    = $this->reconciler->value($product);
        $discount = $this->reconciler->discount($product);
        $delivery = $this->reconciler->delivery($product);
        $tax      = $this->reconciler->tax($product);
        $subtotal = $this->reconciler->subtotal($product);
        $total    = $this->reconciler->total($product);

        $this->assertEquals(new Money(7998, new Currency('GBP')), $value);
        $this->assertEquals(new Money(0,    new Currency('GBP')), $discount);
        $this->assertEquals(new Money(1198, new Currency('GBP')), $delivery);
        $this->assertEquals(new Money(0,    new Currency('GBP')), $tax);
        $this->assertEquals(new Money(9196, new Currency('GBP')), $subtotal);
        $this->assertEquals(new Money(9196, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_reconcile_product_fixture_nine()
    {
        $product = $this->fixtures->nine();

        $value    = $this->reconciler->value($product);
        $discount = $this->reconciler->discount($product);
        $delivery = $this->reconciler->delivery($product);
        $tax      = $this->reconciler->tax($product);
        $subtotal = $this->reconciler->subtotal($product);
        $total    = $this->reconciler->total($product);

        $this->assertEquals(new Money(7500, new Currency('GBP')), $value);
        $this->assertEquals(new Money(0,    new Currency('GBP')), $discount);
        $this->assertEquals(new Money(297,  new Currency('GBP')), $delivery);
        $this->assertEquals(new Money(0,    new Currency('GBP')), $tax);
        $this->assertEquals(new Money(297,  new Currency('GBP')), $subtotal);
        $this->assertEquals(new Money(297,  new Currency('GBP')), $total);
    }
}
