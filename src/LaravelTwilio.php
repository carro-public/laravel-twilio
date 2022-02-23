<?php

namespace CarroPublic\LaravelTwilio;

use Twilio\Rest\Client;

class LaravelTwilio
{
    /**
     * Twilio Client
     *
     * @var Client
     */
    protected $client;
    
    /**
     * Initialize Twilio account sid and auth token
     */
    public function __construct()
    {
        $sid    = config('laraveltwilio.account_sid');
        $token  = config('laraveltwilio.auth_token');

        $this->client = new Client($sid, $token); 
    }

    /**
     * Send SMS
     * 
     * @param  string $to
     * @param  string $message
     * @param  string $from
     * @return void
     */
    public function sendSMS($to, $message, $from=null)
    {
        if ($this->isTesting() && !$this->isValidForTesting()) {
            logger()->info(
                "{$to} is not valid for testing. Please add your number as whitelist in TWILIO_TESTING_WHITELIST"
            );
            return;
        }

        $message = $this->client->messages->create(
            $to,
            [
                'from' => isset($from) ? $from : config('laraveltwilio.from'),
                'body' => $message
            ]
        );

        return $message->sid;
    }

    /**
     * Send whatsapp sms
     *
     * @param string $to
     * @param string $message
     * @param string $from
     * @param array  $mediaUrl
     * @param string $prefix
     * @return void
     */
    public function sendWhatsAppSMS($to, $message, $mediaUrl=[], $from=null, $prefix='whatsapp:')
    {
        if ($this->isTesting() && !$this->isValidForTesting()) {
            logger()->info(
                "{$to} is not valid for testing. Please add your number as whitelist in TWILIO_TESTING_WHITELIST"
            );
            return;
        }

        return $this->client->messages->create(
            $prefix . $to,
            [
                'from' => $prefix . (isset($from) ? $from : config('laraveltwilio.whatsapp_from')),
                'body' => $message,
                'mediaUrl' => $mediaUrl
            ]
        );
    }

    /**
     * Check if this current environment is testing
     * Which should not send data to PRODUCTION users
     * @return mixed
     */
    public function isTesting() {
        return app()->environment(config('laraveltwilio.testing_envs'));
    }

    /**
     * Check if the recipients is valid for testing
     * @return boolean
     */
    public function isValidForTesting($phoneNumber) {
        return in_array($phoneNumber, config('laraveltwilio.valid_testing_numbers'));
    }
}