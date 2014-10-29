# Basket

**The missing link between your product pages and your payment gateway**

## Money and Currency
Dealing with Money and Currency in an ecommerce application can be fraught with difficulties. Instead of passing around dumb values, we can use Value Objects that are immutable and protect the invariants of the items we hope to represent:
``` php
use Money\Money;
use Money\Currency;

$price = new Money(500, new Currency('GBP'));
```

Equality is important when working with many different types of currency. You shouldn't be able to blindly add two different currencies without some kind of exchange process:
``` php
$money1 = new Money(500, new Currency('GBP'));
$money2 = new Money(500, new Currency('USD'));

// Throws Money\InvalidArgumentException
$money->add($money2);
```
This package uses [mathiasverraes/money](https://github.com/mathiasverraes/money) by [@mathiasverraes](https://github.com/mathiasverraes) throughout to represent Money and Currency values.

## Tax Rates
One of the big problems with dealing with international commerce is the fact that almost everyone has their own rules around tax.

To make tax rates interchangeable we can encapsulate them as objects that implement a common `TaxRate` interface:
``` php
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
``` php
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
