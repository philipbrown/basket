<?php namespace PhilipBrown\Basket;

use Closure;
use Money\Money;

class Product
{
    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Money
     */
    private $price;

    /**
     * @var TaxRate
     */
    private $rate;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var bool
     */
    private $freebie;

    /**
     * @var bool
     */
    private $taxable;

    /**
     * @var Money
     */
    private $delivery;

    /**
     * @var Collection
     */
    private $coupons;

    /**
     * @var Collection
     */
    private $tags;

    /**
     * @var Collection
     */
    private $discounts;

    /**
     * @var Category
     */
    private $category;

    /**
     * Create a new Product
     *
     * @param string $sku
     * @param string $name
     * @param Money $price
     * @param TaxRate $rate
     * @return void
     */
    public function __construct($sku, $name, Money $price, TaxRate $rate)
    {
        $this->sku          = $sku;
        $this->name         = $name;
        $this->price        = $price;
        $this->rate         = $rate;
        $this->quantity     = 1;
        $this->freebie      = false;
        $this->taxable      = true;
        $this->delivery     = new Money(0, $price->getCurrency());
        $this->coupons      = new Collection;
        $this->tags         = new Collection;
        $this->discounts    = new Collection;
    }

    /**
     * Set the quantity
     *
     * @param int $quantity
     * @return void
     */
    public function quantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Increment the quantity
     *
     * @return void
     */
    public function increment()
    {
        $this->quantity++;
    }

    /**
     * Decrement the quantity
     *
     * @return void
     */
    public function decrement()
    {
        $this->quantity--;
    }

    /**
     * Set the freebie status
     *
     * @param bool $status
     * @return void
     */
    public function freebie($status)
    {
        $this->freebie = $status;
    }

    /**
     * Set the taxable status
     *
     * @param bool $status
     * @return void
     */
    public function taxable($status)
    {
        $this->taxable = $status;
    }

    /**
     * Set the delivery charge
     *
     * @param Money $cost
     * @return void
     */
    public function delivery(Money $delivery)
    {
        if ($this->price->isSameCurrency($delivery)) {
            $this->delivery = $delivery;
        }
    }

    /**
     * Add a coupon
     *
     * @param string $coupon
     * @return void
     */
    public function coupons($coupon)
    {
        $this->coupons->push($coupon);
    }

    /**
     * Add a tag
     *
     * @param string $tag
     * @return void
     */
    public function tags($tag)
    {
        $this->tags->push($tag);
    }

    /**
     * Set a discount
     *
     * @param Discount $discount
     * @return void
     */
    public function discount(Discount $discount)
    {
        $this->discounts->add(0, $discount);
    }

    /**
     * Set a category
     *
     * @param Category $category
     * @return void
     */
    public function category(Category $category)
    {
        $this->category = $category;

        $this->category->categorise($this);
    }

    /**
     * Run a Closure of actions
     *
     * @param Closue $actions
     * @return void
     */
    public function action(Closure $actions)
    {
        call_user_func($actions, $this);
    }

    /**
     * Get the private attributes
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
    }
}
