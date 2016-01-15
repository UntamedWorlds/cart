<?php

namespace UntamedWorlds\Cart\Tests;

use UntamedWorlds\Cart\ItemCollection as Collection;
use UntamedWorlds\Cart\Item as ItemInstance;
use SebastianBergmann\Money\Money;
use PHPUnit_Framework_TestCase;
use UntamedWorlds\Cart\Tests\Event\Dispatcher as EventDispatcher;

class ItemCollection extends PHPUnit_Framework_TestCase
{
    /**
     * @var Collection
     */
    private $collection;

    public function setUp()
    {
        $items = [];
        for ($i = 1; $i <= 10; $i++) {
            array_push($items, new ItemInstance(
                $i,
                new Money($i * 100, 'USD'),
                $i
            ));
        }
        $this->collection = new Collection(new EventDispatcher(), $items);
    }

    public function testCollectionCreation()
    {
        $this->assertEquals(Collection::class, get_class($this->collection));
    }

    public function testGet()
    {
        $firstItem = $this->collection->get('1');
        $this->assertEquals(new ItemInstance(1, new Money(100, 'USD'), 1), $firstItem);
        $thirdItem = $this->collection->get('3');
        $this->assertEquals(new ItemInstance(3, new Money(300, 'USD'), 3), $thirdItem);
    }

    public function testAdd()
    {
        $item = new ItemInstance('20', Money::fromString('12.87', 'USD'), 2);
        $collection = $this->collection->add($item);
        $this->assertEquals(Collection::class, get_class($collection));
        $this->assertTrue($this->collection->has('20'));
    }

    public function testChainAdding()
    {
        $item = new ItemInstance('20', Money::fromString('12.87', 'USD'), 2);
        $itemTwo = new ItemInstance('21', Money::fromString('1.50', 'USD'), 1);
        $this->collection->add($item)->add($itemTwo);
        $this->assertTrue($this->collection->has('20'));
        $this->assertTrue($this->collection->has('21'));
    }

    public function testHas()
    {
        $this->assertTrue($this->collection->has('4'));
        $this->assertFalse($this->collection->has('20'));
    }

    public function testRemove()
    {
        $this->collection->remove('1');
        $this->assertFalse($this->collection->has('1'));
    }

    public function testTotal()
    {
        $this->assertEquals(new Money(38500, 'USD'), $this->collection->total());
    }

    public function testJsonEncode()
    {
        $json ='{"storage":[{"id":"1","price":{"amount":100,"currency":"USD"},"quantity":1},{"id":"2","price":{"amount":200,"currency":"USD"},"quantity":2},{"id":"3","price":{"amount":300,"currency":"USD"},"quantity":3},{"id":"4","price":{"amount":400,"currency":"USD"},"quantity":4},{"id":"5","price":{"amount":500,"currency":"USD"},"quantity":5},{"id":"6","price":{"amount":600,"currency":"USD"},"quantity":6},{"id":"7","price":{"amount":700,"currency":"USD"},"quantity":7},{"id":"8","price":{"amount":800,"currency":"USD"},"quantity":8},{"id":"9","price":{"amount":900,"currency":"USD"},"quantity":9},{"id":"10","price":{"amount":1000,"currency":"USD"},"quantity":10}]}';
        $this->assertEquals($json, json_encode($this->collection));
    }

    public function testJsonDecode()
    {
        $json = '{"storage":[{"id":"1","price":{"amount":100,"currency":"USD"},"quantity":1},{"id":"2","price":{"amount":200,"currency":"USD"},"quantity":2},{"id":"3","price":{"amount":300,"currency":"USD"},"quantity":3},{"id":"4","price":{"amount":400,"currency":"USD"},"quantity":4},{"id":"5","price":{"amount":500,"currency":"USD"},"quantity":5},{"id":"6","price":{"amount":600,"currency":"USD"},"quantity":6},{"id":"7","price":{"amount":700,"currency":"USD"},"quantity":7},{"id":"8","price":{"amount":800,"currency":"USD"},"quantity":8},{"id":"9","price":{"amount":900,"currency":"USD"},"quantity":9},{"id":"10","price":{"amount":1000,"currency":"USD"},"quantity":10}]}';
        $newCollection = new Collection(new EventDispatcher());
        $full = $newCollection->fromStdObj(json_decode($json));
        $this->assertEquals($this->collection->all(), $full->all());
    }
}
