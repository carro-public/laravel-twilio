<?php

namespace CarroPublic\LaravelTwilio\Request;

use Illuminate\Http\Request;
use Twilio\Security\RequestValidator;

class ValidateTwilioIncomingRequestSignature
{
     /**
      * Validate incoming request
      * https://www.twilio.com/docs/usage/webhooks/webhooks-security
      *
      * @param string $token
      * @param Request $request
      *
      * @return boolean
      */
    public static function isValidRequest($token, $request)
    {
        $signature = $request->server('HTTP_X_TWILIO_SIGNATURE');
        $url = $request->server('SCRIPT_URI');

        $validator = new RequestValidator($token);

        if ($validator->validate($signature, $url, $request->all())) {
            return true;
        }

        return false;
    }
}