<?php

namespace UntamedWorlds\Cart\Events;

use UntamedWorlds\Cart\Contract\Cart\Item;

class ItemAdded
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
