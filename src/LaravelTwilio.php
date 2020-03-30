<?php

namespace CarroPublic\LaravelTwilio;

use Twilio\Rest\Client;

class LaravelTwilio
{
    /**
     * Set config
     *
     * @var array
     */
    protected $config;
    
    /**
     * Initialize Twilio account sid and auth token
     */
    public function __construct()
    {
        $this->config = [
            'account_sid' => config('laraveltwilio.account_sid'),
            'auth_token' => config('laraveltwilio.auth_token'),
            'from' => config('laraveltwilio.from'),
            'whats_app_from' => config('laraveltwilio.whats_app_from'),
        ];
    }

    /**
     * Send SMS
     * 
     * @param string $to
     * @param string $message
     * @param string $from
     * @param null|array $confg
     * 
     * @return string
     */
    public function sendSMS($to, $message, $from=null, $config=null)
    {
        if(is_null($config)) {
           $config = $this->$config; 
        }

        $client = new Client($config['account_sid'], $config['auth_token']);

        $message = $client->messages->create(
            $to,
            [
                'from' => isset($from) ? $from : $config['from'],
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
     * @param null|array $config
     * 
     * @return string
     */
    public function sendWhatsAppSMS($to, $message, $mediaUrl=[], $from=null, $prefix='whatsapp:', $config=null)
    {
        if(is_null($config)) {
            $config = $this->$config; 
         }
 
         $client = new Client($config['account_sid'], $config['auth_token']);

        $message = $client->messages->create(
            $prefix . $to,
            [
                'from' => $prefix . (isset($from) ? $from : $config['whatsapp_from']),
                'body' => $message,
                'mediaUrl' => $mediaUrl
            ]
        );

        return $message->sid;
    }
}