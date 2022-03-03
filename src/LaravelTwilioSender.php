<?php

namespace CarroPublic\LaravelTwilio;

use Twilio\Rest\Api;
use Twilio\Rest\Client;
use Twilio\Rest\Api\V2010;
use Twilio\Rest\Api\V2010\Account\MessageInstance;

class LaravelTwilioSender
{
    /**
     * Twilio Client
     *
     * @var Client
     */
    protected $client;

    /**
     * Credentials array
     * @var array
     */
    protected $config;

    /**
     * @var bool Determine if running in sandbox mode
     */
    protected $testing;

    /**
     * @var \Closure Callback to determine if phone number is valid for sandbox
     */
    static $validPhoneForSandboxValidator;

    /**
     * Initialize Twilio account sid and auth token
     */
    public function __construct($config, $sandbox)
    {
        $this->config = $config;
        $this->sandbox = $sandbox;
        
        $this->client = new Client($config['account_sid'], $config['auth_token']);
    }

    /**
     * @param $to
     * @param LaravelTwilioMessage $message
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     */
    public function send($to, LaravelTwilioMessage $message) {
        $payload = [
            'from' => $message->from ?? $this->getDefaultFrom(),
            'body' => $message->message,
        ];

        if (!empty($message->mediaUrls)) {
            $payload['mediaUrl'] = $message->mediaUrls;
        }

        if ($this->sandbox && !$this->isValidForSandbox($to, $message->toString())) {
            return new MessageInstance(new V2010(new Api($this->client)), array_merge([
                'sid' => 'logger'
            ], $payload), $this->config['account_sid']);
        }

        return $this->client->messages->create(
            $message->isWhatsApp ? "whatsapp:" . $to : $to,
            $payload
        );
    }

    /**
     * Legacy method to send SMS
     * @param $to
     * @param $body
     * @param $from
     * @return MessageInstance
     */
    public function sendSMS($to, $body, $from) {
        $message = new LaravelTwilioMessage($body);
        $message->from($from);
        
        return $this->send($to, $message);
    }

    /**
     * * Legacy method to send WhatsApp Message
     * @param $to
     * @param $body
     * @param $mediaUrl
     * @param $from
     * @return MessageInstance
     */
    public function sendWhatsAppSMS($to, $body, $mediaUrl, $from) {
        $message = new LaravelTwilioMessage($body);
        $message->from($from);
        $message->mediaUrls(!is_array($mediaUrl) ? [$mediaUrl] : $mediaUrl);

        return $this->send($to, $message);
    }

    /**
     * Get default from phone number
     * @return mixed
     */
    public function getDefaultFrom() {
        return data_get(
            $this->config, 'from',
            data_get(
                $this->config, "default.from"
            )
        );
    }

    /**
     * Check if the recipients is valid for sandbox
     * Pass NULL to $warningMessage to disable logger message
     * @return boolean
     */
    public function isValidForSandbox($phoneNumber, $warningMessage = "") {
        $isValid = false;

        if (self::$validPhoneForSandboxValidator) {
            $isValid = call_user_func(self::$validPhoneForSandboxValidator, $phoneNumber);
        }

        if (!$isValid && !is_null($warningMessage) && function_exists('logger')) {
            logger()->info(
                "{$phoneNumber} is not valid for sandbox. The message instead will be printed to logger\n" .
                "Either turn off sandbox mode [TWILIO_SANDBOX_ENABLE] or registerValidPhoneValidator to check valid.\n" .
                "===================\n" .
                "{$warningMessage}\n" .
                "===================\n"
            );
        }
        
        return $isValid;
    }

    /**
     * This closure will be called to determine if recipient address is valid for sandbox
     * @param $validator
     * @return void
     */
    public static function registerValidPhoneForSandbox($validator) {
        self::$validPhoneForSandboxValidator = $validator;
    }
}