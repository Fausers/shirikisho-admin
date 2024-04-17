<?php

namespace App\Models;

use App\Traits\PhoneNumberTrait;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextSMSModel extends Model
{
    use HasFactory;

    public function sendSms($recipientNumber, $message, $reference)
    {
        // Retrieve data from the request

        $phone_fomart = new PhoneNumberTrait;

        // Prepare request data
        $requestData = [
            'from' => 'RMNDR',
            'to' => trim($phone_fomart->clearNumber($recipientNumber),"+"),
            'text' => $message,
            'reference' => $reference
        ];

        try {
            // Initialize Guzzle client
            $client = new Client();

            // Send HTTP POST request
            $response = $client->post('https://messaging-service.co.tz/api/sms/v1/text/single', [
                'headers' => [
                    'Authorization' => 'Basic aHVtdGVjaDpIdW10ZWNoQDEyMw==',
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'json' => $requestData,
            ]);

            // Get response body
            // Check if the SMS was sent successfully
            if ($response->getStatusCode() === 200) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            // Handle exceptions (e.g., API request failed)
            return 'Error: ' . $e->getMessage();
        }
    }
}
