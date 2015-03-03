# Basket

**The missing link between your product pages and your payment gateway**

## Installation

Using [composer](https://packagist.org/packages/philipbrown/basket):

```bash
$ composer require philipbrown/basket
```

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

This package uses [Money/Money](https://github.com/mathiasverraes/money) to represent Money and Currency values.

## Tax Rates
One of the big problems with dealing with international commerce is the fact that almost everyone has their own rules around tax.

You can define your own tax rate by creating a new `TaxRate` object:
```php
use PhilipBrown\Basket\TaxRate;

$rate = new TaxRate(0.20);
```
The `TaxRate` object should be instantiated with your desired tax rate as a `float`. The `TaxRate` object has two public methods for returning the value as a `float` or a `percentage`:
```php
use PhilipBrown\Basket\TaxRate;

$rate = new TaxRate(0.20);

$rate->float();      // 0.20

$rate->percentage(); // 20
```

## Jurisdictions
Almost every country in the world has a different combination of currency and tax rates.

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
If you would like to add an implementation for your country, state or region, please feel free to open a pull request.