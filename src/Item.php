<?php

namespace UntamedWorlds\Cart;

use stdClass;
use UntamedWorlds\Cart\Contract\Cart\Item as ItemContract;
use SebastianBergmann\Money\Money;

class Item implements ItemContract
{
    private $id;
    private $price;
    private $quantity;

    /**
     * Item constructor.
     * @param string $id
     * @param Money $price
     * @param int $quantity
     */
    public function __construct(
        string $id,
        Money $price,
        int $quantity
    ) {
        $this->id = $id;
        $this->price = $price;
        $this->quantity = $quantity;
    }


    public function id() : string
    {
        return $this->id;
    }

    public function price() : Money
    {
        return $this->price;
    }

    public function quantity() : int
    {
        return $this->quantity;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id(),
            'price' => $this->price()->getConvertedAmount(),
            'quantity' => $this->quantity()
        ];
    }

    public function fromStdObj(stdClass $obj) : self {
        return new static(
            $obj->id,
            Money::fromString($obj->price, 'USD'),
            $obj->quantity
        );
    }
}
