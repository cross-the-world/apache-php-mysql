<?php 
// Load composer

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\DB;

class OnexCommand extends UserCommand
{
	protected $name = 'onex';                      // Your command's name
    protected $description = 'See current reward rate'; // Your command description
    protected $usage = '/onex';                    // Usage of your command
    protected $version = '1.0.0';   

    public function execute()
    {
        $message = $this->getMessage();            // Get Message object

        $chat_id = $message->getChat()->getId();   // Get the current Chat ID

        if ($result = DB::getPdo()->query('SELECT * FROM `main_data` WHERE `id` = 1')) {
            $result = $result->fetchAll();
            $json   = $result[0]['json_data'];

            $jsonData = json_decode($json);
        }


        
        $_message  = "<strong>Current FTM holding on Exchange</strong> \n\n";
        $_message .= "Total: <strong>". $jsonData->oeTotal ."</strong>\n\n";
        $_message .= "Binace: <strong>". $jsonData->oeBinance ."</strong>\n\n";
        $_message .= "Bibox: <strong>". $jsonData->oeBibox ."</strong>\n\n";
        $_message .= "KuCoin: <strong>". $jsonData->oeKucoin ."</strong>\n\n";
        $_message .= "IDEX: <strong>". $jsonData->oeIdex ."</strong>\n\n";
        $_message .= "BitMax: <strong>". $jsonData->oeBitmax ."</strong>\n\n";
        $_message .= "HotBit: <strong>". $jsonData->oeHotbit ."</strong>\n\n";


        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => $_message,
            'parse_mode' => 'HTML', // Set message to send
        ];

        return Request::sendMessage($data);        // Send message!
    }
               // Version of your command
}