<?php 

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;

class TestCommand extends UserCommand
{
    protected $name = 'Price';                      // Your command's name
    protected $description = 'See current reward rate'; // Your command description
    protected $usage = '/price';                    // Usage of your command
    protected $version = '1.0.0';   

    public function execute()
    {
        $message = $this->getMessage();            // Get Message object

        $m = json_decode($message);

        $temp = explode(" ", $m->text);

        $chat_id = $message->getChat()->getId();   // Get the current Chat ID

        date_default_timezone_set ('UTC');

        $exchange = new \ccxt\binance (array (
            'verbose' => false,
            'timeout' => 30000,
        ));

        // Get USDT Price 
        try {
            $symbol1 = strtoupper($temp[1]) . '/USDT';
            $item = $exchange->fetch_ticker($symbol1);
        } catch (\ccxt\RequestTimeout $e) {
                $errors[] = $e;
        } catch (\ccxt\DDoSProtection $e) {
            $errors[] = $e;
        } catch (\ccxt\AuthenticationError $e) {
           $errors[] = $e;
        } catch (\ccxt\ExchangeNotAvailable $e) {
            $errors[] = $e;
        } catch (\ccxt\NotSupported $e) {
            $errors[] = $e;
        } catch (\ccxt\NetworkError $e) {
            $errors[] = $e;
        } catch (\ccxt\ExchangeError $e) {
            $errors[] = $e;
        } catch (Exception $e) {
            $errors[] = $e;
        }
        
        $replied  = '';
        if(!empty($item['last']))
        {
            $replied .= "\n\n<b>" . $symbol1 ."</b> (Binance)\n\n";
            $replied .= 'Current Price:  <b>' . $item['last'] . " USDT</b>\n";
            $replied .= 'High:                 <b>' . $item['high'] . " USDT</b>\n";
            $replied .= 'Low:                  <b>' . $item['low'] . " USDT</b>\n";
            $replied .= '24h change:     <b>' . $item['percentage'] . "%</b>\n";
            $replied .= '24h Volume:     <b>' . number_format((int)$item['quoteVolume'], 0) . " USDT</b>\n";
            $replied .= "----------- --\n\n";
            $replied .= 'I love you, @'. $m->from->username;
        }
        else
        {
            $replied = "I am drunk, Can't tell";
        }

        // // Get USDT Price 
        // $symbol2 = strtoupper($temp[1]) . '/BTC';
        // $result2 = $exchange->fetch_ticker($symbol2);

        $data = [                                  // Set up the new message data
            'chat_id' => $chat_id,                 // Set Chat ID to send the message to
            'text'    => $replied,//'Price now is '. $result['last'], // Set message to send
            'parse_mode' => 'HTML', // Set message to send
        ];

        return Request::sendMessage($data);        // Send message!
    }
               // Version of your command
}