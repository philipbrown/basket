<?php namespace PhilipBrown\Basket\Tests\MetaData;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Fixtures\BasketFixture;
use PhilipBrown\Basket\MetaData\SubtotalMetaData;
use PhilipBrown\Basket\Reconcilers\DefaultReconciler;

class SubtotalCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var MetaData */
    private $meta;

    /** @var BasketFixture */
    private $fixtures;

    public function setUp()
    {
        $reconciler       = new DefaultReconciler;
        $this->fixtures   = new BasketFixture;
        $this->meta       = new SubtotalMetaData($reconciler);
    }

    /** @test */
    public function should_return_the_name_of_the_meta_data()
    {
        $this->assertEquals('subtotal', $this->meta->name());
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_zero()
    {
        $basket = $this->fixtures->zero();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(1000, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_one()
    {
        $basket = $this->fixtures->one();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(31497, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_two()
    {
        $basket = $this->fixtures->two();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(89999, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_three()
    {
        $basket = $this->fixtures->three();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(189448, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_four()
    {
        $basket = $this->fixtures->four();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(23868, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_five()
    {
        $basket = $this->fixtures->five();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(91796, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_six()
    {
        $basket = $this->fixtures->six();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(15672, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_seven()
    {
        $basket = $this->fixtures->seven();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(114121, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_eight()
    {
        $basket = $this->fixtures->eight();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(119996, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_subtotal_for_basket_fixture_nine()
    {
        $basket = $this->fixtures->nine();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(13943, new Currency('GBP')), $total);
    }
}
