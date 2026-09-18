<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send a WhatsApp notification to the admin when a new email inquiry is received.
     */
    public static function notifyAdminNewEmail(string $name, string $phone, string $email, string $subject, string $messageText): bool
    {
        $adminWaNumber = SiteSetting::get('whatsapp_number') ?: '6281233020117';
        $senderEmail = $email ?: 'Tidak dicantumkan';

        $waText = "🔔 *NOTIFIKASI EMAIL MASUK (WEBSITE)*\n\n"
                 ."Halo Admin Airlangga Travel, ada pesan / inquiry baru masuk via Email Website:\n\n"
                 ."👤 *Nama:* {$name}\n"
                 ."📱 *No. WA:* {$phone}\n"
                 ."✉️ *Email:* {$senderEmail}\n"
                 ."📌 *Subjek:* {$subject}\n\n"
                 ."💬 *Pesan:* \n\"{$messageText}\"\n\n"
                 .'_Notifikasi ini dikirimkan otomatis oleh sistem website ketika pengunjung mengirim pesan/email._';

        Log::info("WhatsApp Notification sent to Admin ({$adminWaNumber}):", [
            'admin_phone' => $adminWaNumber,
            'customer_name' => $name,
            'customer_phone' => $phone,
            'subject' => $subject,
            'message' => $messageText,
        ]);

        // 1. Check Fonnte API
        $fonnteToken = env('FONNTE_TOKEN') ?: env('WA_GATEWAY_TOKEN');
        if ($fonnteToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => $fonnteToken,
                ])->post('https://api.fonnte.com/send', [
                    'target' => $adminWaNumber,
                    'message' => $waText,
                ]);

                Log::info('Fonnte WA Response: '.$response->body());

                return $response->successful();
            } catch (\Throwable $e) {
                Log::error('Fonnte WA Gateway API error: '.$e->getMessage());
            }
        }

        // 2. Check Wablas API
        $wablasToken = env('WABLAS_TOKEN');
        if ($wablasToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => $wablasToken,
                ])->post('https://kudus.wablas.com/api/send-message', [
                    'phone' => $adminWaNumber,
                    'message' => $waText,
                ]);

                Log::info('Wablas WA Response: '.$response->body());

                return $response->successful();
            } catch (\Throwable $e) {
                Log::error('Wablas WA Gateway API error: '.$e->getMessage());
            }
        }

        return true;
    }

    /**
     * Generate direct WhatsApp link for admin notification if needed.
     */
    public static function generateAdminWaUrl(string $name, string $phone, string $email, string $subject, string $messageText): string
    {
        $adminWaNumber = SiteSetting::get('whatsapp_number') ?: '6281233020117';
        // Clean leading plus or 0 to 62
        $cleanPhone = preg_replace('/[^0-9]/', '', $adminWaNumber);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62'.substr($cleanPhone, 1);
        }

        $senderEmail = $email ?: 'Tidak dicantumkan';

        $waText = "🔔 *NOTIFIKASI EMAIL MASUK (WEBSITE)*\n\n"
                 ."Halo Admin, ada pesan email baru dari Website:\n"
                 ."- Nama: {$name}\n"
                 ."- No WA: {$phone}\n"
                 ."- Email: {$senderEmail}\n"
                 ."- Subjek: {$subject}\n\n"
                 ."Pesan:\n{$messageText}";

        return 'https://wa.me/'.$cleanPhone.'?text='.rawurlencode($waText);
    }
}
