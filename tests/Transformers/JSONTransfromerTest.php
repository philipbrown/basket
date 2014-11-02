<?php namespace PhilipBrown\Basket\Tests\Transformers;

use PhilipBrown\Basket\Processor;
use PhilipBrown\Basket\Converter;
use PhilipBrown\Basket\MetaData\TaxMetaData;
use PhilipBrown\Basket\Fixtures\BasketFixture;
use PhilipBrown\Basket\MetaData\ValueMetaData;
use PhilipBrown\Basket\MetaData\TotalMetaData;
use PhilipBrown\Basket\MetaData\TaxableMetaData;
use PhilipBrown\Basket\MetaData\DeliveryMetaData;
use PhilipBrown\Basket\MetaData\DiscountMetaData;
use PhilipBrown\Basket\MetaData\SubtotalMetaData;
use PhilipBrown\Basket\MetaData\ProductsMetaData;
use PhilipBrown\Basket\Transformers\JSONTransformer;
use PhilipBrown\Basket\Reconcilers\DefaultReconciler;

class JSONTransfromerTest extends \PHPUnit_Framework_TestCase
{
    /** @var JSONTransformer */
    private $transformer;

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

        $this->fixtures    = new BasketFixture;
        $this->processor   = new Processor($reconciler, $calculators);
        $this->transformer = new JSONTransformer(new Converter);
    }

    /** @test */
    public function should_transform_basket_fixture_zero()
    {
        $order   = $this->processor->process($this->fixtures->zero());
        $payload = json_decode($this->transformer->transform($order));

        $this->assertTrue(is_object($payload));
        $this->assertEquals('£0.00',                      $payload->delivery);
        $this->assertEquals('£0.00',                      $payload->discount);
        $this->assertEquals(1,                            $payload->products_count);
        $this->assertEquals('£10.00',                     $payload->subtotal);
        $this->assertEquals(1,                            $payload->taxable);
        $this->assertEquals('£10.00',                     $payload->subtotal);
        $this->assertEquals('£12.00',                     $payload->total);
        $this->assertEquals('£10.00',                     $payload->value);
        $this->assertEquals('0',                          $payload->products[0]->sku);
        $this->assertEquals('Back to the Future Blu-ray', $payload->products[0]->name);
        $this->assertEquals('£10.00',                     $payload->products[0]->price);
        $this->assertEquals('20%',                        $payload->products[0]->rate);
        $this->assertEquals(1,                            $payload->products[0]->quantity);
        $this->assertEquals(false,                        $payload->products[0]->freebie);
        $this->assertEquals(true,                         $payload->products[0]->taxable);
        $this->assertEquals('£0.00',                      $payload->products[0]->delivery);
        $this->assertEquals([],                           $payload->products[0]->coupons);
        $this->assertEquals([],                           $payload->products[0]->tags);
        $this->assertEquals(null,                         $payload->products[0]->discount);
        $this->assertEquals(null,                         $payload->products[0]->category);
        $this->assertEquals('£10.00',                     $payload->products[0]->total_value);
        $this->assertEquals('£0.00',                      $payload->products[0]->total_discount);
        $this->assertEquals('£0.00',                      $payload->products[0]->total_delivery);
        $this->assertEquals('£2.00',                      $payload->products[0]->total_tax);
        $this->assertEquals('£10.00',                     $payload->products[0]->subtotal);
        $this->assertEquals('£12.00',                     $payload->products[0]->total);
    }

    /** @test */
    public function should_transform_basket_fixture_one()
    {
        $order   = $this->processor->process($this->fixtures->one());
        $payload = json_decode($this->transformer->transform($order));

        $this->assertTrue(is_object($payload));
        $this->assertEquals('£0.00',                $payload->delivery);
        $this->assertEquals('£0.00',                $payload->discount);
        $this->assertEquals(4,                      $payload->products_count);
        $this->assertEquals('£314.97',              $payload->subtotal);
        $this->assertEquals(3,                      $payload->taxable);
        $this->assertEquals('£59.99',               $payload->tax);
        $this->assertEquals('£374.96',              $payload->total);
        $this->assertEquals('£314.97',              $payload->value);
        $this->assertEquals('1',                    $payload->products[0]->sku);
        $this->assertEquals('The 4-Hour Work Week', $payload->products[0]->name);
        $this->assertEquals('£15.00',               $payload->products[0]->price);
        $this->assertEquals('20%',                  $payload->products[0]->rate);
        $this->assertEquals(1,                      $payload->products[0]->quantity);
        $this->assertEquals(false,                  $payload->products[0]->freebie);
        $this->assertEquals(false,                  $payload->products[0]->taxable);
        $this->assertEquals('£0.00',                $payload->products[0]->delivery);
        $this->assertEquals([],                     $payload->products[0]->coupons);
        $this->assertEquals([],                     $payload->products[0]->tags);
        $this->assertEquals(null,                   $payload->products[0]->discount);
        $this->assertEquals('Physical Book',        $payload->products[0]->category);
        $this->assertEquals('£15.00',               $payload->products[0]->total_value);
        $this->assertEquals('£0.00',                $payload->products[0]->total_discount);
        $this->assertEquals('£0.00',                $payload->products[0]->total_delivery);
        $this->assertEquals('£0.00',                $payload->products[0]->total_tax);
        $this->assertEquals('£15.00',               $payload->products[0]->subtotal);
        $this->assertEquals('£15.00',               $payload->products[0]->total);
        $this->assertEquals('2',                    $payload->products[1]->sku);
        $this->assertEquals('Kindle',               $payload->products[1]->name);
        $this->assertEquals('£99.99',               $payload->products[1]->price);
        $this->assertEquals('20%',                  $payload->products[1]->rate);
        $this->assertEquals(3,                      $payload->products[1]->quantity);
        $this->assertEquals(false,                  $payload->products[1]->freebie);
        $this->assertEquals(true,                   $payload->products[1]->taxable);
        $this->assertEquals('£0.00',                $payload->products[1]->delivery);
        $this->assertEquals([],                     $payload->products[1]->coupons);
        $this->assertEquals([],                     $payload->products[1]->tags);
        $this->assertEquals(null,                   $payload->products[1]->discount);
        $this->assertEquals(null,                   $payload->products[1]->category);
        $this->assertEquals('£299.97',              $payload->products[1]->total_value);
        $this->assertEquals('£0.00',                $payload->products[1]->total_discount);
        $this->assertEquals('£0.00',                $payload->products[1]->total_delivery);
        $this->assertEquals('£59.99',               $payload->products[1]->total_tax);
        $this->assertEquals('£299.97',              $payload->products[1]->subtotal);
        $this->assertEquals('£359.96',              $payload->products[1]->total);
    }

    /** @test */
    public function should_transform_basket_fixture_two()
    {
        $order   = $this->processor->process($this->fixtures->two());
        $payload = json_decode($this->transformer->transform($order));

        $this->assertTrue(is_object($payload));
        $this->assertEquals('£0.00',       $payload->delivery);
        $this->assertEquals('£100.00',     $payload->discount);
        $this->assertEquals(2,             $payload->products_count);
        $this->assertEquals('£899.99',     $payload->subtotal);
        $this->assertEquals(2,             $payload->taxable);
        $this->assertEquals('£180.00',     $payload->tax);
        $this->assertEquals('£1,079.99',   $payload->total);
        $this->assertEquals('£1,004.98',   $payload->value);
        $this->assertEquals('3',           $payload->products[0]->sku);
        $this->assertEquals('iPhone case', $payload->products[0]->name);
        $this->assertEquals('£4.99',       $payload->products[0]->price);
        $this->assertEquals('20%',         $payload->products[0]->rate);
        $this->assertEquals(1,             $payload->products[0]->quantity);
        $this->assertEquals(true,          $payload->products[0]->freebie);
        $this->assertEquals(true,          $payload->products[0]->taxable);
        $this->assertEquals('£0.00',       $payload->products[0]->delivery);
        $this->assertEquals([],            $payload->products[0]->coupons);
        $this->assertEquals([],            $payload->products[0]->tags);
        $this->assertEquals(null,          $payload->products[0]->discount);
        $this->assertEquals(null,          $payload->products[0]->category);
        $this->assertEquals('£4.99',       $payload->products[0]->total_value);
        $this->assertEquals('£0.00',       $payload->products[0]->total_discount);
        $this->assertEquals('£0.00',       $payload->products[0]->total_delivery);
        $this->assertEquals('£0.00',       $payload->products[0]->total_tax);
        $this->assertEquals('£0.00',       $payload->products[0]->subtotal);
        $this->assertEquals('£0.00',       $payload->products[0]->total);
        $this->assertEquals('4',           $payload->products[1]->sku);
        $this->assertEquals('MacBook Air', $payload->products[1]->name);
        $this->assertEquals('£999.99',     $payload->products[1]->price);
        $this->assertEquals('20%',         $payload->products[1]->rate);
        $this->assertEquals(1,             $payload->products[1]->quantity);
        $this->assertEquals(false,         $payload->products[1]->freebie);
        $this->assertEquals(true,          $payload->products[1]->taxable);
        $this->assertEquals('£0.00',       $payload->products[1]->delivery);
        $this->assertEquals([],            $payload->products[1]->coupons);
        $this->assertEquals([],            $payload->products[1]->tags);
        $this->assertEquals('10%',         $payload->products[1]->discount);
        $this->assertEquals(null,          $payload->products[1]->category);
        $this->assertEquals('£999.99',     $payload->products[1]->total_value);
        $this->assertEquals('£100.00',     $payload->products[1]->total_discount);
        $this->assertEquals('£0.00',       $payload->products[1]->total_delivery);
        $this->assertEquals('£180.00',     $payload->products[1]->total_tax);
        $this->assertEquals('£899.99',     $payload->products[1]->subtotal);
        $this->assertEquals('£1,079.99',   $payload->products[1]->total);
    }

    /** @test */
    public function should_transform_basket_fixture_three()
    {
        $order   = $this->processor->process($this->fixtures->three());
        $payload = json_decode($this->transformer->transform($order));

        $this->assertTrue(is_object($payload));
        $this->assertEquals('£60.00',          $payload->delivery);
        $this->assertEquals('£115.00',         $payload->discount);
        $this->assertEquals(3,                 $payload->products_count);
        $this->assertEquals('£1,894.48',       $payload->subtotal);
        $this->assertEquals(3,                 $payload->taxable);
        $this->assertEquals('£366.90',         $payload->tax);
        $this->assertEquals('£2,261.38',       $payload->total);
        $this->assertEquals('£1,949.48',       $payload->value);
        $this->assertEquals('4',               $payload->products[0]->sku);
        $this->assertEquals('MacBook Air',     $payload->products[0]->name);
        $this->assertEquals('£999.99',         $payload->products[0]->price);
        $this->assertEquals('20%',             $payload->products[0]->rate);
        $this->assertEquals(1,                 $payload->products[0]->quantity);
        $this->assertEquals(false,             $payload->products[0]->freebie);
        $this->assertEquals(true,              $payload->products[0]->taxable);
        $this->assertEquals('£0.00',           $payload->products[0]->delivery);
        $this->assertEquals([],                $payload->products[0]->coupons);
        $this->assertEquals([],                $payload->products[0]->tags);
        $this->assertEquals('10%',             $payload->products[0]->discount);
        $this->assertEquals(null,              $payload->products[0]->category);
        $this->assertEquals('£999.99',         $payload->products[0]->total_value);
        $this->assertEquals('£100.00',         $payload->products[0]->total_discount);
        $this->assertEquals('£0.00',           $payload->products[0]->total_delivery);
        $this->assertEquals('£180.00',         $payload->products[0]->total_tax);
        $this->assertEquals('£899.99',         $payload->products[0]->subtotal);
        $this->assertEquals('£1,079.99',       $payload->products[0]->total);
        $this->assertEquals('5',               $payload->products[1]->sku);
        $this->assertEquals('Sega Mega Drive', $payload->products[1]->name);
        $this->assertEquals('£49.50',          $payload->products[1]->price);
        $this->assertEquals('20%',             $payload->products[1]->rate);
        $this->assertEquals(1,                 $payload->products[1]->quantity);
        $this->assertEquals(false,             $payload->products[1]->freebie);
        $this->assertEquals(true,              $payload->products[1]->taxable);
        $this->assertEquals('£0.00',           $payload->products[1]->delivery);
        $this->assertEquals([],                $payload->products[1]->coupons);
        $this->assertEquals([],                $payload->products[1]->tags);
        $this->assertEquals('£15.00',          $payload->products[1]->discount);
        $this->assertEquals(null,              $payload->products[1]->category);
        $this->assertEquals('£49.50',          $payload->products[1]->total_value);
        $this->assertEquals('£15.00',          $payload->products[1]->total_discount);
        $this->assertEquals('£0.00',           $payload->products[1]->total_delivery);
        $this->assertEquals('£6.90',           $payload->products[1]->total_tax);
        $this->assertEquals('£34.50',          $payload->products[1]->subtotal);
        $this->assertEquals('£41.40',          $payload->products[1]->total);
        $this->assertEquals('6',               $payload->products[2]->sku);
        $this->assertEquals('Aeron Chair',     $payload->products[2]->name);
        $this->assertEquals('£899.99',         $payload->products[2]->price);
        $this->assertEquals('20%',             $payload->products[2]->rate);
        $this->assertEquals(1,                 $payload->products[2]->quantity);
        $this->assertEquals(false,             $payload->products[2]->freebie);
        $this->assertEquals(true,              $payload->products[2]->taxable);
        $this->assertEquals('£60.00',          $payload->products[2]->delivery);
        $this->assertEquals([],                $payload->products[2]->coupons);
        $this->assertEquals([],                $payload->products[2]->tags);
        $this->assertEquals(null,              $payload->products[2]->discount);
        $this->assertEquals(null,              $payload->products[2]->category);
        $this->assertEquals('£899.99',         $payload->products[2]->total_value);
        $this->assertEquals('£0.00',           $payload->products[2]->total_discount);
        $this->assertEquals('£60.00',          $payload->products[2]->total_delivery);
        $this->assertEquals('£180.00',         $payload->products[2]->total_tax);
        $this->assertEquals('£959.99',         $payload->products[2]->subtotal);
        $this->assertEquals('£1,139.99',       $payload->products[2]->total);
    }

    /** @test */
    public function should_transform_basket_fixture_four()
    {
        $order   = $this->processor->process($this->fixtures->four());
        $payload = json_decode($this->transformer->transform($order));

        $this->assertTrue(is_object($payload));
        $this->assertEquals('£39.94',         $payload->delivery);
        $this->assertEquals('£13.20',         $payload->discount);
        $this->assertEquals(6,                $payload->products_count);
        $this->assertEquals('£238.68',        $payload->subtotal);
        $this->assertEquals(4,                $payload->taxable);
        $this->assertEquals('£23.75',         $payload->tax);
        $this->assertEquals('£262.43',        $payload->total);
        $this->assertEquals('£211.94',        $payload->value);
        $this->assertEquals('7',              $payload->products[0]->sku);
        $this->assertEquals('Kettlebell',     $payload->products[0]->name);
        $this->assertEquals('£32.99',         $payload->products[0]->price);
        $this->assertEquals('20%',            $payload->products[0]->rate);
        $this->assertEquals(4,                $payload->products[0]->quantity);
        $this->assertEquals(false,            $payload->products[0]->freebie);
        $this->assertEquals(true,             $payload->products[0]->taxable);
        $this->assertEquals('£6.99',          $payload->products[0]->delivery);
        $this->assertEquals([],               $payload->products[0]->coupons);
        $this->assertEquals([],               $payload->products[0]->tags);
        $this->assertEquals('10%',            $payload->products[0]->discount);
        $this->assertEquals(null,             $payload->products[0]->category);
        $this->assertEquals('£131.96',        $payload->products[0]->total_value);
        $this->assertEquals('£13.20',         $payload->products[0]->total_discount);
        $this->assertEquals('£27.96',         $payload->products[0]->total_delivery);
        $this->assertEquals('£23.75',         $payload->products[0]->total_tax);
        $this->assertEquals('£146.72',        $payload->products[0]->subtotal);
        $this->assertEquals('£170.47',        $payload->products[0]->total);
        $this->assertEquals('8',              $payload->products[1]->sku);
        $this->assertEquals('Junior Jordans', $payload->products[1]->name);
        $this->assertEquals('£39.99',         $payload->products[1]->price);
        $this->assertEquals('20%',            $payload->products[1]->rate);
        $this->assertEquals(2,                $payload->products[1]->quantity);
        $this->assertEquals(false,            $payload->products[1]->freebie);
        $this->assertEquals(false,            $payload->products[1]->taxable);
        $this->assertEquals('£5.99',          $payload->products[1]->delivery);
        $this->assertEquals([],               $payload->products[1]->coupons);
        $this->assertEquals([],               $payload->products[1]->tags);
        $this->assertEquals(null,             $payload->products[1]->discount);
        $this->assertEquals(null,             $payload->products[1]->category);
        $this->assertEquals('£79.98',         $payload->products[1]->total_value);
        $this->assertEquals('£0.00',          $payload->products[1]->total_discount);
        $this->assertEquals('£11.98',         $payload->products[1]->total_delivery);
        $this->assertEquals('£0.00',          $payload->products[1]->total_tax);
        $this->assertEquals('£91.96',         $payload->products[1]->subtotal);
        $this->assertEquals('£91.96',         $payload->products[1]->total);
    }

    /** @test */
    public function should_transform_basket_fixture_five()
    {
        $order   = $this->processor->process($this->fixtures->five());
        $payload = json_decode($this->transformer->transform($order));

        $this->assertTrue(is_object($payload));
        $this->assertEquals('£2.97',                $payload->delivery);
        $this->assertEquals('£100.00',              $payload->discount);
        $this->assertEquals(5,                      $payload->products_count);
        $this->assertEquals('£917.96',              $payload->subtotal);
        $this->assertEquals(4,                      $payload->taxable);
        $this->assertEquals('£180.00',              $payload->tax);
        $this->assertEquals('£1,097.96',            $payload->total);
        $this->assertEquals('£1,089.99',            $payload->value);
        $this->assertEquals('1',                    $payload->products[0]->sku);
        $this->assertEquals('The 4-Hour Work Week', $payload->products[0]->name);
        $this->assertEquals('£15.00',               $payload->products[0]->price);
        $this->assertEquals('20%',                  $payload->products[0]->rate);
        $this->assertEquals(1,                      $payload->products[0]->quantity);
        $this->assertEquals(false,                  $payload->products[0]->freebie);
        $this->assertEquals(false,                  $payload->products[0]->taxable);
        $this->assertEquals('£0.00',                $payload->products[0]->delivery);
        $this->assertEquals([],                     $payload->products[0]->coupons);
        $this->assertEquals([],                     $payload->products[0]->tags);
        $this->assertEquals(null,                   $payload->products[0]->discount);
        $this->assertEquals('Physical Book',        $payload->products[0]->category);
        $this->assertEquals('£15.00',               $payload->products[0]->total_value);
        $this->assertEquals('£0.00',                $payload->products[0]->total_discount);
        $this->assertEquals('£0.00',                $payload->products[0]->total_delivery);
        $this->assertEquals('£0.00',                $payload->products[0]->total_tax);
        $this->assertEquals('£15.00',               $payload->products[0]->subtotal);
        $this->assertEquals('£15.00',               $payload->products[0]->total);
        $this->assertEquals('4',                    $payload->products[1]->sku);
        $this->assertEquals('MacBook Air',          $payload->products[1]->name);
        $this->assertEquals('£999.99',              $payload->products[1]->price);
        $this->assertEquals('20%',                  $payload->products[1]->rate);
        $this->assertEquals(1,                      $payload->products[1]->quantity);
        $this->assertEquals(false,                  $payload->products[1]->freebie);
        $this->assertEquals(true,                   $payload->products[1]->taxable);
        $this->assertEquals('£0.00',                $payload->products[1]->delivery);
        $this->assertEquals([],                     $payload->products[1]->coupons);
        $this->assertEquals([],                     $payload->products[1]->tags);
        $this->assertEquals('10%',                  $payload->products[1]->discount);
        $this->assertEquals(null,                   $payload->products[1]->category);
        $this->assertEquals('£999.99',              $payload->products[1]->total_value);
        $this->assertEquals('£100.00',              $payload->products[1]->total_discount);
        $this->assertEquals('£0.00',                $payload->products[1]->total_delivery);
        $this->assertEquals('£180.00',              $payload->products[1]->total_tax);
        $this->assertEquals('£899.99',              $payload->products[1]->subtotal);
        $this->assertEquals('£1,079.99',            $payload->products[1]->total);
        $this->assertEquals('9',                    $payload->products[2]->sku);
        $this->assertEquals('Gift Card',            $payload->products[2]->name);
        $this->assertEquals('£25.00',               $payload->products[2]->price);
        $this->assertEquals('20%',                  $payload->products[2]->rate);
        $this->assertEquals(3,                      $payload->products[2]->quantity);
        $this->assertEquals(true,                   $payload->products[2]->freebie);
        $this->assertEquals(true,                   $payload->products[2]->taxable);
        $this->assertEquals('£0.99',                $payload->products[2]->delivery);
        $this->assertEquals([],                     $payload->products[2]->coupons);
        $this->assertEquals([],                     $payload->products[2]->tags);
        $this->assertEquals(null,                   $payload->products[2]->discount);
        $this->assertEquals(null,                   $payload->products[2]->category);
        $this->assertEquals('£75.00',               $payload->products[2]->total_value);
        $this->assertEquals('£0.00',                $payload->products[2]->total_discount);
        $this->assertEquals('£2.97',                $payload->products[2]->total_delivery);
        $this->assertEquals('£0.00',                $payload->products[2]->total_tax);
        $this->assertEquals('£2.97',                $payload->products[2]->subtotal);
        $this->assertEquals('£2.97',                $payload->products[2]->total);
    }

    /** @test */
    public function should_transform_basket_fixture_six()
    {
        $order   = $this->processor->process($this->fixtures->six());
        $payload = json_decode($this->transformer->transform($order));

        $this->assertTrue(is_object($payload));
        $this->assertEquals('£27.96',                     $payload->delivery);
        $this->assertEquals('£13.20',                     $payload->discount);
        $this->assertEquals(6,                            $payload->products_count);
        $this->assertEquals('£156.72',                    $payload->subtotal);
        $this->assertEquals(6,                            $payload->taxable);
        $this->assertEquals('£25.75',                     $payload->tax);
        $this->assertEquals('£182.47',                    $payload->total);
        $this->assertEquals('£146.95',                    $payload->value);
        $this->assertEquals('0',                          $payload->products[0]->sku);
        $this->assertEquals('Back to the Future Blu-ray', $payload->products[0]->name);
        $this->assertEquals('£10.00',                     $payload->products[0]->price);
        $this->assertEquals('20%',                        $payload->products[0]->rate);
        $this->assertEquals(1,                            $payload->products[0]->quantity);
        $this->assertEquals(false,                        $payload->products[0]->freebie);
        $this->assertEquals(true,                         $payload->products[0]->taxable);
        $this->assertEquals('£0.00',                      $payload->products[0]->delivery);
        $this->assertEquals([],                           $payload->products[0]->coupons);
        $this->assertEquals([],                           $payload->products[0]->tags);
        $this->assertEquals(null,                         $payload->products[0]->discount);
        $this->assertEquals(null,                         $payload->products[0]->category);
        $this->assertEquals('£10.00',                     $payload->products[0]->total_value);
        $this->assertEquals('£0.00',                      $payload->products[0]->total_discount);
        $this->assertEquals('£0.00',                      $payload->products[0]->total_delivery);
        $this->assertEquals('£2.00',                      $payload->products[0]->total_tax);
        $this->assertEquals('£10.00',                     $payload->products[0]->subtotal);
        $this->assertEquals('£12.00',                     $payload->products[0]->total);
        $this->assertEquals('3',                          $payload->products[1]->sku);
        $this->assertEquals('iPhone case',                $payload->products[1]->name);
        $this->assertEquals('£4.99',                      $payload->products[1]->price);
        $this->assertEquals('20%',                        $payload->products[1]->rate);
        $this->assertEquals(1,                            $payload->products[1]->quantity);
        $this->assertEquals(true,                         $payload->products[1]->freebie);
        $this->assertEquals(true,                         $payload->products[1]->taxable);
        $this->assertEquals('£0.00',                      $payload->products[1]->delivery);
        $this->assertEquals([],                           $payload->products[1]->coupons);
        $this->assertEquals([],                           $payload->products[1]->tags);
        $this->assertEquals(null,                         $payload->products[1]->discount);
        $this->assertEquals(null,                         $payload->products[1]->category);
        $this->assertEquals('£4.99',                      $payload->products[1]->total_value);
        $this->assertEquals('£0.00',                      $payload->products[1]->total_discount);
        $this->assertEquals('£0.00',                      $payload->products[1]->total_delivery);
        $this->assertEquals('£0.00',                      $payload->products[1]->total_tax);
        $this->assertEquals('£0.00',                      $payload->products[1]->subtotal);
        $this->assertEquals('£0.00',                      $payload->products[1]->total);
        $this->assertEquals('7',                          $payload->products[2]->sku);
        $this->assertEquals('Kettlebell',                 $payload->products[2]->name);
        $this->assertEquals('£32.99',                     $payload->products[2]->price);
        $this->assertEquals('20%',                        $payload->products[2]->rate);
        $this->assertEquals(4,                            $payload->products[2]->quantity);
        $this->assertEquals(false,                        $payload->products[2]->freebie);
        $this->assertEquals(true,                         $payload->products[2]->taxable);
        $this->assertEquals('£6.99',                      $payload->products[2]->delivery);
        $this->assertEquals([],                           $payload->products[2]->coupons);
        $this->assertEquals([],                           $payload->products[2]->tags);
        $this->assertEquals('10%',                        $payload->products[2]->discount);
        $this->assertEquals(null,                         $payload->products[2]->category);
        $this->assertEquals('£131.96',                    $payload->products[2]->total_value);
        $this->assertEquals('£13.20',                     $payload->products[2]->total_discount);
        $this->assertEquals('£27.96',                     $payload->products[2]->total_delivery);
        $this->assertEquals('£23.75',                     $payload->products[2]->total_tax);
        $this->assertEquals('£146.72',                    $payload->products[2]->subtotal);
        $this->assertEquals('£170.47',                    $payload->products[2]->total);
    }

    /** @test */
    public function should_transform_basket_fixture_seven()
    {
        $order   = $this->processor->process($this->fixtures->seven());
        $payload = json_decode($this->transformer->transform($order));

        $this->assertTrue(is_object($payload));
        $this->assertEquals('£87.96',          $payload->delivery);
        $this->assertEquals('£28.20',          $payload->discount);
        $this->assertEquals(6,                 $payload->products_count);
        $this->assertEquals('£1,141.21',       $payload->subtotal);
        $this->assertEquals(6,                 $payload->taxable);
        $this->assertEquals('£210.65',         $payload->tax);
        $this->assertEquals('£1,351.86',       $payload->total);
        $this->assertEquals('£1,081.45',       $payload->value);
        $this->assertEquals('5',               $payload->products[0]->sku);
        $this->assertEquals('Sega Mega Drive', $payload->products[0]->name);
        $this->assertEquals('£49.50',          $payload->products[0]->price);
        $this->assertEquals('20%',             $payload->products[0]->rate);
        $this->assertEquals(1,                 $payload->products[0]->quantity);
        $this->assertEquals(false,             $payload->products[0]->freebie);
        $this->assertEquals(true,              $payload->products[0]->taxable);
        $this->assertEquals('£0.00',           $payload->products[0]->delivery);
        $this->assertEquals([],                $payload->products[0]->coupons);
        $this->assertEquals([],                $payload->products[0]->tags);
        $this->assertEquals('£15.00',          $payload->products[0]->discount);
        $this->assertEquals(null,              $payload->products[0]->category);
        $this->assertEquals('£49.50',          $payload->products[0]->total_value);
        $this->assertEquals('£15.00',          $payload->products[0]->total_discount);
        $this->assertEquals('£0.00',           $payload->products[0]->total_delivery);
        $this->assertEquals('£6.90',           $payload->products[0]->total_tax);
        $this->assertEquals('£34.50',          $payload->products[0]->subtotal);
        $this->assertEquals('£41.40',          $payload->products[0]->total);
        $this->assertEquals('6',               $payload->products[1]->sku);
        $this->assertEquals('Aeron Chair',     $payload->products[1]->name);
        $this->assertEquals('£899.99',         $payload->products[1]->price);
        $this->assertEquals('20%',             $payload->products[1]->rate);
        $this->assertEquals(1,                 $payload->products[1]->quantity);
        $this->assertEquals(false,             $payload->products[1]->freebie);
        $this->assertEquals(true,              $payload->products[1]->taxable);
        $this->assertEquals('£60.00',          $payload->products[1]->delivery);
        $this->assertEquals([],                $payload->products[1]->coupons);
        $this->assertEquals([],                $payload->products[1]->tags);
        $this->assertEquals(null,              $payload->products[1]->discount);
        $this->assertEquals(null,              $payload->products[1]->category);
        $this->assertEquals('£899.99',         $payload->products[1]->total_value);
        $this->assertEquals('£0.00',           $payload->products[1]->total_discount);
        $this->assertEquals('£60.00',          $payload->products[1]->total_delivery);
        $this->assertEquals('£180.00',         $payload->products[1]->total_tax);
        $this->assertEquals('£959.99',         $payload->products[1]->subtotal);
        $this->assertEquals('£1,139.99',       $payload->products[1]->total);
        $this->assertEquals('7',               $payload->products[2]->sku);
        $this->assertEquals('Kettlebell',      $payload->products[2]->name);
        $this->assertEquals('£32.99',          $payload->products[2]->price);
        $this->assertEquals('20%',             $payload->products[2]->rate);
        $this->assertEquals(4,                 $payload->products[2]->quantity);
        $this->assertEquals(false,             $payload->products[2]->freebie);
        $this->assertEquals(true,              $payload->products[2]->taxable);
        $this->assertEquals('£6.99',           $payload->products[2]->delivery);
        $this->assertEquals([],                $payload->products[2]->coupons);
        $this->assertEquals([],                $payload->products[2]->tags);
        $this->assertEquals('10%',             $payload->products[2]->discount);
        $this->assertEquals(null,              $payload->products[2]->category);
        $this->assertEquals('£131.96',         $payload->products[2]->total_value);
        $this->assertEquals('£13.20',          $payload->products[2]->total_discount);
        $this->assertEquals('£27.96',          $payload->products[2]->total_delivery);
        $this->assertEquals('£23.75',          $payload->products[2]->total_tax);
        $this->assertEquals('£146.72',         $payload->products[2]->subtotal);
        $this->assertEquals('£170.47',         $payload->products[2]->total);
    }

    /** @test */
    public function should_transform_basket_fixture_eight()
    {
        $order   = $this->processor->process($this->fixtures->eight());
        $payload = json_decode($this->transformer->transform($order));

        $this->assertTrue(is_object($payload));
        $this->assertEquals('£0.00',        $payload->delivery);
        $this->assertEquals('£100.00',     $payload->discount);
        $this->assertEquals(5,             $payload->products_count);
        $this->assertEquals('£1,199.96',   $payload->subtotal);
        $this->assertEquals(5,             $payload->taxable);
        $this->assertEquals('£239.99',     $payload->tax);
        $this->assertEquals('£1,439.95',   $payload->total);
        $this->assertEquals('£1,304.95',   $payload->value);
        $this->assertEquals('2',           $payload->products[0]->sku);
        $this->assertEquals('Kindle',      $payload->products[0]->name);
        $this->assertEquals('£99.99',      $payload->products[0]->price);
        $this->assertEquals('20%',         $payload->products[0]->rate);
        $this->assertEquals(3,             $payload->products[0]->quantity);
        $this->assertEquals(false,         $payload->products[0]->freebie);
        $this->assertEquals(true,          $payload->products[0]->taxable);
        $this->assertEquals('£0.00',       $payload->products[0]->delivery);
        $this->assertEquals([],            $payload->products[0]->coupons);
        $this->assertEquals([],            $payload->products[0]->tags);
        $this->assertEquals(null,          $payload->products[0]->discount);
        $this->assertEquals(null,          $payload->products[0]->category);
        $this->assertEquals('£299.97',     $payload->products[0]->total_value);
        $this->assertEquals('£0.00',       $payload->products[0]->total_discount);
        $this->assertEquals('£0.00',       $payload->products[0]->total_delivery);
        $this->assertEquals('£59.99',      $payload->products[0]->total_tax);
        $this->assertEquals('£299.97',     $payload->products[0]->subtotal);
        $this->assertEquals('£359.96',     $payload->products[0]->total);
        $this->assertEquals('3',           $payload->products[1]->sku);
        $this->assertEquals('iPhone case', $payload->products[1]->name);
        $this->assertEquals('£4.99',       $payload->products[1]->price);
        $this->assertEquals('20%',         $payload->products[1]->rate);
        $this->assertEquals(1,             $payload->products[1]->quantity);
        $this->assertEquals(true,          $payload->products[1]->freebie);
        $this->assertEquals(true,          $payload->products[1]->taxable);
        $this->assertEquals('£0.00',       $payload->products[1]->delivery);
        $this->assertEquals([],            $payload->products[1]->coupons);
        $this->assertEquals([],            $payload->products[1]->tags);
        $this->assertEquals(null,          $payload->products[1]->discount);
        $this->assertEquals(null,          $payload->products[1]->category);
        $this->assertEquals('£4.99',       $payload->products[1]->total_value);
        $this->assertEquals('£0.00',       $payload->products[1]->total_discount);
        $this->assertEquals('£0.00',       $payload->products[1]->total_delivery);
        $this->assertEquals('£0.00',       $payload->products[1]->total_tax);
        $this->assertEquals('£0.00',       $payload->products[1]->subtotal);
        $this->assertEquals('£0.00',       $payload->products[1]->total);
        $this->assertEquals('4',           $payload->products[2]->sku);
        $this->assertEquals('MacBook Air', $payload->products[2]->name);
        $this->assertEquals('£999.99',     $payload->products[2]->price);
        $this->assertEquals('20%',         $payload->products[2]->rate);
        $this->assertEquals(1,             $payload->products[2]->quantity);
        $this->assertEquals(false,         $payload->products[2]->freebie);
        $this->assertEquals(true,          $payload->products[2]->taxable);
        $this->assertEquals('£0.00',       $payload->products[2]->delivery);
        $this->assertEquals([],            $payload->products[2]->coupons);
        $this->assertEquals([],            $payload->products[2]->tags);
        $this->assertEquals('10%',         $payload->products[2]->discount);
        $this->assertEquals(null,          $payload->products[2]->category);
        $this->assertEquals('£999.99',     $payload->products[2]->total_value);
        $this->assertEquals('£100.00',     $payload->products[2]->total_discount);
        $this->assertEquals('£0.00',       $payload->products[2]->total_delivery);
        $this->assertEquals('£180.00',     $payload->products[2]->total_tax);
        $this->assertEquals('£899.99',     $payload->products[2]->subtotal);
        $this->assertEquals('£1,079.99',   $payload->products[2]->total);
    }

    /** @test */
    public function should_transform_basket_fixture_nine()
    {
        $order   = $this->processor->process($this->fixtures->nine());
        $payload = json_decode($this->transformer->transform($order));

        $this->assertTrue(is_object($payload));
        $this->assertEquals('£14.95',                     $payload->delivery);
        $this->assertEquals('£15.00',                     $payload->discount);
        $this->assertEquals(7,                            $payload->products_count);
        $this->assertEquals('£139.43',                    $payload->subtotal);
        $this->assertEquals(5,                            $payload->taxable);
        $this->assertEquals('£8.90',                      $payload->tax);
        $this->assertEquals('£148.33',                    $payload->total);
        $this->assertEquals('£214.48',                    $payload->value);
        $this->assertEquals('0',                          $payload->products[0]->sku);
        $this->assertEquals('Back to the Future Blu-ray', $payload->products[0]->name);
        $this->assertEquals('£10.00',                     $payload->products[0]->price);
        $this->assertEquals('20%',                        $payload->products[0]->rate);
        $this->assertEquals(1,                            $payload->products[0]->quantity);
        $this->assertEquals(false,                        $payload->products[0]->freebie);
        $this->assertEquals(true,                         $payload->products[0]->taxable);
        $this->assertEquals('£0.00',                      $payload->products[0]->delivery);
        $this->assertEquals([],                           $payload->products[0]->coupons);
        $this->assertEquals([],                           $payload->products[0]->tags);
        $this->assertEquals(null,                         $payload->products[0]->discount);
        $this->assertEquals(null,                         $payload->products[0]->category);
        $this->assertEquals('£10.00',                     $payload->products[0]->total_value);
        $this->assertEquals('£0.00',                      $payload->products[0]->total_discount);
        $this->assertEquals('£0.00',                      $payload->products[0]->total_delivery);
        $this->assertEquals('£2.00',                      $payload->products[0]->total_tax);
        $this->assertEquals('£10.00',                     $payload->products[0]->subtotal);
        $this->assertEquals('£12.00',                     $payload->products[0]->total);
        $this->assertEquals('5',                          $payload->products[1]->sku);
        $this->assertEquals('Sega Mega Drive',            $payload->products[1]->name);
        $this->assertEquals('£49.50',                     $payload->products[1]->price);
        $this->assertEquals('20%',                        $payload->products[1]->rate);
        $this->assertEquals(1,                            $payload->products[1]->quantity);
        $this->assertEquals(false,                        $payload->products[1]->freebie);
        $this->assertEquals(true,                         $payload->products[1]->taxable);
        $this->assertEquals('£0.00',                      $payload->products[1]->delivery);
        $this->assertEquals([],                           $payload->products[1]->coupons);
        $this->assertEquals([],                           $payload->products[1]->tags);
        $this->assertEquals('£15.00',                     $payload->products[1]->discount);
        $this->assertEquals(null,                         $payload->products[1]->category);
        $this->assertEquals('£49.50',                     $payload->products[1]->total_value);
        $this->assertEquals('£15.00',                     $payload->products[1]->total_discount);
        $this->assertEquals('£0.00',                      $payload->products[1]->total_delivery);
        $this->assertEquals('£6.90',                      $payload->products[1]->total_tax);
        $this->assertEquals('£34.50',                     $payload->products[1]->subtotal);
        $this->assertEquals('£41.40',                     $payload->products[1]->total);
        $this->assertEquals('8',                          $payload->products[2]->sku);
        $this->assertEquals('Junior Jordans',             $payload->products[2]->name);
        $this->assertEquals('£39.99',                     $payload->products[2]->price);
        $this->assertEquals('20%',                        $payload->products[2]->rate);
        $this->assertEquals(2,                            $payload->products[2]->quantity);
        $this->assertEquals(false,                        $payload->products[2]->freebie);
        $this->assertEquals(false,                        $payload->products[2]->taxable);
        $this->assertEquals('£5.99',                      $payload->products[2]->delivery);
        $this->assertEquals([],                           $payload->products[2]->coupons);
        $this->assertEquals([],                           $payload->products[2]->tags);
        $this->assertEquals(null,                         $payload->products[2]->discount);
        $this->assertEquals(null,                         $payload->products[2]->category);
        $this->assertEquals('£79.98',                     $payload->products[2]->total_value);
        $this->assertEquals('£0.00',                      $payload->products[2]->total_discount);
        $this->assertEquals('£11.98',                     $payload->products[2]->total_delivery);
        $this->assertEquals('£0.00',                      $payload->products[2]->total_tax);
        $this->assertEquals('£91.96',                     $payload->products[2]->subtotal);
        $this->assertEquals('£91.96',                     $payload->products[2]->total);
        $this->assertEquals('9',                          $payload->products[3]->sku);
        $this->assertEquals('Gift Card',                  $payload->products[3]->name);
        $this->assertEquals('£25.00',                     $payload->products[3]->price);
        $this->assertEquals('20%',                        $payload->products[3]->rate);
        $this->assertEquals(3,                            $payload->products[3]->quantity);
        $this->assertEquals(true,                         $payload->products[3]->freebie);
        $this->assertEquals(true,                         $payload->products[3]->taxable);
        $this->assertEquals('£0.99',                      $payload->products[3]->delivery);
        $this->assertEquals([],                           $payload->products[3]->coupons);
        $this->assertEquals([],                           $payload->products[3]->tags);
        $this->assertEquals(null,                         $payload->products[3]->discount);
        $this->assertEquals(null,                         $payload->products[3]->category);
        $this->assertEquals('£75.00',                     $payload->products[3]->total_value);
        $this->assertEquals('£0.00',                      $payload->products[3]->total_discount);
        $this->assertEquals('£2.97',                      $payload->products[3]->total_delivery);
        $this->assertEquals('£0.00',                      $payload->products[3]->total_tax);
        $this->assertEquals('£2.97',                      $payload->products[3]->subtotal);
        $this->assertEquals('£2.97',                      $payload->products[3]->total);
    }
}
