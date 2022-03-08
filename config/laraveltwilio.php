<?php

return [
    'default' => [
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
    ],
    
    'senders' => [
        /**
         * A sender have to contain: 
         * - account_sid
         * - auth_token
         * - from: For SMS
         * - whats_app_from: For WhapsApp
         * And wrapped by a sender name
         * Example:
         *     "singapore" => [
         *         "account_sid" => "",
         *         "auth_token" => "",
         *         "from" => "",
         *     ],
         */
    ],

    /**
     * Testing Enable Flag
     */
    'sandbox' => env('TWILIO_SANDBOX_ENABLE', false)
];