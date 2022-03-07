<?php

namespace CarroPublic\LaravelTwilio\Channels;

use CarroPublic\LaravelTwilio\LaravelTwilioMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Events\Dispatcher;
use CarroPublic\LaravelTwilio\LaravelTwilioManager;
use CarroPublic\LaravelTwilio\Events\TwilioMessageSent;

class SMSChannel
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
        $message = $notification->toSMS($notifiable);

        if (! $message instanceof LaravelTwilioMessage) {
            return;
        }

        if (! $to = $notifiable->routeNotificationFor('sms', $notification)) {
            if (! $to = $notifiable->routeNotificationFor(SMSChannel::class, $notification)) {
                return;
            }
        }

        $messageInstance = $this->manager->sender($message->sender ?? null)->send($to, $message);

        if ($this->events) {
            $this->events->dispatch(
                new TwilioMessageSent($messageInstance, $message->data)
            );
        }
    }
}