<?php namespace PhilipBrown\Basket\Tests;

use PhilipBrown\Basket\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    /** @var array */
    private $items = ['Homer', 'Marge', 'Bart', 'Lisa', 'Maggie'];

    /** @var Collection */
    private $collection;

    public function setUp()
    {
        $this->collection = new Collection($this->items);
    }

    /** @test */
    public function should_add_item()
    {
        $this->collection->add(5, 'Snowball II');

        $this->assertEquals('Snowball II', $this->collection->get(5));
    }

    /** @test */
    public function should_get_all_items()
    {
        $this->assertEquals($this->items, $this->collection->all());
    }

    /** @test */
    public function should_check_for_item()
    {
        $this->assertTrue($this->collection->contains('Bart'));
    }

    /** @test */
    public function should_count_items()
    {
        $this->assertEquals(5, $this->collection->count());
    }

    /** @test */
    public function should_run_callback_on_each_item()
    {
        $this->collection->each(function ($person) {
          $this->assertTrue(is_string($person));
        });
    }

    /** @test */
    public function should_check_for_emptyness()
    {
        $collection = new Collection;

        $this->assertTrue($collection->isEmpty());
        $this->assertFalse($this->collection->isEmpty());
    }

    /** @test */
    public function should_filter_the_collection()
    {
        $filtered = $this->collection->filter(function ($person) {
          return substr($person, 0,1) === 'M';
        });

        $this->assertEquals(2, $filtered->count());
    }

    /** @test */
    public function should_get_first_item()
    {
        $this->assertEquals('Homer', $this->collection->first());
    }

    /** @test */
    public function should_return_the_item_keys()
    {
        $keys = $this->collection->keys();

        $this->assertEquals([0,1,2,3,4], $keys);
    }

    /** @test */
    public function should_get_item_by_key()
    {
        $this->assertEquals('Lisa', $this->collection->get(3));
    }

    /** @test */
    public function should_get_last_item()
    {
        $this->assertEquals('Maggie', $this->collection->last());
    }

    /** @test */
    public function should_map_each_item()
    {
        $family = $this->collection->map(function ($person) {
          return "$person Simpson";
        });

        $this->assertEquals('Homer Simpson', $family->get(0));
        $this->assertEquals('Marge Simpson', $family->get(1));
        $this->assertEquals('Bart Simpson', $family->get(2));
        $this->assertEquals('Lisa Simpson', $family->get(3));
        $this->assertEquals('Maggie Simpson', $family->get(4));
    }

    /** @test */
    public function should_pop_the_last_item()
    {
        $person = $this->collection->pop();

        $this->assertEquals(4, $this->collection->count());
        $this->assertEquals('Maggie', $person);
    }

    /** @test */
    public function should_prepend_the_collection()
    {
        $this->collection->prepend('Abe');

        $this->assertEquals(6, $this->collection->count());
        $this->assertEquals('Abe', $this->collection->get(0));
    }

    /** @test */
    public function should_push_item_onto_the_end()
    {
        $this->collection->push("Santa's Little Helper");

        $this->assertEquals(6, $this->collection->count());
        $this->assertEquals("Santa's Little Helper", $this->collection->get(5));
    }

    /** @test */
    public function should_remove_item()
    {
        $this->collection->remove(0);

        $this->assertEquals(4, $this->collection->count());
    }

    /** @test */
    public function should_search_the_collection()
    {
        $key = $this->collection->search('Bart');

        $this->assertEquals(2, $key);
    }

    /** @test */
    public function should_get_and_remove_the_first_item()
    {
        $person = $this->collection->shift();

        $this->assertEquals(4, $this->collection->count());
        $this->assertEquals('Homer', $person);
    }

    /** @test */
    public function should_sort_items_in_collection_and_reset_keys()
    {
        $this->collection->sort(function ($a, $b) {
          if ($a == $b) return 0;

          return ($a < $b) ? -1 : 1;
        });

        $this->collection->values();

        $this->assertEquals('Bart', $this->collection->get(0));
        $this->assertEquals('Homer', $this->collection->get(1));
        $this->assertEquals('Lisa', $this->collection->get(2));
        $this->assertEquals('Maggie', $this->collection->get(3));
        $this->assertEquals('Marge', $this->collection->get(4));
    }

    /** @test */
    public function should_return_collection_as_array()
    {
        $this->assertEquals($this->items, $this->collection->toArray());
    }
}
