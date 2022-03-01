<?php

namespace CarroPublic\LaravelTwilio\Facades;

use Illuminate\Support\Facades\Facade;
use CarroPublic\LaravelTwilio\LaravelTwilioManager;

class LaravelTwilio extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return LaravelTwilioManager::class;
    }
}
