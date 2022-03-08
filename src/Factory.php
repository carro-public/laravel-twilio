<?php

namespace CarroPublic\LaravelTwilio;

interface Factory
{
    /**
     * Get a mailer instance by name.
     *
     * @param  string|null  $name
     * @return \Twilio\Rest\Client
     */
    public function sender($name = null);
}