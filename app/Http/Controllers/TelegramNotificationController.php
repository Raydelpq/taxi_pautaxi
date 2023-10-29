<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Notifications\TelegramNotification;
use NotificationChannels\Telegram\TelegramUpdates;

class TelegramNotificationController extends Controller
{
    private $botUrl;
    

    public function __construct(){
		$botToken = env('TELEGRAM_BOT_TOKEN');
	    $this->botUrl = "https://api.telegram.org/bot".$botToken;
	}

    // Genera el Mensade de un Viaje
    private function generarMensaje(Viaje $viaje){
        $Carrera = "";


        if ($viaje->fecha != null)
        $Carrera .= "<b>{$viaje->fecha->format('d/m/Y h:i A')}</b>\n";  

        $Carrera .= "<b>💲{$viaje->costo} {$viaje->moneda}";

        if($viaje->pasajeros != '')
            $Carrera .= "({$viaje->pasajeros} pax)";

        if($viaje->back)
            $Carrera .= " | Ida y Vuelta";

            $Carrera .= "</b>";

        if($viaje->aire)
            $Carrera .= "\n<b>❄️Taxi con Aire Acondicionado❄️</b>";

        // Agregar Origen
        $Carrera .= "\n\n<b>Origen:</b> {$viaje->origen}";

        foreach ($viaje->paradas as $index => $parada){
            $i = $index+1;
            $Carrera .= "Parada {$i}: {$parada->nombre}";
        }

        $Carrera .= "\n<b>Destino:</b> {$viaje->destino}";

        if($viaje->observaciones != ''){
            $obs = ltrim($viaje->observaciones);
            $obs = rtrim($viaje->observaciones);
            $Carrera .= "\n\n<b>✳️{$obs}✳️</b>";
        }

        return $Carrera;
    }
    
    
    public function send(Request $request)
    {
        $user = auth()->user();
        $user->notify(new TelegramNotification($request->notification));

        return back();

    }

    /**
     * Store Telegram Chat ID from telegram webhook message.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    //file_put_contents("registro_de_actualizaciones.log", $request->all().' \n', FILE_APPEND);
        /*try {
            $messageText = $request->message['text'];
        } catch (Exception $e) {
            return response()->json([
                'code'     => $e->getCode(),
                'message'  => 'Accepted with error: \'' . $e->getMessage() . '\'',
            ], 202);
        }*/

        Log::build([
            'driver' => 'single', 
            'path' => storage_path('logs/webhook.log'),
        ])->info($request->all());

        /*if (isset($request['callback_query'])) {
            $data = explode('|',$update['callback_query']['data']);
            Log::build([
                'driver' => 'single', 
                'path' => storage_path('logs/callback.log'),
            ])->info($data);
        }

        /*
        array (
            'update_id' => 671092996,
            'message' => 
            array (
              'message_id' => 16,
              'from' => 
              array (
                'id' => 1373986922,
                'is_bot' => false,
                'first_name' => 'Raydel',
                'username' => 'Raydelpq',
                'language_code' => 'es',
              ),
              'chat' => 
              array (
                'id' => -1001908398829,
                'title' => 'Soy Taxista',
                'type' => 'supergroup',
              ),
              'date' => 1689531755,
              'text' => 'Caramba',
            ),
        ); 
        */


        return response('Success', 200);
    }

    // Enviar una carrera al grupo de taxistas
	public function sendViaje(Viaje $viaje){ 

		// Identificador del Grupo de Telegram
		$chat_id = env('Grupo_Telegram');

		$keyboard = json_encode([
            //"inline_keyboard" => [
                [
                    [
                        "text" => "\xF0\x9F\x9A\x95 La Quiero",
                        "callback_data" => "yo"
                    ]
                    
                ]
            //]
        ]);

        $Carrera = $this->generarMensaje($viaje);

        /*$reply_markup = Telegram::InlineKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
        
        $response = Telegram::sendMessage([
            'chat_id' => $chat_id,
            'text' => $Carrera,
            'parse_mode' => 'HTML',
            'reply_markup' => $reply_markup
        ]);


		$url = $this->botUrl. "/sendMessage"; 
		
        $client = new \GuzzleHttp\Client();
		$response = $client->request('GET', $url, 
			['query' => [
					    'text' => $Carrera,
			            'chat_id' => $chat_id,
			            'parse_mode' => 'HTML',
			            'reply_markup' => $keyboard,
                        'show_alert' => false,
                        'cache_time' => 5,
					],
			'header' => [
						''
					]
			]
		);*/
	}
}
