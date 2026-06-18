<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public static function send($target, $message)
    {
        $token = config('services.fonnte.token');

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target'  => $target,
            'message' => $message,
        ]);

        Log::info('Fonnte response', [
            'target' => $target,
            'response' => $response->json()
        ]);

        return $response;
    }
}