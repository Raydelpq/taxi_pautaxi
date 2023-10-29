<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TelegramController extends Controller
{
    private $urlBot;
    private $updates;
    private $chat_id;

    /**
     * Create a new TelegramController instance.
     *
     * @param \Telegram\Bot\Api $bot
     */
    public function __construct($updates)
    {   $bot = env('TELEGRAM_BOT_TOKEN');
        $this->urlBot = "https://api.telegram.org/bot{$bot}";
        $this->updates = $updates;
        $this->chat_id = $updates['message']['from']['id'];
    }

    public function callback(){

        if(isset($this->updates['callback_data'])){
            \Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/call.log'),
            ])->info($this->updates['callback_data']);
        }


    }

    /**
     * Handle the /start command.
     *
     * @return \Illuminate\Http\Response
     */
    public function start()
    {  

        /*$data = http_build_query([
            'text' => 'Please select language;',
            'chat_id' => $update['message']['from']['id']
        ]);*/

        $keyboard_la_quiero = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => "\xF0\x9F\x9A\x95 La Quiero",
                        "callback_data" => "yo|1" //.$viaje_id
                    ]
                    
                ]
            ]
        ]);

        $data = http_build_query([
            'text' => "Informacion de la carrera",
            'chat_id' => $this->chat_id,
            'parse_mode' => 'HTML'
        ]);
        
        /*$keyboard_Viaje_Comercial = json_encode([
                "inline_keyboard" => [
                    [
                        [
                            "text" => "\xE2\x86\xA9 Cambiar",
                            "callback_data" => "change|".$chat_id."|".$message_id."|".$viaje_id
                        ]
                        
                    ],
                ]
            ]);*/
        
        //file_get_contents($this->urlBot . "/sendMessage?{$data}&reply_markup={$keyboard_la_quiero}");
        /*$response = Http::get($this->urlBot . '/sendMessage', [
            'text' => "Informacion de la carrera",
            'chat_id' => $this->chat_id,
            'parse_mode' => 'HTML',
            'reply_markup' => $keyboard_la_quiero
        ]);*/

        $p = http_build_query([
            'text' => "Get Contents",
            'chat_id' => $this->chat_id,
            'parse_mode' => 'HTML'
        ]);

        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/request.log'),
        ])->info(request());

        $options = array(

            'http'=>array(
        
                'method'=>"GET",
        
                'header'=>"Accept-language: es\r\n" .
        
                "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
        
                "User-Agent: ". request()->header->user_agent
        
            )
        
        );
        
        
        $context = stream_context_create($options);

        file_get_contents($this->urlBot . "/sendMessage?{$p}", false,$context);

            $json = [
                'chat_id'       => $this->chat_id,
                'text'          => 'Informacion de la carrera',
                'parse_mode'    => 'HTML'
            ];

        $this->http_post($this->urlBot.'/sendMessage',$json);

    }


    function http_post($url, $json)
    {
        $ans = null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); 
        try
        {
            $data_string = json_encode($json);
            // Disable SSL verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            // Will return the response, if false it print the response
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
            );
            $ans = json_decode(curl_exec($ch));
            if($ans->ok !== TRUE)
            {
                $ans = null;
            }
        }
        catch(Exception $e)
        {
            echo "Error: ", $e->getMessage(), "\n";
        }
        curl_close($ch);
        return $ans;
    }
    
}
