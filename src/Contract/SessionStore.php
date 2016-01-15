<?php

namespace UntamedWorlds\Cart\Contract;

interface SessionStore
{
    /**
     * Put a key / value pair or array of key / value pairs in the session.
     *
     * @param  string|array  $key
     * @param  mixed       $value
     * @return void
     */
    public function put($key, $value);

    /**
     * Get an item from the store.
     *
     * @param string $key
     * @param string|null $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Remove an item from the store.
     *
     * @param string $key
     * @return void
     */
    public function remove($key);

    /**
     * Remove all of the items from the session.
     *
     * @return void
     */
    public function flush();
}
