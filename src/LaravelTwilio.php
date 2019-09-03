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
        return $this->client->messages->create(
            $prefix . $to,
            [
                'from' => $prefix . (isset($from) ? $from : config('laraveltwilio.whatsapp_from')),
                'body' => $message,
                'mediaUrl' => $mediaUrl
            ]
        );
    }
}