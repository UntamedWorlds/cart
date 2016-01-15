<?php

namespace UntamedWorlds\Cart;

use stdClass;
use UntamedWorlds\Cart\Contract\Cart\Item as ItemContract;
use SebastianBergmann\Money\Money;
use UntamedWorlds\Cart\Exceptions\InvalidQuantityException;

class Item implements ItemContract
{
    private $id;
    private $price;
    private $quantity;

    /**
     * Item constructor.
     *
     * @throws InvalidQuantityException
     *
     * @param string $id
     * @param Money $price
     * @param int $quantity
     */
    public function __construct(
        string $id,
        Money $price,
        int $quantity
    ) {
        if ($quantity <= 0) {
            throw new InvalidQuantityException();
        }
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

    public function subtotal() : Money
    {
        return $this->price->multiply($this->quantity);
    }


    public function jsonSerialize()
    {
        return [
            'id' => $this->id(),
            'price' => $this->price()->jsonSerialize(),
            'quantity' => $this->quantity()
        ];
    }

    public static function fromStdObj(stdClass $obj) {
        return new self(
            $obj->id,
            new Money($obj->price->amount, $obj->price->currency),
            $obj->quantity
        );
    }
}
