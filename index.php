
<?php

require 'vendor/autoload.php';

use Telegram\Bot\Api;

$telegram = new Api('7691475160:AAHlJsZwuq3PfKLh8wnyp2q2gGgP_0myAAo'); // Замените на ваш токен

try {
    $updates = $telegram->getWebhookUpdates();

    foreach ($updates as $update) {
        $message = $update->getMessage();
        if ($message) {
            $chatId = $message->getChat()->getId();
            $text = $message->getText();

            if ($text == '/start') {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Привет! Это бот для Наташи на Render!',
                ]);
            }
        }
    }
} catch (Exception $e) {
    error_log($e->getMessage());
}

?>



