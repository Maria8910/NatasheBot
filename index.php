<?php

require 'vendor/autoload.php';

use Telegram\Bot\Api;

// Получение токена из переменной окружения
$telegramBotToken = getenv('TELEGRAM_BOT_TOKEN');

// Проверка, получен ли токен
if (!$telegramBotToken) {
    error_log("Токен бота не найден в переменных окружения!");
    exit(1); // Завершение скрипта с ошибкой
}

$telegram = new Api($telegramBotToken);

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

