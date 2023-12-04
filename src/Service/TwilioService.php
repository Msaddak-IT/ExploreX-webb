<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid = 'AC9819ca2341ba8cc86f9330f5c0d87e8b';
    private $authToken = 'a6c49e644a82375a2aff29c0feceb72d';
    private $twilioPhoneNumber = '+16503057168';

    public function sendSMS($to, $body)
    {
        $client = new Client($this->accountSid, $this->authToken);
        $client->messages->create(
            $to,
            [
                'from' => $this->twilioPhoneNumber,
                'body' => $body,
            ]
        );
    }
}
