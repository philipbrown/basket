<?php namespace PhilipBrown\Basket\Tests\MetaData;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Fixtures\BasketFixture;
use PhilipBrown\Basket\MetaData\DeliveryMetaData;
use PhilipBrown\Basket\Reconcilers\DefaultReconciler;

class DeliveryCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var MetaData */
    private $meta;

    /** @var BasketFixture */
    private $fixtures;

    public function setUp()
    {
        $reconciler     = new DefaultReconciler;
        $this->fixtures = new BasketFixture;
        $this->meta     = new DeliveryMetaData($reconciler);
    }

    /** @test */
    public function should_return_the_name_of_the_meta_data()
    {
        $this->assertEquals('delivery', $this->meta->name());
    }

    /** @test */
    public function should_calculate_the_delivery_for_basket_fixture_zero()
    {
        $basket = $this->fixtures->zero();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(0, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_delivery_for_basket_fixture_one()
    {
        $basket = $this->fixtures->one();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(0, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_delivery_for_basket_fixture_two()
    {
        $basket = $this->fixtures->two();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(0, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_delivery_for_basket_fixture_three()
    {
        $basket = $this->fixtures->three();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(6000, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_delivery_for_basket_fixture_four()
    {
        $basket = $this->fixtures->four();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(3994, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_delivery_for_basket_fixture_five()
    {
        $basket = $this->fixtures->five();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(297, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_delivery_for_basket_fixture_six()
    {
        $basket = $this->fixtures->six();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(2796, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_delivery_for_basket_fixture_seven()
    {
        $basket = $this->fixtures->seven();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(8796, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_delivery_for_basket_fixture_eight()
    {
        $basket = $this->fixtures->eight();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(0, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_delivery_for_basket_fixture_nine()
    {
        $basket = $this->fixtures->nine();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(1495, new Currency('GBP')), $total);
    }
}
