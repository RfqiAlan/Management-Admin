<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    /**
     * Kirim pesan WhatsApp via Fonnte
     */
    public function send(?string $phone, string $message): void
    {
        if (!$phone || $message === '') {
            return;
        }

        // Ambil token dari tabel settings
        $token = Setting::getValue('wa_token');
        if (!$token) {
            // kalau belum diset, jangan kirim apa-apa
            return;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target'      => $phone,
                'message'     => $message,
                'countryCode' => '62',
            ]);
            
            // Log response untuk debugging
            logger()->info('WhatsApp sent', [
                'phone' => $phone,
                'status' => $response->status(),
                'response' => $response->json(),
            ]);
        } catch (\Throwable $e) {
            logger()->error('WA error: '.$e->getMessage());
        }
    }
}
