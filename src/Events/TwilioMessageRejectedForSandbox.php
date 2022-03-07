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
     * Receive phone number
     * @var
     */
    public $to;

    /**
     * Create a new event instance.
     *
     * @param $to
     * @param LaravelTwilioMessage $message
     */
    public function __construct($to, $message)
    {
        $this->to = $to;
        $this->message = $message;
    }
}