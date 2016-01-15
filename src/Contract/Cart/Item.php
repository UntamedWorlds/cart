<?php

namespace UntamedWorlds\Cart\Contract\Cart;

use \JsonSerializable;
use \stdClass;

interface Item extends JsonSerializable
{
    public function id();
    public function price();
    public function quantity();
    public function subtotal();
    public static function fromStdObj(stdclass $obj);
}
