<?php namespace PhilipBrown\Basket\Tests\MetaData;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\MetaData\TaxMetaData;
use PhilipBrown\Basket\Fixtures\BasketFixture;
use PhilipBrown\Basket\Reconcilers\DefaultReconciler;

class TaxMetaDataTest extends \PHPUnit_Framework_TestCase
{
    /** @var MetaData */
    private $meta;

    /** @var BasketFixture */
    private $fixtures;

    public function setUp()
    {
        $reconciler     = new DefaultReconciler;
        $this->fixtures = new BasketFixture;
        $this->meta     = new TaxMetaData($reconciler);
    }

    /** @test */
    public function should_return_the_name_of_the_meta_data()
    {
        $this->assertEquals('tax', $this->meta->name());
    }

    /** @test */
    public function should_calculate_the_tax_for_basket_fixture_zero()
    {
        $basket = $this->fixtures->zero();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(200, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_tax_for_basket_fixture_one()
    {
        $basket = $this->fixtures->one();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(5999, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_tax_for_basket_fixture_two()
    {
        $basket = $this->fixtures->two();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(18000, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_tax_for_basket_fixture_three()
    {
        $basket = $this->fixtures->three();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(36690, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_tax_for_basket_fixture_four()
    {
        $basket = $this->fixtures->four();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(2375, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_tax_for_basket_fixture_five()
    {
        $basket = $this->fixtures->five();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(18000, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_tax_for_basket_fixture_six()
    {
        $basket = $this->fixtures->six();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(2575, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_tax_for_basket_fixture_seven()
    {
        $basket = $this->fixtures->seven();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(21065, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_tax_for_basket_fixture_eight()
    {
        $basket = $this->fixtures->eight();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(23999, new Currency('GBP')), $total);
    }

    /** @test */
    public function should_calculate_the_tax_for_basket_fixture_nine()
    {
        $basket = $this->fixtures->nine();

        $total = $this->meta->generate($basket);

        $this->assertEquals(new Money(890, new Currency('GBP')), $total);
    }
}
