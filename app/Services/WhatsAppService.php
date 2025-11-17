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
            Http::withHeaders([
                'Authorization' => $token,
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target'      => $phone,
                'message'     => $message,
                'countryCode' => '62', // biar ga usah pakai +62 di nomor
            ]);
        } catch (\Throwable $e) {
            // untuk sekarang cukup di-silent, atau bisa kamu log
            // logger()->error('WA error: '.$e->getMessage());
        }
    }
}
