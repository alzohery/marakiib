<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MetaPixelService
{
    protected $client;
    protected $pixelId;
    protected $accessToken;
    protected $appSecret;

    public function __construct()
    {
        $this->client = new Client();
        $this->pixelId = env('FACEBOOK_PIXEL_ID');
        $this->accessToken = env('FACEBOOK_ACCESS_TOKEN');
        $this->appSecret = env('FACEBOOK_APP_SECRET');
    }

    public function sendEvent($eventName, $userData = [], $customData = [], $eventTime = null)
    {
        // Generate appsecret_proof
        $appsecretProof = hash_hmac('sha256', $this->accessToken, $this->appSecret);

        $url = "https://graph.facebook.com/v21.0/{$this->pixelId}/events?access_token={$this->accessToken}&appsecret_proof={$appsecretProof}";

        $payload = [
            'data' => [
                [
                    'event_name' => $eventName,
                    'event_time' => $eventTime ?? Carbon::now()->timestamp,
                    'event_id' => Str::uuid()->toString(),
                    'user_data' => $userData,
                    'custom_data' => $customData,
                    'action_source' => 'website',
                ]
            ]
        ];

        try {
            $response = $this->client->post($url, [
                'json' => $payload
            ]);

            \Log::info("Meta Pixel Event Sent: {$eventName}", [
                'response' => $response->getBody()->getContents()
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error("Failed to send Meta Pixel Event: {$eventName}", [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
