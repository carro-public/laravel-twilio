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
    'from' => env('TWILIO_FROM')
];