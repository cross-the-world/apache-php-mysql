<?php 

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

class FantomvietCommand extends UserCommand
{
	 protected $name = 'fantomviet';                      // Your command's name
    protected $description = 'FantomViet Validator info'; // Your command description
    protected $usage = '/fantomviet';                    // Usage of your command
    protected $version = '1.0.0';   

    public function execute()
    {
        $message = $this->getMessage();            // Get Message object

        $chat_id = $message->getChat()->getId();   // Get the current Chat ID

        $_message = "Fantomviet Validator Info \n\n";
        $_message .= "Validator ID: 13 \n";
        $_message .= "Validator Address: 0x6cbd00e92e7fcfa176a23449f55d3849e8018d08\n\n";
        $_message .= "Telegram (VN): t.me/fantom_vietnam \n";
        $_message .= "Telegram (EN): t.me/fantomviet \n";
        $_message .= "Website: www.fantomviet.com \n";


        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => $_message, // Set message to send
        ];

        return Request::sendMessage($data);        // Send message!
    }
               // Version of your command
}