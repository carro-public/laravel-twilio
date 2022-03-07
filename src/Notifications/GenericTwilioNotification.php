<?php

namespace CarroPublic\LaravelTwilio\Notifications;

use Illuminate\Bus\Queueable;
use InvalidArgumentException;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use CarroPublic\LaravelTwilio\LaravelTwilioMessage;

class GenericTwilioNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $body;

    protected $channel;

    protected $from;
    
    protected $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($body, $channel = null, $data = [])
    {
        $this->body = $body;
        $this->channel = $channel;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable instanceof AnonymousNotifiable) {
            return array_keys($notifiable->routes);
        }

        if (is_null($this->channel)) {
            throw new InvalidArgumentException('There is no specified channel to send.');
        }

        return is_array($this->channel) ? $this->channel : [$this->channel];
    }

    public function toSMS($notifiable)
    {
        return (new LaravelTwilioMessage($this->body))->data($this->data)->from($this->from);
    }

    public function toWhatsApp($notifiable)
    {
        return (new LaravelTwilioMessage($this->body))->data($this->data)->from($this->from);
    }

    /**
     * @param string $from
     * @return self
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }
}
