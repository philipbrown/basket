<?php namespace PhilipBrown\Basket\Tests\MetaData;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Fixtures\BasketFixture;
use PhilipBrown\Basket\MetaData\TotalMetaData;
use PhilipBrown\Basket\Reconcilers\DefaultReconciler;

class TotalMetaDataTest extends \PHPUnit_Framework_TestCase
{
    /** @var MetaData */
    private $meta;

    /** @var BasketFixture */
    private $fixtures;

    public function setUp()
    {
        $reconciler     = new DefaultReconciler;
        $this->fixtures = new BasketFixture;
        $this->meta     = new TotalMetaData($reconciler);
    }

    /** @test */
    public function should_return_the_name_of_the_meta_data()
    {
        $this->assertEquals('total', $this->meta->name());
    }

    /** @test */
    public function should_calculate_the_total_for_basket_fixture_zero()
    {
        $basket = $this->fixtures->zero();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(1200, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_for_basket_fixture_one()
    {
        $basket = $this->fixtures->one();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(37496, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_for_basket_fixture_two()
    {
        $basket = $this->fixtures->two();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(107999, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_for_basket_fixture_three()
    {
        $basket = $this->fixtures->three();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(226138, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_for_basket_fixture_four()
    {
        $basket = $this->fixtures->four();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(26243, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_for_basket_fixture_five()
    {
        $basket = $this->fixtures->five();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(109796, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_for_basket_six()
    {
        $basket = $this->fixtures->six();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(18247, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_for_basket_seven()
    {
        $basket = $this->fixtures->seven();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(135186, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_for_basket_eight()
    {
        $basket = $this->fixtures->eight();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(143995, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_total_for_basket_nine()
    {
        $basket = $this->fixtures->nine();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(14833, new Currency('GBP')), $total);
    }
}
