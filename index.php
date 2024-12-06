<?php
// Токен бота.  РЕКОМЕНДУЕТСЯ использовать переменную окружения вместо жесткого кодирования!
$token = "7691475160:AAHlJsZwuq3PfKLh8wnyp2q2gGgP_0myAAo"; 
if (!$token) {
    die("Токен бота не задан!");
}

$url = "https://api.telegram.org/bot{$token}/";

$update = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("Ошибка декодирования JSON: " . json_last_error_msg());
    http_response_code(400); // Отправляем код ошибки 400 (Bad Request)
    die();
}


if (isset($update['message']['text'])) {
    $text = $update['message']['text'];
    $chatId = $update['message']['chat']['id'];

    if ($text === '/start') {
        $response = sendMessage($chatId, "Привет!  Напиши /help для справки.");
    } elseif ($text === '/help') {
        $response = sendMessage($chatId, "Доступные команды: /start, /help.");
    } else {
        $response = sendMessage($chatId, "Я не понимаю эту команду.");
    }

    if ($response === false) {
        http_response_code(500); // Отправляем код ошибки 500 (Internal Server Error)
        die("Ошибка отправки сообщения");
    }

    echo $response; // Важно!  Отправляем ответ Telegram API

}

function sendMessage($chatId, $text) {
    global $url;
    $data = array(
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'html' //Добавил для поддержки HTML
    );
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
            'timeout' => 10 // Добавил таймаут
        )
    );
    $context  = stream_context_create($options);
    $result = @file_get_contents($url . "sendMessage", false, $context); // @ подавляет warning
    if ($result === false) {
        return false;
    }
    $response = json_decode($result, true);
    return $response['ok'] ? $result : false; // Возвращаем true/false в зависимости от ответа
}

?>

