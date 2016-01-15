<?php

namespace UntamedWorlds\Cart;

use UntamedWorlds\Cart\Contract\Cart\ItemCollection as ItemCollectionContract;
use UntamedWorlds\Cart\Contract\EventEmitter as EventContract;
use UntamedWorlds\Cart\Events\ItemRemoved as ItemRemovedEvent;
use UntamedWorlds\Cart\Contract\Cart\Item as ItemContract;
use UntamedWorlds\Cart\Events\ItemAdded as ItemAddedEvent;
use SebastianBergmann\Money\Money;
use Exception;
use stdClass;


class ItemCollection implements ItemCollectionContract
{
    /**
     * @var array
     */
    private $storage = [];

    /**
     * @var EventContract
     */
    private $eventEmitter;

    /**
     * ItemCollection constructor.
     * @throws Exception
     * @param EventContract $eventEmitter
     * @param array $storage
     */
    public function __construct(
        EventContract $eventEmitter,
        array $storage = []
    ) {
        foreach ($storage as $item) {
            /** @var $item ItemContract */
            if (
                !is_object($item) &&
                !in_array(class_implements($item), ItemContract::class)
            ) {
                throw new Exception(
                    'Items provided to the cart item collection must be item objects.'
                );
            }

            $this->storage[$item->id()] = $item;
        }
        $this->eventEmitter = $eventEmitter;
    }

    public function all() : array {
        return $this->storage;
    }

    public function add(ItemContract $item)
    {
        if (array_key_exists($item->id(), $this->storage)) {
            throw new Exception();
        }
        $this->storage[$item->id()] = $item;
        $this->eventEmitter->fire(new ItemAddedEvent($item));
        return $this;
    }

    public function has(string $id) : bool
    {
        return array_key_exists($id, $this->storage);
    }

    public function get(string $id) : ItemContract
    {
        return $this->storage[$id];
    }

    public function getAndRemove(string $id) : ItemContract
    {
        $item = $this->get($id);
        $this->remove($id);
        return $item;
    }

    public function remove(string $id)
    {
        $item = $this->storage[$id];
        unset($this->storage[$id]);
        $this->eventEmitter->fire(new ItemRemovedEvent($item));
        return $this;
    }

    public function total() : Money
    {
        $total = new Money(0, 'USD');
        foreach($this->storage as $item) {
            /** @var $item ItemContract */
            $total = $total->add($item->subtotal());
        }
        return $total;
    }

    public function jsonSerialize()
    {
        $items = [];
        foreach ($this->storage as $item) {
            /** @var $item ItemContract */
            array_push($items, $item->jsonSerialize());
        }
        return [
            'storage' => $items
        ];
    }

    public function fromStdObj(stdClass $obj) {
        foreach($obj->storage as $item) {
            $this->add(Item::fromStdObj($item));
        }
        return $this;
    }
}
