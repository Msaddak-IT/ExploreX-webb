<?php
namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    

    public function sendSms(string $to, string $message): string
    {
        $twilioSid = $_ENV['TWILIO_SID'] ?? ''; // Using the null coalescing operator to provide a default value if not set
        $twilioAuthToken = $_ENV['TWILIO_AUTH_TOKEN'] ?? '';
        $twilioFromNumber = $_ENV['TWILIO_FROM_NUMBER'] ?? '';

        $twilio = new Client($twilioSid, $twilioAuthToken);

        $message = $twilio->messages
            ->create($to, [
                "from" => $twilioFromNumber,
                "body" => $message,
            ]);

        return $message->sid;
    }
}