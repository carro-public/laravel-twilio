<?php

namespace CarroPublic\LaravelTwilio;

use Illuminate\Database\Eloquent\Model;

class LaravelTwilioMessage
{
    /**
     * @var string
     */
    public $from;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $sender;

    /**
     * @var
     */
    public $mediaUrls;

    /**
     * @var array
     */
    public $data;

    /**
     * @var bool
     */
    public $isWhatsApp;
    
    public function __construct($message) {
        $this->message = $message;
        $this->data = [];
        $this->isWhatsApp = false;
    }

    /**
     * @param $from
     */
    public function from($from)
    {
        $this->from = $from;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }
    
    /**
     * @param $data
     * @return LaravelTwilioMessage
     */
    public function data($data)
    {
        $this->data = $data;
        
        return $this;
    }

    /**
     * @param $sender
     * @return LaravelTwilioMessage
     */
    public function sender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @param mixed $mediaUrl
     */
    public function mediaUrls($mediaUrls)
    {
        $this->mediaUrls = $mediaUrls;
        
        return $this;
    }

    /**
     * @param bool $isWhatsApp
     */
    public function setAsWhapsApp()
    {
        $this->isWhatsApp = true;
        
        return $this;
    }

    /**
     * Convert object to string for printing
     * @return false|string
     */
    public function toString() {
        return json_encode([
            "From" => $this->from ?? app()->make(LaravelTwilioManager::class)->sender()->getDefaultFrom(),
            "Message" => $this->message,
            "Sender" => $this->sender ?? 'default',
            "Type" => $this->isWhatsApp ? 'WhatsApp' : 'SMS',
            "Data" => $this->toArray($this->data),
            "MediaUrls" => $this->mediaUrls,
        ], JSON_PRETTY_PRINT);
    }

    /**
     * Deep transform to array
     * @param $data
     * @return array|mixed
     */
    protected function toArray($data) {
        if ($data instanceof Model) {
            return get_class($data) . " ~ Table=" . $data->getTable() . " ~ ID=" . $data->getQueueableId();
        }
        
        if (!is_array($data)) {
            return $data;
        }

        return array_map(function ($item) {
            return $this->toArray($item);
        }, $data);
    }
}