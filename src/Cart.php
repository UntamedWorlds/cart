<?php

namespace UntamedWorlds\Cart;

use UntamedWorlds\Cart\Contract\EventEmitter;
use UntamedWorlds\Cart\Contract\SessionStore;

class Cart
{
    private $session;
    private $event;
    private $instance;

    /**
     * Cart constructor.
     * @param SessionStore $session
     * @param EventEmitter $event
     * @param string $instance
     */
    public function __construct(
        SessionStore $session,
        EventEmitter $event,
        string $instance
    ) {
        $this->session = $session;
        $this->event = $event;
        $this->instance = $instance;
    }
}
