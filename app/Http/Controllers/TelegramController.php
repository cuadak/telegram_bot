<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Site;

class TelegramController extends Controller 
{
    public function setWebhook()
    {
        $response = Telegram::setWebhook(['url' => env('TELEGRAM_WEBHOOK_URL')]);
	    dd($response);
    }

    public function commandHandlerWebHook()
    {
        $updates = Telegram::commandsHandler(true);
        $chat_id = $updates->getChat()->getId();        

        // Periksa apakah pesan dimulai dengan "/site"
        if (strpos($updates->getMessage()->getText(), '/site') === 0) {
            // Ekstrak site_id dari perintah
            $site_id = str_replace('/site ', '', $updates->getMessage()->getText());

            // Ambil siteData dari database
            $siteData = Site::where('site_id', $site_id)->first();

            // Memeriksa jika data tersedia
            if ($siteData) {
                // Format teks respons
                $responseText = sprintf(
                    'site_id: %s | category: %s | kabupaten: %s | kategorisasi_load: %s',
                    $site_id,
                    $siteData->category,
                    $siteData->kabupaten,
                    $siteData->kategorisasi_load
                );

                // Mengirim respons
                return Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $responseText,
                ]);
            } else {
                // Tangani kasus ketika data untuk site_id yang ditentukan tidak ditemukan
                return Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => 'Data tidak ada',
                ]);
            }
        }
    }
}
