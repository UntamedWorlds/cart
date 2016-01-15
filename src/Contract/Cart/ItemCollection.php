<?php

namespace UntamedWorlds\Cart\Contract\Cart;

use JsonSerializable;
use stdClass;

interface ItemCollection extends JsonSerializable
{
    /**
     * Get all items being stored.
     *
     * @return array
     */
    public function all();

    /**
     * Add a single item to the cart.
     *
     * @param Item $item
     * @return $this
     */
    public function add(Item $item);

    /**
     * See if the collection has an item.
     *
     * @param string $id
     * @return bool
     */
    public function has(string $id);

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

    /**
     * Get the total of the items in the cart.
     */
    public function total();

    /**
     * Set storage from a json object.
     * @param stdClass $obj
     * @return self
     */
    public function fromStdObj(stdClass $obj);
}
