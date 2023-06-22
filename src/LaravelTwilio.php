<?php

namespace CarroPublic\LaravelTwilio;

use Twilio\Rest\Client;
use Twilio\Rest\Api\V2010\Account\MessageInstance;

class LaravelTwilio
{
    /**
     * Twilio Client
     *
     * @var Client[]
     */
    protected $clients;
    
    /**
     * Initialize Twilio account sid and auth token
     * @return Client
     */
    public function getClient()
    {
        $sid    = config('laraveltwilio.account_sid');
        $token  = config('laraveltwilio.auth_token');

        # Preserve Client instance of each $sid
        if (!isset($this->clients[$sid])) {
            $this->clients[$sid] = new Client($sid, $token);
        }
        
        return $this->clients[$sid];
    }

    /**
     * Send SMS
     * 
     * @param  string $to
     * @param  string $message
     * @param  string $from
     * @return string
     */
    public function sendSMS($to, $message, $from=null)
    {
        $message = $this->getClient()->messages->create(
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
     * @param array $contentParams
     * @return MessageInstance
     */
    public function sendWhatsAppSMS($to, $message, $mediaUrl=[], $from=null, $prefix='whatsapp:', $contentParams = [])
    {
        return $this->getClient()->messages->create(
            $prefix . $to,
            array_merge(
                [
                    'from' => $prefix . (isset($from) ? $from : config('laraveltwilio.whatsapp_from')),
                    'body' => $message,
                    'mediaUrl' => $mediaUrl
                ],
                $contentParams,
            )
        );
    }
}
