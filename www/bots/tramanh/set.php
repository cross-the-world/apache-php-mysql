<?php
// Load composer
require '../api/vendor/autoload.php';

//$bot_api_key  = '1069457459:AAGvzsJor8KCwpIuDgavK_oCWOd_O-6jM08';
$bot_api_key  = '1157580728:AAHdO2cM2xTWs0-g3VA5Awo53L0c-rLQ_-8';
$bot_username = 'CryptoLifeVN_bot';
$hook_url     = 'https://www.fantomviet.com/telegram/hook.php';

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);

    // Set webhook
    $result = $telegram->setWebhook($hook_url);
    if ($result->isOk()) {
        echo $result->getDescription();
    }else{
    	echo "Can not set hook";
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    // log telegram errors
    // echo $e->getMessage();
}