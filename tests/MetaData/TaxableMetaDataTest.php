<?php namespace PhilipBrown\Basket\Tests\MetaData;

use PhilipBrown\Basket\Fixtures\BasketFixture;
use PhilipBrown\Basket\MetaData\TaxableMetaData;

class TaxableMetaDataTest extends \PHPUnit_Framework_TestCase
{
    /** @var MetaData */
    private $meta;

    /** @var BasketFixture */
    private $fixtures;

    public function setUp()
    {
        $this->fixtures = new BasketFixture;
        $this->meta     = new TaxableMetaData;
    }

    /** @test */
    public function should_return_the_name_of_the_meta_data()
    {
        $this->assertEquals('taxable', $this->meta->name());
    }

    /** @test */
    public function should_calculate_the_number_of_taxable_products_for_basket_fixture_zero()
    {
        $basket = $this->fixtures->zero();

        $total = $this->meta->generate($basket);

        $this->assertEquals(1, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_taxable_products_for_basket_fixture_one()
    {
        $basket = $this->fixtures->one();

        $total = $this->meta->generate($basket);

        $this->assertEquals(3, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_taxable_products_for_basket_fixture_two()
    {
        $basket = $this->fixtures->two();

        $total = $this->meta->generate($basket);

        $this->assertEquals(2, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_taxable_products_for_basket_fixture_three()
    {
        $basket = $this->fixtures->three();

        $total = $this->meta->generate($basket);

        $this->assertEquals(3, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_taxable_products_for_basket_fixture_four()
    {
        $basket = $this->fixtures->four();

        $total = $this->meta->generate($basket);

        $this->assertEquals(4, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_taxable_products_for_basket_fixture_five()
    {
        $basket = $this->fixtures->five();

        $total = $this->meta->generate($basket);

        $this->assertEquals(4, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_taxable_products_for_basket_fixture_six()
    {
        $basket = $this->fixtures->six();

        $total = $this->meta->generate($basket);

        $this->assertEquals(6, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_taxable_products_for_basket_fixture_seven()
    {
        $basket = $this->fixtures->seven();

        $total = $this->meta->generate($basket);

        $this->assertEquals(6, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_taxable_products_for_basket_fixture_eight()
    {
        $basket = $this->fixtures->eight();

        $total = $this->meta->generate($basket);

        $this->assertEquals(5, $total);
    }

    /** @test */
    public function should_calculate_the_number_of_taxable_products_for_basket_fixture_nine()
    {
        $basket = $this->fixtures->nine();

        $total = $this->meta->generate($basket);

        $this->assertEquals(5, $total);
    }
}
