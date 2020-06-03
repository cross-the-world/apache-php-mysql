<?php 

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

class BtcCommand extends UserCommand
{
    protected $name = 'Btc';                      // Your command's name
    protected $description = 'See current price of BTC'; // Your command description
    protected $usage = '/btc';                    // Usage of your command
    protected $version = '1.0.0';   

    public function execute()
    {
        $message = $this->getMessage();            // Get Message object

        $chat_id = $message->getChat()->getId();   // Get the current Chat ID

        date_default_timezone_set ('UTC');

        $exchange = new \ccxt\binance (array (
            'verbose' => false,
            'timeout' => 30000,
        ));

        $symbol = 'BTC/USDT';
        $result = $exchange->fetch_ticker ($symbol);

        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => 'BTC Price : $'. $result['last'], // Set message to send
        ];

        return Request::sendMessage($data);        // Send message!
    }
               // Version of your command
}