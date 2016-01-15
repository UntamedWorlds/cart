<?php

namespace UntamedWorlds\Cart\Exceptions;

use Exception;

class InvalidQuantityException extends Exception
{
    protected $message = 'An invalid quantity was provided for a cart item.';
}
