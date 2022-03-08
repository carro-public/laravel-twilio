<?php

namespace CarroPublic\LaravelTwilio\Events;

class TwilioMessageSent
{
    /**
     * The SMS message instance.
     * @var \Twilio\Rest\Api\V2010\Account\MessageInstance
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
     * @param \Twilio\Rest\Api\V2010\Account\MessageInstance $message
     * @param array $data
     * @return void
     */
    public function __construct($message, $data = [])
    {
        $this->data = $data;
        $this->message = $message;
    }
}