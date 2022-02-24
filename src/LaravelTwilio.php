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
     * @return mixed
     */
    public function sendSMS($to, $message, $from=null)
    {
        $from = isset($from) ? $from : config('laraveltwilio.from');
        
        if (!$this->isProduction() && !$this->isValidForTesting($to)) {
            logger()->info(
                "{$to} is not valid for testing. The message instead will be printed to logger\n" .
                "Please add your number as whitelist in TWILIO_TESTING_WHITELIST to get the actual message in your device" .
                "===================\n" .
                "Content: {$message}\n" .
                "To: {$to}\n" .
                "From: {$from}" 
            );
            return "logger";
        }

        $message = $this->client->messages->create(
            $to,
            [
                'from' => $from,
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
     * @return mixed
     */
    public function sendWhatsAppSMS($to, $message, $mediaUrl=[], $from=null, $prefix='whatsapp:')
    {
        $from = $prefix . (isset($from) ? $from : config('laraveltwilio.whatsapp_from'));
        
        if (!$this->isProduction() && !$this->isValidForTesting($to)) {
            logger()->info(
                "{$to} is not valid for testing. The message instead will be printed to logger\n" .
                "Please add your number as whitelist in TWILIO_TESTING_WHITELIST to get the actual message in your device" .
                "===================\n" .
                "Content: {$message}\n" .
                "MediURL: {$mediaUrl}\n" .
                "From: {$from}\n" .
                "To: {$to}"
            );
            return "logger";
        }

        return $this->client->messages->create(
            $prefix . $to,
            [
                'from' => $from,
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
    public function isProduction() {
        return app()->environment(config('laraveltwilio.production_envs'));
    }

    /**
     * Check if the recipients is valid for testing
     * @return boolean
     */
    public function isValidForTesting($phoneNumber) {
        return in_array($phoneNumber, config('laraveltwilio.valid_testing_numbers'));
    }
}