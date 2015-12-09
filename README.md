# Basket

**The missing link between your product pages and your payment gateway**

[![Build Status](https://travis-ci.org/philipbrown/basket.png?branch=master)](https://travis-ci.org/philipbrown/basket)
[![Code Coverage](https://scrutinizer-ci.com/g/philipbrown/basket/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/philipbrown/basket/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/philipbrown/basket/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/philipbrown/basket/?branch=master)

## Installation

Using [composer](https://packagist.org/packages/philipbrown/basket):

```bash
$ composer require philipbrown/basket
```
**WARNING!** This package is still pre `1.0` and so there will be breaking changes. Use at your own risk!

## Money and Currency
Dealing with Money and Currency in an ecommerce application can be fraught with difficulties. Instead of passing around dumb values, we can use Value Objects that are immutable and protect the invariants of the items we hope to represent:
```php
use Money\Money;
use Money\Currency;

$price = new Money(500, new Currency('GBP'));
```

Equality is important when working with many different types of currency. You shouldn't be able to blindly add two different currencies without some kind of exchange process:
```php
$money1 = new Money(500, new Currency('GBP'));
$money2 = new Money(500, new Currency('USD'));

// Throws Money\InvalidArgumentException
$money->add($money2);
```

This package uses [mathiasverraes/money](https://github.com/mathiasverraes/money) by [@mathiasverraes](https://github.com/mathiasverraes) throughout to represent Money and Currency values.

## Tax Rates
One of the big problems with dealing with international commerce is the fact that almost everyone has their own rules around tax.

To make tax rates interchangeable we can encapsulate them as objects that implement a common `TaxRate` interface:
```php
interface TaxRate
{
    /**
     * Return the Tax Rate as a float
     *
     * @return float
     */
    public function float();

    /**
     * Return the Tax Rate as a percentage
     *
     * @return int
     */
    public function percentage();
}
```

An example `UnitedKingdomValueAddedTax` implementation can be found in this package. If you would like to add a tax rate implementation for your country, state or region, please feel free to open a pull request.

## Jurisdictions
Almost every country in the world has a different combination of currency and tax rates. Countries like the USA also have different tax rates within each state.

In order to make it easier to work with currency and tax rate combinations you can think of the combination as an encapsulated "jurisdication". This means you can easily specify the currency and tax rate to be used depending on the location of the current customer.

Jurisdictions should implement the `Jurisdiction` interface:
```php
interface Jurisdiction
{
    /**
     * Return the Tax Rate
     *
     * @return TaxRate
     */
    public function rate();

    /**
     * Return the currency
     *
     * @return Money\Currency
     */
    public function currency();
}
```

Again, if you would like to add an implementation for your country, state or region, please feel free to open a pull request.

## Products
Each item of the basket is encapsulated as an instance of `Product`. The majority of your interaction with the `Product` class will be through the `Basket`, however it is important that you understand how the `Product` class works.

The `Product` class captures the current state of the each item in the basket. This includes the price, quantity and any discounts that should be applied.

To create a new `Product`, pass the product's [SKU](http://en.wikipedia.org/wiki/Stock_keeping_unit), name, price and tax rate:
```php
use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\TaxRates\UnitedKingdomValueAddedTax;

$sku   = '1';
$name  = 'Four Steps to the Epiphany';
$rate  = new UnitedKingdomValueAddedTax;
$price = new Money(1000, new Currency('GBP'));
$product = new Product($sku, $name, $price, $rate);
```

The SKU, name, price and tax rate should not be altered once the `Product` is created and so there are no setter methods for these properties on the object.

Each of the `Product` object's `private` properties are available as pseudo `public` properties via the `__get()` magic method:
```php
$product->sku;    // '1'
$product->name;   // 'Four Steps to the Epiphany'
$product->rate;   // UnitedKingdomValueAddedTax
$product->price;  // Money\Money
```

### Quantity
By default, each `Product` instance will automatically be set with a quantity of 1. You can set the quantity of the product in one of three ways:
```php
$product->quantity(2);

$product->increment();

$product->decrement();

// Return the `quantity`
$product->quantity;
```

### Freebie
A product can be optionally set as a freebie. This means that the value of the product will not be included during the reconciliation process:
```php
$product->freebie(true);

// Return the `freebie` status
$product->freebie;
```

By default the `freebie` status of each `Product` is set to `false`.

### Taxable
You can also mark a product as not taxable. By default all products are set to incur tax. By setting the `taxable` status to `false` the taxable value of the product won't be calculated during reconciliation:
```php
$product->taxable(false);

// Return the `taxable` status
$product->taxable;
```

### Delivery
If you would like to add an additional charge for delivery for the product you can do so by passing an instance of `Money\Money` to the `delivery()` method:
```php
use Money\Money;
use Money\Currency;

$product->delivery(new Money(500, new Currency('GBP')));

// Return the `delivery` charge
$product->delivery;
```

The `Currency` of the delivery charge must be the same as the `price` that was set when the object was instantiated. By default the delivery charge is set to `0`.

### Coupons
If you would like to record a coupon on the product, you can do so by passing a value to the `coupon()` method:
```php
$product->coupons('FREE99');

// Return the `coupons` Collection
$product->coupons;
```

You can add as many coupons as you want to each product. The `coupons` class property is an instance of `Collection`. This is an iterable object that allows you to work with an array in an object orientated way.

The coupon itself does not cause the product to set a discount, it is simply a way for you to record that the coupon was applied to the product.

### Tags
Similar to coupons, tags allow you to tag a product so you can record experiments or A/B testing:
```php
$product->tags('campaign_123456');

// Return the `tags` Collection
$product->tags;
```

The `tags` class property is also an instance of `Collection`.

### Discounts
Discounts are objects that can be applied during the reconciliation process to reduce the price of a product. Each discount object should implement the `Discount` interface:
```php
interface Discount
{
    /**
     * Calculate the discount on a Product
     *
     * @param Product
     * @return Money\Money
     */
    public function product(Product $product);

    /**
     * Return the rate of the Discount
     *
     * @return mixed
     */
    public function rate();
}
```

There are two discount objects supplied with this package that allow you to set a value discount or a percentage discount:
```php
use PhilipBrown\Basket\Discounts\ValueDiscount;
use PhilipBrown\Basket\Discounts\PercentageDiscount;

$product->discount(new PercentageDiscount(20));
$product->discount(new ValueDiscount(new Money(500, new Currency('GBP'))));

// Return the `Discount` instance
$product->discount;
```

### Categories
If you want to apply a set of rules to all products of a certain type, you can define a category object that can be applied to a `Product` instance.

Each category object should implement the `Category` interface:
```php
interface Category
{
    /**
     * Categorise a Product
     *
     * @param Product $product
     * @return void
     */
    public function categorise(Product $product);
}
```

`PhysicalBook` is an example of a `Category` object that is supplied with this package. When applied to a product, the `PhyisicalBook` will automatically set the `taxable` status to `false`:
```php
use PhilipBrown\Basket\Categories\PhysicalBook;

$product->category(new PhysicalBook);

// Return the `Category` instance
$product->category;
```

### Actions
Finally if you want to run a series of actions on a product, you can pass a `Closure` to the `action()` method:
```php
$product->action(function ($product) {
    $product->quantity(3);
    $product->freebie(true);
    $product->taxable(false);
});
```

## Basket
The main interface of interaction inside your application will be through the `Basket` object. The Basket object manages the adding and removing of products from the product list.

To create a new `Basket` instance, pass the current `Jurisdiction`:
```php
use PhilipBrown\Basket\Basket;
use PhilipBrown\Basket\Jurisdictions\UnitedKingdom;

$basket = new Basket(new UnitedKingdom);
```

The `Basket` accepts the `Jurisdiction` instance but manages the tax rate and the currency as two seperate properties. Those two objects are available through the following two methods:
```php
$basket->rate();     // PhilipBrown\Basket\TaxRate
$basket->currency(); // Money\Currency
```

The `Basket` will automatically create a new `Collection` instance to internally manage the Product instances of the current order.

You can interact with the product list using the following methods:
```php
// Get the count of the products
$basket->count();

// Pick a product from the basket via it's SKU
$product = $basket->pick('abc123');

// Iterate over the Collection of products
$basket->products()->filter(function ($product) {
    // Do something
});
```

To add a product to the basket, pass the SKU, name and price to the add() method:
```php
$sku   = 'abc123';
$name  = 'The Lion King';
$price = new Money(1000, new Currency('GBP'));

$basket->add($sku, $name, $price);
```

You can also optionally pass a fourth parameter of a `Closure` to run actions on the new product:
```php
$sku   = 'abc123';
$name  = 'The Lion King';
$price = new Money(1000, new Currency('GBP'));

$basket->add($sku, $name, $price, function ($product) {
    $product->quantity(3);
    $product->discount(new PercentageDiscount(20));
});
```

To update a product, pass the SKU and a `Closure` of actions to the `update()` method:
```php
$basket->update('abc123', function ($product) {
    $product->increment();
});
```

To remove a product, pass the SKU to the `remove()` method:
```php
$basket->remove('abc123');
```

## Reconciliation
Each `Product` object is the product in it's current state. In order to calculate the various totals that an ecommerce application will require, we need to pass it through a reconciliation process.

One of the problems I encounted when researching this package is that people seem to have different opinions of how the reconciliation process should work.

To solve this problem, I've defined a `Reconciler` interface so you an implement your own reconciliation process:
```php
interface Reconciler
{
    /**
     * Return the value of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function value(Product $product);

    /**
     * Return the discount of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function discount(Product $product);

    /**
     * Return the delivery charge of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function delivery(Product $product);

    /**
     * Return the tax of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function tax(Product $product);

    /**
     * Return the subtotal of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function subtotal(Product $product);

    /**
     * Return the total of the Product
     *
     * @param Product $product
     * @return Money
     */
    public function total(Product $product);
}
```

I've included a `DefaultReconciler` as a standard process for reconciling the items in your basket.

## Meta Data
All ecommerce applications will require meta data about an order such as the number of products, the value of the products and the value of the tax of the order.

Whilst certain types of ecommerce applications will require very little in the way of meta data, other types of applications will require much more in-depth data about each transaction that flows through the system.

In order to not force simple applications to run deep analysis on every order, and also give large applications the freedom to implement their own meta data calculations, each meta data item is optional and it's very easy to define your own.

Each meta data item should be encapsulated as a class and should implement the `MetaData` interface:
```php
interface MetaData
{
    /**
     * Generate the Meta Data
     *
     * @param Basket $basket
     * @return mixed
     */
    public function generate(Basket $basket);

    /**
     * Return the name of the Meta Data
     *
     * @return string
     */
    public function name();
}
```

The `generate()` method accepts an instance of the `Basket` and should return the value of the meta data item you want to return.

The `name()` method should be the name of the object as you want it to appear in the reconciliation output.

This package includes the following meta data items by default:
- `DeliveryMetaData`
- `DiscountMetaData`
- `ProductsMetaData`
- `SubtotalMetaData`
- `TaxableMetaData`
- `TaxMetaData`
- `TotalMetaData`
- `ValueMetaData`

## Processing an Order
Once you are ready to process the items in the `Basket` and turn it into an immutable `Order`, you can use the `Processor` class:
```php
use PhilipBrown\Basket\MetaData\TotalMetaData;
use PhilipBrown\Basket\MetaData\ProductsMetaData;
use PhilipBrown\Basket\Reconcilers\DefaultReconciler;

$reconciler = new DefaultReconciler;

$processor  = new Processor($reconciler, [
    new TotalMetaData($reconciler),
    new ProductsMetaData
]);

$order = $processor->process($basket);
```
The `Processor` class will run each `MetaData` instance on the basket and turn each `Product` instance into an array of attributes.

You can now use the `Order` object to update your database or send the order to your payment gateway of choice.

## Transforming an Order
You will inevitably want to display the details of the order in a view or return the processed order as a HTTP response.

In order to seperate the display of an object from the object itself, you can use special classes that implement the `Formatter` interface:
```php
interface Formatter
{
    /**
     * Format an input to an output
     *
     * @param mixed $value
     * @return mixed
     */
    public function format($value);
}
```
There are 5 example formatter classes of this package:
- `CategoryFormatter`
- `CollectionFormatter`
- `MoneyFormatter`
- `PercentFormatter`
- `TaxRateFormatter`

The process of converting an object using an instance of `Formatter` is encapsulated in the `Converter` object:
```php
use Money\Money;
use Money\Currency;
use PhilipBrown\Basket\Converter;

$converter = new Converter;

$converter->convert(new Money(500, new Currency('GBP')));
// => £10.00
```

The `Converter` class is bootstrapped with default `Formatter` instances. If you would like to override any of the default formatters, simply pass an array on instantiation:
```php
$converter = new Converter(['Money' => new CustomerMoneyFormatter]);
```

Finally to transform the `Order` into an appropriate output you can use either the `ArrayTransformer` or `JSONTransformer` class:
```php
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
use PhilipBrown\Basket\Transformers\ArrayTransformer;
use PhilipBrown\Basket\Reconcilers\DefaultReconciler;

$reconciler  = new DefaultReconciler;

$meta = [
    new DeliveryMetaData($reconciler),
    new DiscountMetaData($reconciler),
    new ProductsMetaData,
    new SubtotalMetaData($reconciler),
    new TaxableMetaData,
    new TaxMetaData($reconciler),
    new TotalMetaData($reconciler),
    new ValueMetaData($reconciler)
];

$processor   = new Processor($reconciler, $meta);
$transformer = new ArrayTransformer(new Converter);

$order   = $processor->process($basket);
$payload = $transformer->transform($order);

/*
[
    'delivery'       => "£0.00",
    'discount'       => "£0.00",
    'products_count' => 1,
    'subtotal'       => "£10.00",
    'taxable'        => 1,
    'tax'            => "£2.00",
    'total'          => "£12.00",
    'value'          => "£10.00",
    'products' => [
        [
            'sku'            => "0",
            'name'           => "Back to the Future Blu-ray",
            'price'          => "£10.00",
            'rate'           => "20%",
            'quantity'       => 1,
            'freebie'        => false,
            'taxable'        => true,
            'delivery'       => "£0.00"
            'coupons'        => [],
            'tags'           => [],
            'discount'       => null,
            'category'       => null,
            'total_value'    => "£10.00",
            'total_discount' => "£0.00",
            'total_delivery' => "£0.00",
            'total_tax'      => "£2.00",
            'subtotal'       => "£10.00",
            'total'          => "£12.00"
        ]
    ]
]
*/
```
