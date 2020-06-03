<?php 
// Load composer

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\DB;

class StakeicxCommand extends UserCommand
{
	protected $name = 'ICXStaking calculation';                      // Your command's name
    protected $description = 'See current reward rate and calculate'; // Your command description
    protected $usage = '/stakeicx';                    // Usage of your command
    protected $version = '1.0.0';   

    public function execute()
    {
        $message = $this->getMessage();            // Get Message object
        $m = json_decode($message);
        $temp = explode(" ", $m->text);

        $chat_id = $message->getChat()->getId();   // Get the current Chat ID

        // $db->where ("id", 1);
        // $user = $db->getOne ("main_data");
        // 
        // 
        date_default_timezone_set ('UTC');

        $exchange = new \ccxt\binance (array (
            'verbose' => false,
            'timeout' => 30000,
        ));

        $symbol = 'ICX/USDT';
        $bnbdata = $exchange->fetch_ticker ($symbol);

        if ($result = DB::getPdo()->query('SELECT * FROM `main_data` WHERE `id` = 2')) {
            $result = $result->fetchAll();
            $json   = $result[0]['json_data'];

            $jsonData = json_decode($json);
        }


        
        $message = "\n<b>ICON(ICX): $". $bnbdata['last'] ."</b>\n\n";

        $message.= "Reward: <b>". $jsonData->reward ."%</b>\n";
        $message.= "Circulating Supply: <b>". number_format($jsonData->circulatingsupply,0) ." ICX</b>\n";
        // $message.= "Adj. Reward: ". $jsonData->adjreward ."%\n";
        // $message.= "Score: ". $jsonData->score ."%\n";
        $message.= "Total Staked: <b>". number_format($jsonData->stakedSupply, 0) . " ICX (". number_format(($jsonData->stakedSupply/$jsonData->circulatingsupply)*100,2) ."%)</b>\n";
        $message.= "Total Delegated: <b>". number_format($jsonData->delegatedSupply, 0) ." icx</b>\n\n";
        //$message .= "Visit : https://www.stakingrewards.com/asset/fantom";

        if(is_numeric(trim($temp[1])))
        {
            $yearly = number_format(($temp[1]*$jsonData->reward)/100, 0);
            $message .= "You are staking:  <b>". number_format($temp[1],0) . " ICX</b>\n\n";
            $message .= "You will get rewards:\n";
            $message .= "Yearly:  <b>". $yearly . " ICX / $".number_format($bnbdata['last']*(($temp[1]*$jsonData->reward)/100),0)."</b>\n";
            $message .= "Monthly:  <b>". number_format(($temp[1]*$jsonData->reward)/1200, 0) ." ICX / $".number_format((($temp[1]*$jsonData->reward)/1200)*$bnbdata['last'],0)."</b>\n\n";

            $message .= "Vote ICONVIET to support our team";
            if($temp[1] >= 100000)
            {
                $message .= "\n\n---------- --\n\n";
                $message .= "You are so rich, Babe. I love you @".$m->from->username;
            }
        }

        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => $message,
            'parse_mode' => 'HTML', // Set message to send
        ];

        return Request::sendMessage($data);        // Send message!
    }
               // Version of your command
}