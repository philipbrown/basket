<?php namespace PhilipBrown\Basket\Transformers;

use PhilipBrown\Basket\Order;
use PhilipBrown\Basket\Converter;
use PhilipBrown\Basket\Transformer;

class JSONTransformer implements Transformer
{
    /**
     * @var Converter
     */
    private $converter;

    /**
     * Create a new JSONTransformer
     *
     * @param Converter $converter
     * @return void
     */
    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Transform the Order
     *
     * @param Order $order
     * @return mixed
     */
    public function transform(Order $order)
    {
        foreach ($order->meta() as $key => $total) {
            $payload[$key] = $this->converter->convert($total);
        }

        $payload['products'] = [];

        foreach ($order->products() as $product) {
            $payload['products'][] = array_map(function ($value) {
                return $this->converter->convert($value);
            }, $product);
        }

        return json_encode($payload);
    }
}
