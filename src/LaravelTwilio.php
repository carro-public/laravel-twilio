<?php

namespace CarroPublic\LaravelTwilio;

use Twilio\Rest\Client;

class LaravelTwilio
{
    protected $client;
    
    public function __construct(){
        $sid = config('laraveltwilio.account_sid');
        $token = config('laraveltwilio.auth_token');

        $this->client = new Client($sid, $token); 
    }

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