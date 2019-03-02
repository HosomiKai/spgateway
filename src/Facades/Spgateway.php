<?php

namespace hosomikai\spgateway\Facades;

use Illuminate\Support\Facades\Facade;

class Spgateway extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'spgateway';
    }
}
