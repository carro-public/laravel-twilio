<?php

namespace CarroPublic\LaravelTwilio\Events;

use CarroPublic\LaravelTwilio\LaravelTwilioMessage;

class TwilioMessageRejectedForSandbox
{
    /**
     * The SMS message instance.
     * @var LaravelTwilioMessage
     */
    public $message;

    /**
     * The message data.
     *
     * @var array
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param LaravelTwilioMessage $message
     * @param array $data
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}