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
        $meta     = $this->meta($basket);
        $products = $this->products($basket);

        return new Order($meta, $products);
    }

    /**
     * Process the Meta Data
     *
     * @param Basket $basket
     * @return array
     */
    public function meta(Basket $basket)
    {
        $meta = [];

        foreach ($this->metadata as $item) {
            $meta[$item->name()] = $item->generate($basket);
        }

        return $meta;
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
                'sku'            => $product->sku,
                'name'           => $product->name,
                'price'          => $product->price,
                'rate'           => $product->rate,
                'quantity'       => $product->quantity,
                'freebie'        => $product->freebie,
                'taxable'        => $product->taxable,
                'delivery'       => $product->delivery,
                'coupons'        => $product->coupons,
                'tags'           => $product->tags,
                'discount'       => $product->discount,
                'attributes'     => $product->attributes,
                'category'       => $product->category,
                'total_value'    => $this->reconciler->value($product),
                'total_discount' => $this->reconciler->discount($product),
                'total_delivery' => $this->reconciler->delivery($product),
                'total_tax'      => $this->reconciler->tax($product),
                'subtotal'       => $this->reconciler->subtotal($product),
                'total'          => $this->reconciler->total($product)
            ];
        }

        return $products;
    }
}
