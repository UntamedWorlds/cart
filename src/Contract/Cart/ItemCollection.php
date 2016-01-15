<?php

namespace UntamedWorlds\Cart\Contract\Cart;

interface ItemCollection
{
    /**
     * Add a single item to the cart.
     *
     * @param Item $item
     * @return $this
     */
    public function add(Item $item);

    /**
     * Get an item from the collection.
     *
     * @param string $id
     * @return Item
     */
    public function get(string $id) : Item;

    /**
     * Get an item from the cart and remove it.
     *
     * @param string $id
     * @return Item
     */
    public function getAndRemove(string $id) : Item;

    /**
     * Remove an item from the cart.
     *
     * @param string $id
     * @return $this
     */
    public function remove(string $id);
}
