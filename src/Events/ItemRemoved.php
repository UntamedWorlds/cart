<?php


namespace UntamedWorlds\Cart\Events;

use UntamedWorlds\Cart\Contract\Cart\Item;

class ItemRemoved
{
    /**
     * @var Item
     */
    public $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }
}
