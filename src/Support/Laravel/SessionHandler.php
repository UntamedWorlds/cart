<?php

namespace UntamedWorlds\Cart\Support\Laravel;

use Illuminate\Session\Store;
use UntamedWorlds\Cart\Contract\SessionStore;

class SessionHandler implements SessionStore
{
    private $handler;

    /**
     * SessionHandler constructor.
     * @param Store $handler
     */
    public function __construct(Store $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @inheritdoc
     */
    public function put($key, $value)
    {
        $this->handler->put($key, $value);
    }

    /**
     * @inheritdoc
     */
    public function get($key, $default = null)
    {
        return $this->handler->get($key, $default);
    }

    /**
     * @inheritdoc
     */
    public function remove($key)
    {
        $this->handler->remove($key);
    }

    /**
     * @inheritdoc
     */
    public function flush()
    {
        $this->handler->flush();
    }
}
