<?php

namespace EvgenyBukharev\Skote;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;

class Skote
{
    protected $events;

    protected $container;

    public function __construct(Dispatcher $events, Container $container)
    {
        $this->events = $events;
        $this->container = $container;
    }


}
