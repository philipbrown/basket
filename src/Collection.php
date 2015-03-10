<?php namespace PhilipBrown\Basket;

use Closure;
use Countable;
use ArrayIterator;
use IteratorAggregate;

class Collection implements Countable, IteratorAggregate
{
    /**
     * @var array
     */
    private $items;

    /**
     * Create a new Collection
     *
     * @param array $items
     * @return void
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Add a new item by key
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function add($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Get all the items of the Collection
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Check to see if a value is in the Collection
     *
     * @param mixed $value
     * @return bool
     */
    public function contains($value)
    {
        return in_array($value, $this->items);
    }

    /**
     * Count the number of items in the Collection
     *
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Run a callback on each item
     *
     * @param Closure $callback
     * @return void
     */
    public function each(Closure $callback)
    {
        array_map($callback, $this->items);
    }

    /**
     * Check to see if the Collection is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Filter the Collection and return a new Collection
     *
     * @param Closure $callback
     * @return Collection
     */
    public function filter(Closure $callback)
    {
        return new Collection(array_filter($this->items, $callback));
    }

    /**
     * Get the first item of the Collection
     *
     * @return mixed
     */
    public function first()
    {
        return reset($this->items);
    }

    /**
     * Return the Collection's keys
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->items);
    }

    /**
     * Get an item from the Collection by key
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->items[$key];
    }

    /**
     * Get the last item of the Collection
     *
     * @return mixed
     */
    public function last()
    {
        return end($this->items);
    }

    /**
     * Run a Closure over each item and return a new Collection
     *
     * @param Closure $callback
     * @return Collection
     */
    public function map(Closure $callback)
    {
        return new Collection(array_map($callback, $this->items, array_keys($this->items)));
    }

    /**
     * Pop the last item off the Collection
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * Push an item onto the start of the Collection
     *
     * @param mixed $value
     * @return void
     */
    public function prepend($value)
    {
        array_unshift($this->items, $value);
    }

    /**
     * Push an item onto the end of the Collection
     *
     * @param mixed $value
     * @return void
     */
    public function push($value)
    {
        $this->items[] = $value;
    }

    /**
     * Remove an item from the Collection by key
     *
     * @param mixed $key
     * @return void
     */
    public function remove($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Search the Collection for a value
     *
     * @param mixed $value
     * @return mixed
     */
    public function search($value)
    {
        return array_search($value, $this->items, true);
    }

    /**
     * Get and remove the first item
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->items);
    }

    /**
     * Sort through each item with a callback
     *
     * @param Closure $callback
     * @return void
     */
    public function sort(Closure $callback)
    {
        uasort($this->items, $callback);
    }

    /**
     * Reset the values of the Collection
     *
     * @return void
     */
    public function values()
    {
        $this->items = array_values($this->items);
    }

    /**
     * Return the Collection as an array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->items;
    }

    /**
     * Get an iterator for the items
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Get a dictionary keyed by sku
     *
     * @param  \ArrayAccess|array  $items
     * @return array
     */
    public function getDictionary($items = null)
    {
        $items = is_null($items) ? $this->items : $items;

        $dictionary = [];

        foreach ($items as $item) {
            $dictionary[$item->sku] = $item;
        }

        return $dictionary;
    }
}
