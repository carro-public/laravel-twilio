<?php

namespace CarroPublic\LaravelTwilio;

use Twilio\Rest\Client;

class LaravelTwilio
{
    protected $client;
    
    /**
     * Initialize Twilio account sid and auth token
     */
    public function __construct(){
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
    public function sendSMS($to, $message, $from=null){

        $message = $this->client->messages->create(
            $to,
            [
                'from' => isset($from) ? $from : config('laraveltwilio.from'),
                'body' => $message
            ]
        );

        return $message->sid;
    }
}