<?php

namespace UntamedWorlds\Cart\Tests;

use PHPUnit_Framework_TestCase;
use SebastianBergmann\Money\Money;
use UntamedWorlds\Cart\Item as ItemInstance;

class Item extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->item = new ItemInstance(
            'id',
            new Money(200, 'USD'),
            5
        );
    }

    public function testSuccessfulCreation()
    {
        $this->assertEquals(ItemInstance::class, get_class($this->item));
    }

    public function testSubtotal()
    {
        $this->assertEquals(new Money(1000, 'USD'), $this->item->subtotal());
    }

    public function testToJson()
    {
        $expected = [
            'id' => 'id',
            'price' => $this->item->price()->jsonSerialize(),
            'quantity' => 5
        ];
        $this->assertEquals($expected, $this->item->jsonSerialize());
    }

    public function testFromStdObj()
    {
        $json = json_encode($this->item);
        $this->assertEquals($this->item, ItemInstance::fromStdObj(json_decode($json)));
    }

    /**
     * @expectedException \UntamedWorlds\Cart\Exceptions\InvalidQuantityException
     */
    public function testFailureOnZeroQuantity()
    {
        new ItemInstance(
            'id',
            new Money(100, 'USD'),
            0
        );
    }

    /**
    * @expectedException \UntamedWorlds\Cart\Exceptions\InvalidQuantityException
    */
    public function testFailureOnNegativeQuantity()
    {
        new ItemInstance(
            'id',
            new Money(100, 'USD'),
            -3
        );
    }
}
