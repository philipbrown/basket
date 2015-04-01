<?php namespace PhilipBrown\Basket\Tests;

use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Processor;
use PhilipBrown\Basket\Collection;
use PhilipBrown\Basket\MetaData\TaxMetaData;
use PhilipBrown\Basket\Fixtures\BasketFixture;
use PhilipBrown\Basket\MetaData\ValueMetaData;
use PhilipBrown\Basket\MetaData\TotalMetaData;
use PhilipBrown\Basket\Categories\PhysicalBook;
use PhilipBrown\Basket\Discounts\ValueDiscount;
use PhilipBrown\Basket\MetaData\TaxableMetaData;
use PhilipBrown\Basket\MetaData\DeliveryMetaData;
use PhilipBrown\Basket\MetaData\DiscountMetaData;
use PhilipBrown\Basket\MetaData\SubtotalMetaData;
use PhilipBrown\Basket\MetaData\ProductsMetaData;
use PhilipBrown\Basket\Discounts\PercentageDiscount;
use PhilipBrown\Basket\Reconcilers\DefaultReconciler;
use PhilipBrown\Basket\TaxRates\UnitedKingdomValueAddedTax;

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
            new DeliveryMetaData($reconciler),
            new DiscountMetaData($reconciler),
            new ProductsMetaData,
            new SubtotalMetaData($reconciler),
            new TaxableMetaData,
            new TaxMetaData($reconciler),
            new TotalMetaData($reconciler),
            new ValueMetaData($reconciler)
        ];

        $this->processor = new Processor($reconciler, $calculators);
        $this->fixtures  = new BasketFixture;
    }

    /** @test */
    public function should_process_basket_fixture_zero()
    {
        $order    = $this->processor->process($this->fixtures->zero());
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',       $order);
        $this->assertEquals(new Money(0, new Currency('GBP')),    $meta['delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),    $meta['discount']);
        $this->assertEquals(1,                                    $meta['products_count']);
        $this->assertEquals(new Money(1000, new Currency('GBP')), $meta['subtotal']);
        $this->assertEquals(1,                                    $meta['taxable']);
        $this->assertEquals(new Money(200, new Currency('GBP')),  $meta['tax']);
        $this->assertEquals(new Money(1200, new Currency('GBP')), $meta['total']);
        $this->assertEquals(new Money(1000, new Currency('GBP')), $meta['value']);
        $this->assertEquals('0',                                  $products[0]['sku']);
        $this->assertEquals('Back to the Future Blu-ray',         $products[0]['name']);
        $this->assertEquals(new Money(1000, new Currency('GBP')), $products[0]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,       $products[0]['rate']);
        $this->assertEquals(1,                                    $products[0]['quantity']);
        $this->assertEquals(false,                                $products[0]['freebie']);
        $this->assertEquals(true,                                 $products[0]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),    $products[0]['delivery']);
        $this->assertEquals(new Collection,                       $products[0]['coupons']);
        $this->assertEquals(new Collection,                       $products[0]['tags']);
        $this->assertEquals(null,                                 $products[0]['discounts']->first());
        $this->assertEquals(null,                                 $products[0]['category']);
        $this->assertEquals(new Money(0, new Currency('GBP')),    $products[0]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),    $products[0]['total_delivery']);
        $this->assertEquals(new Money(200, new Currency('GBP')),  $products[0]['total_tax']);
        $this->assertEquals(new Money(1000, new Currency('GBP')), $products[0]['subtotal']);
        $this->assertEquals(new Money(1200, new Currency('GBP')), $products[0]['total']);
    }

    /** @test */
    public function should_process_basket_fixture_one()
    {
        $order    = $this->processor->process($this->fixtures->one());
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',        $order);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $meta['delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $meta['discount']);
        $this->assertEquals(4,                                     $meta['products_count']);
        $this->assertEquals(new Money(31497, new Currency('GBP')), $meta['subtotal']);
        $this->assertEquals(3,                                     $meta['taxable']);
        $this->assertEquals(new Money(5999, new Currency('GBP')),  $meta['tax']);
        $this->assertEquals(new Money(37496, new Currency('GBP')), $meta['total']);
        $this->assertEquals(new Money(31497, new Currency('GBP')), $meta['value']);
        $this->assertEquals('1',                                   $products[0]['sku']);
        $this->assertEquals('The 4-Hour Work Week',                $products[0]['name']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),  $products[0]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,        $products[0]['rate']);
        $this->assertEquals(1,                                     $products[0]['quantity']);
        $this->assertEquals(false,                                 $products[0]['freebie']);
        $this->assertEquals(false,                                 $products[0]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[0]['delivery']);
        $this->assertEquals(new Collection,                        $products[0]['coupons']);
        $this->assertEquals(new Collection,                        $products[0]['tags']);
        $this->assertEquals(null,                                  $products[0]['discounts']->first());
        $this->assertEquals(new PhysicalBook,                      $products[0]['category']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),  $products[0]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[0]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[0]['total_delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[0]['total_tax']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),  $products[0]['subtotal']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),  $products[0]['total']);
        $this->assertEquals('2',                                   $products[1]['sku']);
        $this->assertEquals('Kindle',                              $products[1]['name']);
        $this->assertEquals(new Money(9999, new Currency('GBP')),  $products[1]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,        $products[1]['rate']);
        $this->assertEquals(3,                                     $products[1]['quantity']);
        $this->assertEquals(false,                                 $products[1]['freebie']);
        $this->assertEquals(true,                                  $products[1]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['delivery']);
        $this->assertEquals(new Collection,                        $products[1]['coupons']);
        $this->assertEquals(new Collection,                        $products[1]['tags']);
        $this->assertEquals(null,                                  $products[1]['discounts']->first());
        $this->assertEquals(null,                                  $products[1]['category']);
        $this->assertEquals(new Money(29997, new Currency('GBP')), $products[1]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['total_delivery']);
        $this->assertEquals(new Money(5999, new Currency('GBP')),  $products[1]['total_tax']);
        $this->assertEquals(new Money(29997, new Currency('GBP')), $products[1]['subtotal']);
        $this->assertEquals(new Money(35996, new Currency('GBP')), $products[1]['total']);
    }

    /** @test */
    public function should_process_basket_fixture_two()
    {
        $order    = $this->processor->process($this->fixtures->two());
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',         $order);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $meta['delivery']);
        $this->assertEquals(new Money(10000, new Currency('GBP')),  $meta['discount']);
        $this->assertEquals(2,                                      $meta['products_count']);
        $this->assertEquals(new Money(89999, new Currency('GBP')),  $meta['subtotal']);
        $this->assertEquals(2,                                      $meta['taxable']);
        $this->assertEquals(new Money(18000, new Currency('GBP')),  $meta['tax']);
        $this->assertEquals(new Money(107999, new Currency('GBP')), $meta['total']);
        $this->assertEquals(new Money(100498, new Currency('GBP')), $meta['value']);
        $this->assertEquals('3',                                    $products[0]['sku']);
        $this->assertEquals('iPhone case',                          $products[0]['name']);
        $this->assertEquals(new Money(499, new Currency('GBP')),    $products[0]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,         $products[0]['rate']);
        $this->assertEquals(1,                                      $products[0]['quantity']);
        $this->assertEquals(true,                                   $products[0]['freebie']);
        $this->assertEquals(true,                                   $products[0]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['delivery']);
        $this->assertEquals(new Collection,                         $products[0]['coupons']);
        $this->assertEquals(new Collection,                         $products[0]['tags']);
        $this->assertEquals(null,                                   $products[0]['discounts']->first());
        $this->assertEquals(null,                                   $products[0]['category']);
        $this->assertEquals(new Money(499, new Currency('GBP')),    $products[0]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['total_delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['total_tax']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['subtotal']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['total']);
        $this->assertEquals('4',                                    $products[1]['sku']);
        $this->assertEquals('MacBook Air',                          $products[1]['name']);
        $this->assertEquals(new Money(99999, new Currency('GBP')),  $products[1]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,         $products[1]['rate']);
        $this->assertEquals(1,                                      $products[1]['quantity']);
        $this->assertEquals(false,                                  $products[1]['freebie']);
        $this->assertEquals(true,                                   $products[1]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[1]['delivery']);
        $this->assertEquals(new Collection,                         $products[1]['coupons']);
        $this->assertEquals(new Collection,                         $products[1]['tags']);
        $this->assertEquals(new PercentageDiscount(10),             $products[1]['discounts']->first());
        $this->assertEquals(null,                                   $products[1]['category']);
        $this->assertEquals(new Money(99999, new Currency('GBP')),  $products[1]['total_value']);
        $this->assertEquals(new Money(10000, new Currency('GBP')),  $products[1]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[1]['total_delivery']);
        $this->assertEquals(new Money(18000, new Currency('GBP')),  $products[1]['total_tax']);
        $this->assertEquals(new Money(89999, new Currency('GBP')),  $products[1]['subtotal']);
        $this->assertEquals(new Money(107999, new Currency('GBP')), $products[1]['total']);
    }

    /** @test */
    public function should_process_basket_fixture_three()
    {
        $order    = $this->processor->process($this->fixtures->three());
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',                          $order);
        $this->assertEquals(new Money(6000, new Currency('GBP')),                    $meta['delivery']);
        $this->assertEquals(new Money(11500, new Currency('GBP')),                   $meta['discount']);
        $this->assertEquals(3,                                                       $meta['products_count']);
        $this->assertEquals(new Money(189448, new Currency('GBP')),                  $meta['subtotal']);
        $this->assertEquals(3,                                                       $meta['taxable']);
        $this->assertEquals(new Money(36690, new Currency('GBP')),                   $meta['tax']);
        $this->assertEquals(new Money(226138, new Currency('GBP')),                  $meta['total']);
        $this->assertEquals(new Money(194948, new Currency('GBP')),                  $meta['value']);
        $this->assertEquals('4',                                                     $products[0]['sku']);
        $this->assertEquals('MacBook Air',                                           $products[0]['name']);
        $this->assertEquals(new Money(99999, new Currency('GBP')),                   $products[0]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,                          $products[0]['rate']);
        $this->assertEquals(1,                                                       $products[0]['quantity']);
        $this->assertEquals(false,                                                   $products[0]['freebie']);
        $this->assertEquals(true,                                                    $products[0]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[0]['delivery']);
        $this->assertEquals(new Collection,                                          $products[0]['coupons']);
        $this->assertEquals(new Collection,                                          $products[0]['tags']);
        $this->assertEquals(new PercentageDiscount(10),                              $products[0]['discounts']->first());
        $this->assertEquals(null,                                                    $products[0]['category']);
        $this->assertEquals(new Money(99999, new Currency('GBP')),                   $products[0]['total_value']);
        $this->assertEquals(new Money(10000, new Currency('GBP')),                   $products[0]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[0]['total_delivery']);
        $this->assertEquals(new Money(18000, new Currency('GBP')),                   $products[0]['total_tax']);
        $this->assertEquals(new Money(89999, new Currency('GBP')),                   $products[0]['subtotal']);
        $this->assertEquals(new Money(107999, new Currency('GBP')),                  $products[0]['total']);
        $this->assertEquals('5',                                                     $products[1]['sku']);
        $this->assertEquals('Sega Mega Drive',                                       $products[1]['name']);
        $this->assertEquals(new Money(4950, new Currency('GBP')),                    $products[1]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,                          $products[1]['rate']);
        $this->assertEquals(1,                                                       $products[1]['quantity']);
        $this->assertEquals(false,                                                   $products[1]['freebie']);
        $this->assertEquals(true,                                                    $products[1]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[1]['delivery']);
        $this->assertEquals(new Collection,                                          $products[1]['coupons']);
        $this->assertEquals(new Collection,                                          $products[1]['tags']);
        $this->assertEquals(new ValueDiscount(new Money(1500, new Currency('GBP'))), $products[1]['discounts']->first());
        $this->assertEquals(null,                                                    $products[1]['category']);
        $this->assertEquals(new Money(4950, new Currency('GBP')),                    $products[1]['total_value']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),                    $products[1]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[1]['total_delivery']);
        $this->assertEquals(new Money(690, new Currency('GBP')),                     $products[1]['total_tax']);
        $this->assertEquals(new Money(3450, new Currency('GBP')),                    $products[1]['subtotal']);
        $this->assertEquals(new Money(4140, new Currency('GBP')),                    $products[1]['total']);
        $this->assertEquals('6',                                                     $products[2]['sku']);
        $this->assertEquals('Aeron Chair',                                           $products[2]['name']);
        $this->assertEquals(new Money(89999, new Currency('GBP')),                   $products[2]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,                          $products[2]['rate']);
        $this->assertEquals(1,                                                       $products[2]['quantity']);
        $this->assertEquals(false,                                                   $products[2]['freebie']);
        $this->assertEquals(true,                                                    $products[2]['taxable']);
        $this->assertEquals(new Money(6000, new Currency('GBP')),                    $products[2]['delivery']);
        $this->assertEquals(new Collection,                                          $products[2]['coupons']);
        $this->assertEquals(new Collection,                                          $products[2]['tags']);
        $this->assertEquals(null,                                                    $products[2]['discounts']->first());
        $this->assertEquals(null,                                                    $products[2]['category']);
        $this->assertEquals(new Money(89999, new Currency('GBP')),                   $products[2]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[2]['total_discount']);
        $this->assertEquals(new Money(6000, new Currency('GBP')),                    $products[2]['total_delivery']);
        $this->assertEquals(new Money(18000, new Currency('GBP')),                   $products[2]['total_tax']);
        $this->assertEquals(new Money(95999, new Currency('GBP')),                   $products[2]['subtotal']);
        $this->assertEquals(new Money(113999, new Currency('GBP')),                  $products[2]['total']);
    }

    /** @test */
    public function should_process_basket_fixture_four()
    {
        $order    = $this->processor->process($this->fixtures->four());
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',        $order);
        $this->assertEquals(new Money(3994, new Currency('GBP')),  $meta['delivery']);
        $this->assertEquals(new Money(1320, new Currency('GBP')),  $meta['discount']);
        $this->assertEquals(6,                                     $meta['products_count']);
        $this->assertEquals(new Money(23868, new Currency('GBP')), $meta['subtotal']);
        $this->assertEquals(4,                                     $meta['taxable']);
        $this->assertEquals(new Money(2375, new Currency('GBP')),  $meta['tax']);
        $this->assertEquals(new Money(26243, new Currency('GBP')), $meta['total']);
        $this->assertEquals(new Money(21194, new Currency('GBP')), $meta['value']);
        $this->assertEquals('7',                                   $products[0]['sku']);
        $this->assertEquals('Kettlebell',                          $products[0]['name']);
        $this->assertEquals(new Money(3299, new Currency('GBP')),  $products[0]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,        $products[0]['rate']);
        $this->assertEquals(4,                                     $products[0]['quantity']);
        $this->assertEquals(false,                                 $products[0]['freebie']);
        $this->assertEquals(true,                                  $products[0]['taxable']);
        $this->assertEquals(new Money(699, new Currency('GBP')),   $products[0]['delivery']);
        $this->assertEquals(new Collection,                        $products[0]['coupons']);
        $this->assertEquals(new Collection,                        $products[0]['tags']);
        $this->assertEquals(new PercentageDiscount(10),            $products[0]['discounts']->first());
        $this->assertEquals(null,                                  $products[0]['category']);
        $this->assertEquals(new Money(13196, new Currency('GBP')), $products[0]['total_value']);
        $this->assertEquals(new Money(1320, new Currency('GBP')),  $products[0]['total_discount']);
        $this->assertEquals(new Money(2796, new Currency('GBP')),  $products[0]['total_delivery']);
        $this->assertEquals(new Money(2375, new Currency('GBP')),  $products[0]['total_tax']);
        $this->assertEquals(new Money(14672, new Currency('GBP')), $products[0]['subtotal']);
        $this->assertEquals(new Money(17047, new Currency('GBP')), $products[0]['total']);
        $this->assertEquals('8',                                   $products[1]['sku']);
        $this->assertEquals('Junior Jordans',                      $products[1]['name']);
        $this->assertEquals(new Money(3999, new Currency('GBP')),  $products[1]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,        $products[1]['rate']);
        $this->assertEquals(2,                                     $products[1]['quantity']);
        $this->assertEquals(false,                                 $products[1]['freebie']);
        $this->assertEquals(false,                                 $products[1]['taxable']);
        $this->assertEquals(new Money(599, new Currency('GBP')),   $products[1]['delivery']);
        $this->assertEquals(new Collection,                        $products[1]['coupons']);
        $this->assertEquals(new Collection,                        $products[1]['tags']);
        $this->assertEquals(null,                                  $products[1]['discounts']->first());
        $this->assertEquals(null,                                  $products[1]['category']);
        $this->assertEquals(new Money(7998, new Currency('GBP')),  $products[1]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['total_discount']);
        $this->assertEquals(new Money(1198, new Currency('GBP')),  $products[1]['total_delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['total_tax']);
        $this->assertEquals(new Money(9196, new Currency('GBP')),  $products[1]['subtotal']);
        $this->assertEquals(new Money(9196, new Currency('GBP')),  $products[1]['total']);
    }

    /** @test */
    public function should_process_basket_fixture_five()
    {
        $order    = $this->processor->process($this->fixtures->five());
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',         $order);
        $this->assertEquals(new Money(297, new Currency('GBP')),    $meta['delivery']);
        $this->assertEquals(new Money(10000, new Currency('GBP')),  $meta['discount']);
        $this->assertEquals(5,                                      $meta['products_count']);
        $this->assertEquals(new Money(91796, new Currency('GBP')),  $meta['subtotal']);
        $this->assertEquals(4,                                      $meta['taxable']);
        $this->assertEquals(new Money(18000, new Currency('GBP')),  $meta['tax']);
        $this->assertEquals(new Money(109796, new Currency('GBP')), $meta['total']);
        $this->assertEquals(new Money(108999, new Currency('GBP')), $meta['value']);
        $this->assertEquals('1',                                    $products[0]['sku']);
        $this->assertEquals('The 4-Hour Work Week',                 $products[0]['name']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),   $products[0]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,         $products[0]['rate']);
        $this->assertEquals(1,                                      $products[0]['quantity']);
        $this->assertEquals(false,                                  $products[0]['freebie']);
        $this->assertEquals(false,                                  $products[0]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['delivery']);
        $this->assertEquals(new Collection,                         $products[0]['coupons']);
        $this->assertEquals(new Collection,                         $products[0]['tags']);
        $this->assertEquals(null,                                   $products[0]['discounts']->first());
        $this->assertEquals(new PhysicalBook,                       $products[0]['category']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),   $products[0]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['total_delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['total_tax']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),   $products[0]['subtotal']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),   $products[0]['total']);
        $this->assertEquals('4',                                    $products[1]['sku']);
        $this->assertEquals('MacBook Air',                          $products[1]['name']);
        $this->assertEquals(new Money(99999, new Currency('GBP')),  $products[1]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,         $products[1]['rate']);
        $this->assertEquals(1,                                      $products[1]['quantity']);
        $this->assertEquals(false,                                  $products[1]['freebie']);
        $this->assertEquals(true,                                   $products[1]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[1]['delivery']);
        $this->assertEquals(new Collection,                         $products[1]['coupons']);
        $this->assertEquals(new Collection,                         $products[1]['tags']);
        $this->assertEquals(new PercentageDiscount(10),             $products[1]['discounts']->first());
        $this->assertEquals(null,                                   $products[1]['category']);
        $this->assertEquals(new Money(99999, new Currency('GBP')),  $products[1]['total_value']);
        $this->assertEquals(new Money(10000, new Currency('GBP')),  $products[1]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[1]['total_delivery']);
        $this->assertEquals(new Money(18000, new Currency('GBP')),  $products[1]['total_tax']);
        $this->assertEquals(new Money(89999, new Currency('GBP')),  $products[1]['subtotal']);
        $this->assertEquals(new Money(107999, new Currency('GBP')), $products[1]['total']);
        $this->assertEquals('9',                                    $products[2]['sku']);
        $this->assertEquals('Gift Card',                            $products[2]['name']);
        $this->assertEquals(new Money(2500, new Currency('GBP')),   $products[2]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,         $products[2]['rate']);
        $this->assertEquals(3,                                      $products[2]['quantity']);
        $this->assertEquals(true,                                   $products[2]['freebie']);
        $this->assertEquals(true,                                   $products[2]['taxable']);
        $this->assertEquals(new Money(99, new Currency('GBP')),     $products[2]['delivery']);
        $this->assertEquals(new Collection,                         $products[2]['coupons']);
        $this->assertEquals(new Collection,                         $products[2]['tags']);
        $this->assertEquals(null,                                   $products[2]['discounts']->first());
        $this->assertEquals(null,                                   $products[2]['category']);
        $this->assertEquals(new Money(7500, new Currency('GBP')),   $products[2]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[2]['total_discount']);
        $this->assertEquals(new Money(297, new Currency('GBP')),    $products[2]['total_delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[2]['total_tax']);
        $this->assertEquals(new Money(297, new Currency('GBP')),    $products[2]['subtotal']);
        $this->assertEquals(new Money(297, new Currency('GBP')),    $products[2]['total']);
    }

    /** @test */
    public function should_process_basket_fixture_six()
    {
        $order    = $this->processor->process($this->fixtures->six());
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',        $order);
        $this->assertEquals(new Money(2796, new Currency('GBP')),  $meta['delivery']);
        $this->assertEquals(new Money(1320, new Currency('GBP')),  $meta['discount']);
        $this->assertEquals(6,                                     $meta['products_count']);
        $this->assertEquals(new Money(15672, new Currency('GBP')), $meta['subtotal']);
        $this->assertEquals(6,                                     $meta['taxable']);
        $this->assertEquals(new Money(2575, new Currency('GBP')),  $meta['tax']);
        $this->assertEquals(new Money(18247, new Currency('GBP')), $meta['total']);
        $this->assertEquals(new Money(14695, new Currency('GBP')), $meta['value']);
        $this->assertEquals('0',                                   $products[0]['sku']);
        $this->assertEquals('Back to the Future Blu-ray',          $products[0]['name']);
        $this->assertEquals(new Money(1000, new Currency('GBP')),  $products[0]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,        $products[0]['rate']);
        $this->assertEquals(1,                                     $products[0]['quantity']);
        $this->assertEquals(false,                                 $products[0]['freebie']);
        $this->assertEquals(true,                                  $products[0]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[0]['delivery']);
        $this->assertEquals(new Collection,                        $products[0]['coupons']);
        $this->assertEquals(new Collection,                        $products[0]['tags']);
        $this->assertEquals(null,                                  $products[0]['discounts']->first());
        $this->assertEquals(null,                                  $products[0]['category']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[0]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[0]['total_delivery']);
        $this->assertEquals(new Money(200, new Currency('GBP')),   $products[0]['total_tax']);
        $this->assertEquals(new Money(1000, new Currency('GBP')),  $products[0]['subtotal']);
        $this->assertEquals(new Money(1200, new Currency('GBP')),  $products[0]['total']);
        $this->assertEquals('3',                                   $products[1]['sku']);
        $this->assertEquals('iPhone case',                         $products[1]['name']);
        $this->assertEquals(new Money(499, new Currency('GBP')),   $products[1]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,        $products[1]['rate']);
        $this->assertEquals(1,                                     $products[1]['quantity']);
        $this->assertEquals(true,                                  $products[1]['freebie']);
        $this->assertEquals(true,                                  $products[1]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['delivery']);
        $this->assertEquals(new Collection,                        $products[1]['coupons']);
        $this->assertEquals(new Collection,                        $products[1]['tags']);
        $this->assertEquals(null,                                  $products[1]['discounts']->first());
        $this->assertEquals(null,                                  $products[1]['category']);
        $this->assertEquals(new Money(499, new Currency('GBP')),   $products[1]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['total_delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['total_tax']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['subtotal']);
        $this->assertEquals(new Money(0, new Currency('GBP')),     $products[1]['total']);
        $this->assertEquals('7',                                   $products[2]['sku']);
        $this->assertEquals('Kettlebell',                          $products[2]['name']);
        $this->assertEquals(new Money(3299, new Currency('GBP')),  $products[2]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,        $products[2]['rate']);
        $this->assertEquals(4,                                     $products[2]['quantity']);
        $this->assertEquals(false,                                 $products[2]['freebie']);
        $this->assertEquals(true,                                  $products[2]['taxable']);
        $this->assertEquals(new Money(699, new Currency('GBP')),   $products[2]['delivery']);
        $this->assertEquals(new Collection,                        $products[2]['coupons']);
        $this->assertEquals(new Collection,                        $products[2]['tags']);
        $this->assertEquals(new PercentageDiscount(10),            $products[2]['discounts']->first());
        $this->assertEquals(null,                                  $products[2]['category']);
        $this->assertEquals(new Money(13196, new Currency('GBP')), $products[2]['total_value']);
        $this->assertEquals(new Money(1320, new Currency('GBP')),  $products[2]['total_discount']);
        $this->assertEquals(new Money(2796, new Currency('GBP')),  $products[2]['total_delivery']);
        $this->assertEquals(new Money(2375, new Currency('GBP')),  $products[2]['total_tax']);
        $this->assertEquals(new Money(14672, new Currency('GBP')), $products[2]['subtotal']);
        $this->assertEquals(new Money(17047, new Currency('GBP')), $products[2]['total']);
    }

    /** @test */
    public function should_process_basket_fixture_seven()
    {
        $order    = $this->processor->process($this->fixtures->seven());
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',                         $order);
        $this->assertEquals(new Money(8796, new Currency('GBP')),                    $meta['delivery']);
        $this->assertEquals(new Money(2820, new Currency('GBP')),                    $meta['discount']);
        $this->assertEquals(6,                                                       $meta['products_count']);
        $this->assertEquals(new Money(114121, new Currency('GBP')),                  $meta['subtotal']);
        $this->assertEquals(6,                                                       $meta['taxable']);
        $this->assertEquals(new Money(21065, new Currency('GBP')),                   $meta['tax']);
        $this->assertEquals(new Money(135186, new Currency('GBP')),                  $meta['total']);
        $this->assertEquals(new Money(108145, new Currency('GBP')),                  $meta['value']);
        $this->assertEquals('5',                                                     $products[0]['sku']);
        $this->assertEquals('Sega Mega Drive',                                       $products[0]['name']);
        $this->assertEquals(new Money(4950, new Currency('GBP')),                    $products[0]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,                          $products[0]['rate']);
        $this->assertEquals(1,                                                       $products[0]['quantity']);
        $this->assertEquals(false,                                                   $products[0]['freebie']);
        $this->assertEquals(true,                                                    $products[0]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[0]['delivery']);
        $this->assertEquals(new Collection,                                          $products[0]['coupons']);
        $this->assertEquals(new Collection,                                          $products[0]['tags']);
        $this->assertEquals(new ValueDiscount(new Money(1500, new Currency('GBP'))), $products[0]['discounts']->first());
        $this->assertEquals(null,                                                    $products[0]['category']);
        $this->assertEquals(new Money(4950, new Currency('GBP')),                    $products[0]['total_value']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),                    $products[0]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[0]['total_delivery']);
        $this->assertEquals(new Money(690, new Currency('GBP')),                     $products[0]['total_tax']);
        $this->assertEquals(new Money(3450, new Currency('GBP')),                    $products[0]['subtotal']);
        $this->assertEquals(new Money(4140, new Currency('GBP')),                    $products[0]['total']);
        $this->assertEquals('6',                                                     $products[1]['sku']);
        $this->assertEquals('Aeron Chair',                                           $products[1]['name']);
        $this->assertEquals(new Money(89999, new Currency('GBP')),                   $products[1]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,                          $products[1]['rate']);
        $this->assertEquals(1,                                                       $products[1]['quantity']);
        $this->assertEquals(false,                                                   $products[1]['freebie']);
        $this->assertEquals(true,                                                    $products[1]['taxable']);
        $this->assertEquals(new Money(6000, new Currency('GBP')),                    $products[1]['delivery']);
        $this->assertEquals(new Collection,                                          $products[1]['coupons']);
        $this->assertEquals(new Collection,                                          $products[1]['tags']);
        $this->assertEquals(null,                                                    $products[1]['discounts']->first());
        $this->assertEquals(null,                                                    $products[1]['category']);
        $this->assertEquals(new Money(89999, new Currency('GBP')),                   $products[1]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[1]['total_discount']);
        $this->assertEquals(new Money(6000, new Currency('GBP')),                    $products[1]['total_delivery']);
        $this->assertEquals(new Money(18000, new Currency('GBP')),                   $products[1]['total_tax']);
        $this->assertEquals(new Money(95999, new Currency('GBP')),                   $products[1]['subtotal']);
        $this->assertEquals(new Money(113999, new Currency('GBP')),                  $products[1]['total']);
        $this->assertEquals('7',                                                     $products[2]['sku']);
        $this->assertEquals('Kettlebell',                                            $products[2]['name']);
        $this->assertEquals(new Money(3299, new Currency('GBP')),                    $products[2]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,                          $products[2]['rate']);
        $this->assertEquals(4,                                                       $products[2]['quantity']);
        $this->assertEquals(false,                                                   $products[2]['freebie']);
        $this->assertEquals(true,                                                    $products[2]['taxable']);
        $this->assertEquals(new Money(699, new Currency('GBP')),                     $products[2]['delivery']);
        $this->assertEquals(new Collection,                                          $products[2]['coupons']);
        $this->assertEquals(new Collection,                                          $products[2]['tags']);
        $this->assertEquals(new PercentageDiscount(10),                              $products[2]['discounts']->first());
        $this->assertEquals(null,                                                    $products[2]['category']);
        $this->assertEquals(new Money(13196, new Currency('GBP')),                   $products[2]['total_value']);
        $this->assertEquals(new Money(1320, new Currency('GBP')),                    $products[2]['total_discount']);
        $this->assertEquals(new Money(2796, new Currency('GBP')),                    $products[2]['total_delivery']);
        $this->assertEquals(new Money(2375, new Currency('GBP')),                    $products[2]['total_tax']);
        $this->assertEquals(new Money(14672, new Currency('GBP')),                   $products[2]['subtotal']);
        $this->assertEquals(new Money(17047, new Currency('GBP')),                   $products[2]['total']);
    }

    /** @test */
    public function should_process_basket_fixture_eight()
    {
        $order    = $this->processor->process($this->fixtures->eight());
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',         $order);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $meta['delivery']);
        $this->assertEquals(new Money(10000, new Currency('GBP')),  $meta['discount']);
        $this->assertEquals(5,                                      $meta['products_count']);
        $this->assertEquals(new Money(119996, new Currency('GBP')), $meta['subtotal']);
        $this->assertEquals(5,                                      $meta['taxable']);
        $this->assertEquals(new Money(23999, new Currency('GBP')),  $meta['tax']);
        $this->assertEquals(new Money(143995, new Currency('GBP')), $meta['total']);
        $this->assertEquals(new Money(130495, new Currency('GBP')), $meta['value']);
        $this->assertEquals('2',                                    $products[0]['sku']);
        $this->assertEquals('Kindle',                               $products[0]['name']);
        $this->assertEquals(new Money(9999, new Currency('GBP')),   $products[0]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,         $products[0]['rate']);
        $this->assertEquals(3,                                      $products[0]['quantity']);
        $this->assertEquals(false,                                  $products[0]['freebie']);
        $this->assertEquals(true,                                   $products[0]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['delivery']);
        $this->assertEquals(new Collection,                         $products[0]['coupons']);
        $this->assertEquals(new Collection,                         $products[0]['tags']);
        $this->assertEquals(null,                                   $products[0]['discounts']->first());
        $this->assertEquals(null,                                   $products[0]['category']);
        $this->assertEquals(new Money(29997, new Currency('GBP')),  $products[0]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[0]['total_delivery']);
        $this->assertEquals(new Money(5999, new Currency('GBP')),   $products[0]['total_tax']);
        $this->assertEquals(new Money(29997, new Currency('GBP')),  $products[0]['subtotal']);
        $this->assertEquals(new Money(35996, new Currency('GBP')),  $products[0]['total']);
        $this->assertEquals('3',                                    $products[1]['sku']);
        $this->assertEquals('iPhone case',                          $products[1]['name']);
        $this->assertEquals(new Money(499, new Currency('GBP')),    $products[1]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,         $products[1]['rate']);
        $this->assertEquals(1,                                      $products[1]['quantity']);
        $this->assertEquals(true,                                   $products[1]['freebie']);
        $this->assertEquals(true,                                   $products[1]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[1]['delivery']);
        $this->assertEquals(new Collection,                         $products[1]['coupons']);
        $this->assertEquals(new Collection,                         $products[1]['tags']);
        $this->assertEquals(null,                                   $products[1]['discounts']->first());
        $this->assertEquals(null,                                   $products[1]['category']);
        $this->assertEquals(new Money(499, new Currency('GBP')),    $products[1]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[1]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[1]['total_delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[1]['total_tax']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[1]['subtotal']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[1]['total']);
        $this->assertEquals('4',                                    $products[2]['sku']);
        $this->assertEquals('MacBook Air',                          $products[2]['name']);
        $this->assertEquals(new Money(99999, new Currency('GBP')),  $products[2]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,         $products[2]['rate']);
        $this->assertEquals(1,                                      $products[2]['quantity']);
        $this->assertEquals(false,                                  $products[2]['freebie']);
        $this->assertEquals(true,                                   $products[2]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[2]['delivery']);
        $this->assertEquals(new Collection,                         $products[2]['coupons']);
        $this->assertEquals(new Collection,                         $products[2]['tags']);
        $this->assertEquals(new PercentageDiscount(10),             $products[2]['discounts']->first());
        $this->assertEquals(null,                                   $products[2]['category']);
        $this->assertEquals(new Money(99999, new Currency('GBP')),  $products[2]['total_value']);
        $this->assertEquals(new Money(10000, new Currency('GBP')),  $products[2]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),      $products[2]['total_delivery']);
        $this->assertEquals(new Money(18000, new Currency('GBP')),  $products[2]['total_tax']);
        $this->assertEquals(new Money(89999, new Currency('GBP')),  $products[2]['subtotal']);
        $this->assertEquals(new Money(107999, new Currency('GBP')), $products[2]['total']);
    }

    /** @test */
    public function should_process_basket_fixture_nine()
    {
        $order    = $this->processor->process($this->fixtures->nine());
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',                          $order);
        $this->assertEquals(new Money(1495, new Currency('GBP')),                    $meta['delivery']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),                    $meta['discount']);
        $this->assertEquals(7,                                                       $meta['products_count']);
        $this->assertEquals(new Money(13943, new Currency('GBP')),                   $meta['subtotal']);
        $this->assertEquals(5,                                                       $meta['taxable']);
        $this->assertEquals(new Money(890, new Currency('GBP')),                     $meta['tax']);
        $this->assertEquals(new Money(14833, new Currency('GBP')),                   $meta['total']);
        $this->assertEquals(new Money(21448, new Currency('GBP')),                   $meta['value']);
        $this->assertEquals('0',                                                     $products[0]['sku']);
        $this->assertEquals('Back to the Future Blu-ray',                            $products[0]['name']);
        $this->assertEquals(new Money(1000, new Currency('GBP')),                    $products[0]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,                          $products[0]['rate']);
        $this->assertEquals(1,                                                       $products[0]['quantity']);
        $this->assertEquals(false,                                                   $products[0]['freebie']);
        $this->assertEquals(true,                                                    $products[0]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[0]['delivery']);
        $this->assertEquals(new Collection,                                          $products[0]['coupons']);
        $this->assertEquals(new Collection,                                          $products[0]['tags']);
        $this->assertEquals(null,                                                    $products[0]['discounts']->first());
        $this->assertEquals(null,                                                    $products[0]['category']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[0]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[0]['total_delivery']);
        $this->assertEquals(new Money(200, new Currency('GBP')),                     $products[0]['total_tax']);
        $this->assertEquals(new Money(1000, new Currency('GBP')),                    $products[0]['subtotal']);
        $this->assertEquals(new Money(1200, new Currency('GBP')),                    $products[0]['total']);
        $this->assertEquals('5',                                                     $products[1]['sku']);
        $this->assertEquals('Sega Mega Drive',                                       $products[1]['name']);
        $this->assertEquals(new Money(4950, new Currency('GBP')),                    $products[1]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,                          $products[1]['rate']);
        $this->assertEquals(1,                                                       $products[1]['quantity']);
        $this->assertEquals(false,                                                   $products[1]['freebie']);
        $this->assertEquals(true,                                                    $products[1]['taxable']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[1]['delivery']);
        $this->assertEquals(new Collection,                                          $products[1]['coupons']);
        $this->assertEquals(new Collection,                                          $products[1]['tags']);
        $this->assertEquals(new ValueDiscount(new Money(1500, new Currency('GBP'))), $products[1]['discounts']->first());
        $this->assertEquals(null,                                                    $products[1]['category']);
        $this->assertEquals(new Money(4950, new Currency('GBP')),                    $products[1]['total_value']);
        $this->assertEquals(new Money(1500, new Currency('GBP')),                    $products[1]['total_discount']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[1]['total_delivery']);
        $this->assertEquals(new Money(690, new Currency('GBP')),                     $products[1]['total_tax']);
        $this->assertEquals(new Money(3450, new Currency('GBP')),                    $products[1]['subtotal']);
        $this->assertEquals(new Money(4140, new Currency('GBP')),                    $products[1]['total']);
        $this->assertEquals('8',                                                     $products[2]['sku']);
        $this->assertEquals('Junior Jordans',                                        $products[2]['name']);
        $this->assertEquals(new Money(3999, new Currency('GBP')),                    $products[2]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,                          $products[2]['rate']);
        $this->assertEquals(2,                                                       $products[2]['quantity']);
        $this->assertEquals(false,                                                   $products[2]['freebie']);
        $this->assertEquals(false,                                                   $products[2]['taxable']);
        $this->assertEquals(new Money(599, new Currency('GBP')),                     $products[2]['delivery']);
        $this->assertEquals(new Collection,                                          $products[2]['coupons']);
        $this->assertEquals(new Collection,                                          $products[2]['tags']);
        $this->assertEquals(null,                                                    $products[2]['discounts']->first());
        $this->assertEquals(null,                                                    $products[2]['category']);
        $this->assertEquals(new Money(7998, new Currency('GBP')),                    $products[2]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[2]['total_discount']);
        $this->assertEquals(new Money(1198, new Currency('GBP')),                    $products[2]['total_delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[2]['total_tax']);
        $this->assertEquals(new Money(9196, new Currency('GBP')),                    $products[2]['subtotal']);
        $this->assertEquals(new Money(9196, new Currency('GBP')),                    $products[2]['total']);
        $this->assertEquals('9',                                                     $products[3]['sku']);
        $this->assertEquals('Gift Card',                                             $products[3]['name']);
        $this->assertEquals(new Money(2500, new Currency('GBP')),                    $products[3]['price']);
        $this->assertEquals(new UnitedKingdomValueAddedTax,                          $products[3]['rate']);
        $this->assertEquals(3,                                                       $products[3]['quantity']);
        $this->assertEquals(true,                                                    $products[3]['freebie']);
        $this->assertEquals(true,                                                    $products[3]['taxable']);
        $this->assertEquals(new Money(99, new Currency('GBP')),                      $products[3]['delivery']);
        $this->assertEquals(new Collection,                                          $products[3]['coupons']);
        $this->assertEquals(new Collection,                                          $products[3]['tags']);
        $this->assertEquals(null,                                                    $products[3]['discounts']->first());
        $this->assertEquals(null,                                                    $products[3]['category']);
        $this->assertEquals(new Money(7500, new Currency('GBP')),                    $products[3]['total_value']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[3]['total_discount']);
        $this->assertEquals(new Money(297, new Currency('GBP')),                     $products[3]['total_delivery']);
        $this->assertEquals(new Money(0, new Currency('GBP')),                       $products[3]['total_tax']);
        $this->assertEquals(new Money(297, new Currency('GBP')),                     $products[3]['subtotal']);
        $this->assertEquals(new Money(297, new Currency('GBP')),                     $products[3]['total']);
    }

    /** @test */
    public function should_process_basket_fixture_ten()
    {
        $basket   = $this->fixtures->ten();
        $basket->discount(new PercentageDiscount(20));

        $order    = $this->processor->process($basket);
        $meta     = $order->meta();
        $products = $order->products();

        $this->assertInstanceOf('PhilipBrown\Basket\Order',             $order);
        $this->assertEquals(new Money(20200, new Currency('GBP')),      $meta['discount']);
        $this->assertEquals(new Money(96959, new Currency('GBP')),      $meta['total']);
        $this->assertEquals(new Money(100999, new Currency('GBP')),     $meta['value']);
        $this->assertEquals('0',                                        $products[0]['sku']);
        $this->assertEquals(new PercentageDiscount(20),                 $products[0]['discounts']->first());
        $this->assertEquals(new Money(1000, new Currency('GBP')),       $products[0]['total_value']);
        $this->assertEquals(new Money(200, new Currency('GBP')),        $products[0]['total_discount']);
        $this->assertEquals(new Money(960, new Currency('GBP')),        $products[0]['total']);
        $this->assertEquals('4',                                        $products[1]['sku']);
        $this->assertEquals(new PercentageDiscount(20),                 $products[1]['discounts']->first());
        $this->assertEquals(new Money(99999, new Currency('GBP')),      $products[1]['total_value']);
        $this->assertEquals(new Money(20000, new Currency('GBP')),      $products[1]['total_discount']);
        $this->assertEquals(new Money(95999, new Currency('GBP')),      $products[1]['total']);
    }
}
