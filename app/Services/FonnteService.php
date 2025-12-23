<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected $token;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
    }

    public function sendMessage($target, $message)
    {
        if (empty($this->token)) {
            return [
                'status' => false,
                'reason' => 'Fonnte token is missing. Please check your .env file and ensure FONNTE_TOKEN is set.',
            ];
        }

        // Remove non-numeric characters
        $target = preg_replace('/[^0-9]/', '', $target);

        // Convert 08... to 628...
        if (substr($target, 0, 1) === '0') {
            $target = '62' . substr($target, 1);
        }

        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->asForm() // Ensure it's sent as x-www-form-urlencoded
          ->retry(3, 2000) // Retry up to 3 times with a 2-second delay between attempts
          ->timeout(60)    // Increased total timeout to 60 seconds
          ->connectTimeout(30) // Increased connection/DNS resolution timeout to 30 seconds
          ->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
            'countryCode' => '62',
        ]);

        return $response->json();
    }
}
