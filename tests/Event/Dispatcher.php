<?php

namespace UntamedWorlds\Cart\Tests\Event;

use UntamedWorlds\Cart\Contract\EventEmitter;
use Illuminate\Events\Dispatcher as UpstreamDispatcher;

class Dispatcher extends UpstreamDispatcher implements EventEmitter
{

}
