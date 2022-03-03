<?php

namespace CarroPublic\LaravelTwilio\Channels;

use CarroPublic\LaravelTwilio\LaravelTwilioMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Events\Dispatcher;
use CarroPublic\LaravelTwilio\LaravelTwilioManager;
use CarroPublic\LaravelTwilio\Events\SMSMessageSent;

class WhatsappChannel
{
    protected $manager;

    protected $events;

    public function __construct(LaravelTwilioManager $manager, Dispatcher $events = null)
    {
        $this->manager = $manager;
        $this->events = $events;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWhatsApp($notifiable);

        if (! $message instanceof LaravelTwilioMessage) {
            return;
        }

        if (! $to = $notifiable->routeNotificationFor('whatsapp', $notification) ) {
            if (! $to = $notifiable->routeNotificationFor(WhatsappChannel::class, $notification) ) {
                return;
            }
        }

        // Change to WhatsApp message
        $message->setAsWhapsApp();
        
        $messageInstance = $this->manager->sender($message->sender ?? null)->send($to, $message);

        if ($this->events) {
            $this->events->dispatch(
                new SMSMessageSent($messageInstance, $message->data)
            );
        }
    }
}