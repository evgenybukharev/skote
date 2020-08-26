<?php

namespace EvgenyBukharev\Skote;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;

class Skote
{
    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @var Container
     */
    protected $container;

    /**
     * Skote constructor.
     *
     * @param Dispatcher $events
     * @param Container  $container
     */
    public function __construct(Dispatcher $events, Container $container)
    {
        $this->events = $events;
        $this->container = $container;
    }


}
