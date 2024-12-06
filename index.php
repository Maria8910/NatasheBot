<?php
/*
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
}*/

$token = '7691475160:AAHlJsZwuq3PfKLh8wnyp2q2gGgP_0myAAo'; // Замените на ваш токен
$url = "https://api.telegram.org/bot{$token}/";

$update = json_decode(file_get_contents('php://input'), true);

if (isset($update['message']['text']) && $update['message']['text'] == '/start') {
  $chatId = $update['message']['chat']['id'];
  $response = send_message($chatId, "Привет!");
  echo $response;
}


function send_message($chatId, $text) {
  global $url;
  $data = array(
    'chat_id' => $chatId,
    'text' => $text
  );
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/json\r\n",
      'method'  => 'POST',
      'content' => json_encode($data)
    )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url . "sendMessage", false, $context);
  return $result;
}


?>

