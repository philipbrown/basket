<?php namespace PhilipBrown\Basket;

class Processor
{
    /**
     * @var Reconciler
     */
    private $reconciler;

    /**
     * @var array
     */
    private $metadata;

    /**
     * Create a new Processor
     *
     * @param Reconciler $reconciler
     * @param array $metadata
     * @return void
     */
    public function __construct(Reconciler $reconciler, $metadata = [])
    {
        $this->reconciler = $reconciler;
        $this->metadata   = $metadata;
    }

    /**
     * Process a Basket into ... ?
     *
     * @param Basket $basket
     * @return Order
     */
    public function process(Basket $basket)
    {
        $totals   = $this->totals($basket);
        $products = $this->products($basket);

        return new Order($totals, $products);
    }

    /**
     * Process the Calculators
     *
     * @param Basket $basket
     * @return array
     */
    public function totals(Basket $basket)
    {
        $totals = [];

        foreach ($this->metadata as $item) {
            $totals[$item->name()] = $item->generate($basket);
        }

        return $totals;
    }

    /**
     * Process the Products
     *
     * @param Basket $basket
     * @return array
     */
    public function products(Basket $basket)
    {
        $products = [];

        foreach ($basket->products() as $product) {
            $products[] = [
                'sku'      => $product->sku,
                'name'     => $product->name,
                'price'    => $product->price,
                'rate'     => $product->rate,
                'quantity' => $product->quantity,
                'freebie'  => $product->freebie,
                'taxable'  => $product->taxable,
                'delivery' => $product->delivery,
                'coupons'  => $product->coupons,
                'tags'     => $product->tags,
                'discount' => $product->discount,
                'category' => $product->category
            ];
        }

        return $products;
    }
}
