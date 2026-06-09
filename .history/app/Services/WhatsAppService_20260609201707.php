<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class WhatsAppService
{
    public static function send($target, $message)
    {
        $token = env('kMFM542FJeu9tSmA1XHv');

        return Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target'  => $target,
            'message' => $message,
        ]);
    }
}