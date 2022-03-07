<?php

/**
 * 
 */

use Illuminate\Support\Facades\Notification;
use CarroPublic\LaravelTwilio\Channels\SMSChannel;
use CarroPublic\LaravelTwilio\Channels\WhatsappChannel;
use CarroPublic\LaravelTwilio\Notifications\GenericTwilioNotification;

if (! function_exists('send_sms')) {

    /**
     * Send a simple SMS message to $to with the content of $body
     * @param $to
     * @param $body
     * @param array $data
     * @return void
     */
    function send_sms($to, $body, $data = []) {
        Notification::route(SMSChannel::class, $to)
            ->notify(new GenericTwilioNotification($body, null, $data));
    }
    
}

if (! function_exists('send_whatsapp')) {

    /**
     * Send a simple WhatsApp message to $to with the content of $body
     * @param $to
     * @param $body
     * @param array $data
     * @return void
     */
    function send_whatsapp($to, $body, $data = []) {
        Notification::route(WhatsappChannel::class, $to)
            ->notify(new GenericTwilioNotification($body, null, $data));
    }

}