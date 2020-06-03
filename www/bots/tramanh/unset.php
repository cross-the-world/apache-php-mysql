<?php
/**
 * README
 * This file is intended to unset the webhook.
 * Uncommented parameters must be filled
 */
// Load composer
require_once '../api/vendor/autoload.php';
// Add you bot's API key and name
$bot_api_key  = '1157580728:AAHdO2cM2xTWs0-g3VA5Awo53L0c-rLQ_-8';
$bot_username = 'CryptoLifeVN_bot';
try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
    // Delete webhook
    $result = $telegram->deleteWebhook();
    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e->getMessage();
}