<?php

return [
    /**
     * Twilio Account SID
     */
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    
    /**
     * Twilio auth token
     */
    'auth_token' => env('TWILIO_AUTH_TOKEN'),

    /**
     * From phone number
     */
    'from' => env('TWILIO_FROM'),

    /**
     * WhatsApp from phone number
     */
    'whats_app_from' => env('TWILIO_WHATS_APP_FROM'),

    /**
     * List of production environments
     */
    'production_envs' => explode(',', env('TWILIO_PRODUCTION_ENVS', '')),

    /**
     * In case of testing, below is valid phone number
     */
    'valid_testing_numbers' => explode(',', env('TWILIO_TESTING_WHITELIST', ''))
];