<?php namespace PhilipBrown\Basket\Fixtures;

use PhilipBrown\Basket\Basket;
use PhilipBrown\Basket\Jurisdictions\UnitedKingdom;
use PhilipBrown\Basket\Product;

class BasketFixture
{
    /**
     * @var ProductFixture
     */
    private $products;

    /**
     * Create a new BasketFixture
     *
     * @return void
     */
    public function __construct()
    {
        $this->products = new ProductFixture;
    }

    /**
     * Products: 1
     * Taxable:  1
     * Value:    £10.00
     * Delivery: £0
     * Discount: £0
     * Tax:      £2.00
     * Subtotal: £10.00
     * Total:    £12.00
     *
     * @return Basket
     */
    public function zero()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductZero($basket);

        return $basket;
    }

    /**
     * Products: 4
     * Taxable:  3
     * Value:    £314.97
     * Delivery: £0
     * Discount: £0
     * Tax:      £59.99
     * Subtotal: £314.97
     * Total:    £374.96
     *
     * @return Basket
     */
    public function one()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductOne($basket);
        $basket = $this->addProductTwo($basket);

        return $basket;
    }

    /**
     * Products: 2
     * Taxable:  1
     * Value:    £1,004.98
     * Delivery: £0
     * Discount: £100.00
     * Tax:      £180.00
     * Subtotal: £1,079.99
     * Total:    £1,079.99
     *
     * @return Basket
     */
    public function two()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductThree($basket);
        $basket = $this->addProductFour($basket);

        return $basket;
    }

    /**
     * Products: 3
     * Taxable:  3
     * Value:    £1,949.48
     * Delivery: £60.00
     * Discount: £115.00
     * Tax:      £366.90
     * Subtotal: £1,894.48
     * Total:    £2,261.38
     *
     * @return Basket
     */
    public function three()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductFour($basket);
        $basket = $this->addProductFive($basket);
        $basket = $this->addProductSix($basket);

        return $basket;
    }

    /**
     * Products: 6
     * Taxable:  4
     * Value:    £211.94
     * Delivery: £39.94
     * Discount: £13.20
     * Tax:      £23.75
     * Subtotal: £238.68
     * Total:    £262.43
     *
     * @return Basket
     */
    public function four()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductSeven($basket);
        $basket = $this->addProductEight($basket);

        return $basket;
    }

    /**
     * Products: 5
     * Taxable:  4
     * Value:    £1,089.99
     * Delivery: £2.97
     * Discount: £100.00
     * Tax:      £180.00
     * Subtotal: £917.96
     * Total:    £1,097.96
     *
     * @return Basket
     */
    public function five()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductOne($basket);
        $basket = $this->addProductFour($basket);
        $basket = $this->addProductNine($basket);

        return $basket;
    }

    /**
     * Products: 6
     * Taxable:  6
     * Value:    £146.95
     * Delivery: £27.96
     * Discount: £13.20
     * Tax:      £25.75
     * Subtotal: £156.72
     * Total:    £182.47
     *
     * @return Basket
     */
    public function six()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductZero($basket);
        $basket = $this->addProductThree($basket);
        $basket = $this->addProductSeven($basket);

        return $basket;
    }

    /**
     * Product:  6
     * Taxable:  6
     * Value:    £1,081.45
     * Delivery: £87.96
     * Discount: £28.20
     * Tax:      £210.65
     * Subtotal: £1,141.21
     * Total:    £1,351.86
     *
     * @return Basket
     */
    public function seven()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductFive($basket);
        $basket = $this->addProductSix($basket);
        $basket = $this->addProductSeven($basket);

        return $basket;
    }

    /**
     * Products: 5
     * Taxable:  5
     * Value:    £1,304.95
     * Delivery: £0
     * Discount: £100.00
     * Tax:      £239.99
     * Subtotal: £1,199.96
     * Total:    £1,439.95
     *
     * @return Basket
     */
    public function eight()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductTwo($basket);
        $basket = $this->addProductThree($basket);
        $basket = $this->addProductFour($basket);

        return $basket;
    }

    /**
     * Products: 7
     * Taxable:  5
     * Value:    £214.48
     * Delivery: £14.95
     * Discount: £15.00
     * Tax:      £8.90
     * Subtotal: £
     * Total:    £148.33
     *
     * @return Basket
     */
    public function nine()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductZero($basket);
        $basket = $this->addProductFive($basket);
        $basket = $this->addProductEight($basket);
        $basket = $this->addProductNine($basket);

        return $basket;
    }

    /**
     * Products: 2
     * Taxable:  2
     * Value:    £1009.99
     * Delivery: £0
     * Discount: £202
     * Tax:      £161.60
     * Subtotal: £807.99
     * Total:    £969.59
     *
     * @return Basket
     */
    public function ten()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductZero($basket);
        $basket = $this->addProductFour($basket);

        return $basket;
    }

    /**
     * Add Product Zero
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductZero(Basket $basket)
    {
        $zero = $this->products->zero();

        $product = new Product($zero->sku, $zero->name, $zero->price, $basket->rate());

        $basket->add($product);

        return $basket;
    }

    /**
     * Add Product One
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductOne(Basket $basket)
    {
        $one = $this->products->one();

        $product = new Product($one->sku, $one->name, $one->price, $basket->rate());
        $product->action(function ($product) use ($one) {
            $product->category($one->category);
        });

        $basket->add($product);

        return $basket;
    }

    /**
     * Add Product Two
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductTwo(Basket $basket)
    {
        $two = $this->products->two();

        $product = new Product($two->sku, $two->name, $two->price, $basket->rate());
        $product->action(function ($product) use ($two) {
            $product->quantity($two->quantity);
        });

        $basket->add($product);

        return $basket;
    }

    /**
     * Add Product Three
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductThree(Basket $basket)
    {
        $three = $this->products->three();

        $product = new Product($three->sku, $three->name, $three->price, $basket->rate());
        $product->action(function ($product) use ($three) {
            $product->freebie($three->freebie);
        });

        $basket->add($product);

        return $basket;
    }

    /**
     * Add Product Four
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductFour(Basket $basket)
    {
        $four = $this->products->four();

        $product = new Product($four->sku, $four->name, $four->price, $basket->rate());
        $product->action(function ($product) use ($four) {
            $product->discount($four->discounts->first());
        });

        $basket->add($product);

        return $basket;
    }

    /**
     * Add Product Five
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductFive(Basket $basket)
    {
        $five = $this->products->five();

        $product = new Product($five->sku, $five->name, $five->price, $basket->rate());
        $product->action(function ($product) use ($five) {
            $product->discount($five->discounts->first());
        });

        $basket->add($product);

        return $basket;
    }

    /**
     * Add Product Six
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductSix(Basket $basket)
    {
        $six = $this->products->six();

        $product = new Product($six->sku, $six->name, $six->price, $basket->rate());
        $product->action(function ($product) use ($six) {
            $product->delivery($six->delivery);
        });

        $basket->add($product);

        return $basket;
    }

    /**
     * Add Product Seven
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductSeven(Basket $basket)
    {
        $seven = $this->products->seven();

        $product = new Product($seven->sku, $seven->name, $seven->price, $basket->rate());
        $product->action(function ($product) use ($seven) {
            $product->quantity($seven->quantity);
            $product->discount($seven->discounts->first());
            $product->delivery($seven->delivery);
        });

        $basket->add($product);

        return $basket;
    }

    /**
     * Add Product Eight
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductEight(Basket $basket)
    {
        $eight = $this->products->eight();

        $product = new Product($eight->sku, $eight->name, $eight->price, $basket->rate());
        $product->action(function ($product) use ($eight) {
            $product->quantity($eight->quantity);
            $product->taxable($eight->taxable);
            $product->delivery($eight->delivery);
        });

        $basket->add($product);

        return $basket;
    }

    /**
     * Add Product Nine
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductNine(Basket $basket)
    {
        $nine = $this->products->nine();

        $product = new Product($nine->sku, $nine->name, $nine->price, $basket->rate());
        $product->action(function ($product) use ($nine) {
            $product->quantity($nine->quantity);
            $product->freebie($nine->freebie);
            $product->delivery($nine->delivery);
        });

        $basket->add($product);

        return $basket;
    }

    /**
     * Add Product Ten
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductTen(Basket $basket)
    {
        $five = $this->products->ten();

        $product = new Product($five->sku, $five->name, $five->price, $basket->rate());
        $product->action(function ($product) use ($five) {
            $product->discount($five->discounts->first());
        });

        $basket->add($product);

        return $basket;
    }
}
