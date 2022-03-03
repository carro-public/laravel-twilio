<?php

namespace CarroPublic\LaravelTwilio;

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
     * @param array $data
     * @return LaravelTwilioMessage
     */
    public function data(array $data)
    {
        $this->data = $data;
        
        return $this;
    }

    /**
     * @param string $sender
     * @return LaravelTwilioMessage
     */
    public function sender(string $sender)
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
            "From" => $this->from,
            "Message" => $this->message,
            "Sender" => $this->sender,
            "IsWhatsApp" => $this->isWhatsApp,
            "Data" => $this->data,
        ], JSON_PRETTY_PRINT);
    }
}