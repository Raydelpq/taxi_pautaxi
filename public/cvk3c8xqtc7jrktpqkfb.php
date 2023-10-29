<?php
$update = json_decode(file_get_contents('php://input'), TRUE);

// Array de emoji
include('emoji.php');


//registro
$fecha = date('Y-m-d H:i:s');
file_put_contents("registro_de_actualizaciones.log", $fecha.' - '.json_encode($update).' \n', FILE_APPEND);

    $botToken = "1712280868:AAE7yg6PwM3PA6I6xPXV8yoo0-go5KgoyhI";
    $botAPI = "https://api.telegram.org/bot" . $botToken;
    
    // Create keyboard
        $data = http_build_query([
            'text' => 'Please select language;',
            'chat_id' => $update['message']['from']['id']
        ]);
        
        $keyboard_Taxista = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => "\xF0\x9F\x92\xB2 Saldo",
                        "callback_data" => "getsaldo"
                    ]
                    
                ],
                /*[
                    [
                        "text" => "\xF0\x9F\x92\xB0 Ganancia_Mes",
                        "callback_data" => "gananciames"
                    ],
                    [
                        "text" => "\xF0\x9F\x92\xB0 Ganancia_Hoy",
                        "callback_data" => "gananciahoy"
                    ]    
                ]*/
            ]
        ]);
        
       

    // Check if callback is set
    if (isset($update['callback_query'])) {
        $data = explode('|',$update['callback_query']['data']);
        
        if($data[0] === "getsaldo"){
            $chat_id = $update['callback_query']['from']['id'];
            $telegram_id = $update['callback_query']['from']['id'];
            getSaldo($botAPI,$update,$chat_id,$telegram_id, $keyboard_Taxista);
        }else
        if($data[0] === "yo"){
            $viaje_id = $data[1];
            
            $chat_id = $update['callback_query']['from']['id'];
            $message_id = $update['callback_query']['message']['message_id'];
            $telegram_id = $update['callback_query']['from']['id'];
            
            
            // Quiero el viaje
            $result = yoViaje($botAPI,$update,$chat_id,$message_id,$telegram_id,$viaje_id, $keyboard_Taxista);
            
            file_put_contents("result.log", $result, FILE_APPEND);
            
            if($result == false){ // Es un comercial
                
            }else
            if($result == true){ // Es un Taxista
                
                
            }
        }else
        if($data[0] === "quit"){
            
            $chat_id = $update['callback_query']['message']['chat']['id'];
            $message_id = $update['callback_query']['message']['message_id'];
            
            $grupo_message_id = $data[2];
            $viaje_id = $data[3];
            
            file_put_contents("click_quit.log", $grupo_chat_id.' -- '.$grupo_message_id.' -- '.$viaje_id.'\n    '.$chat_id.' -- '.$message_id, FILE_APPEND);
            
            $keyboard_la_quiero = json_encode([
                "inline_keyboard" => [
                    [
                        [
                            "text" => "\xF0\x9F\x9A\x95 La Quiero",
                            "callback_data" => "yo|".$viaje_id
                        ]
                        
                    ]
                ]
            ]);
            
            $urlRegistro = "http://www.blink.nat.cu/viaje/data?{$data}";
            $text = file_get_contents($urlRegistro);
            
            // Eliminar mensaje en el grupo
            $response = file_get_contents($botAPI . "/deleteMessage?chat_id=-1001477353077&message_id=".$grupo_message_id);
            
            // Eliminar mensaje local
            file_get_contents($botAPI . "/deleteMessage?chat_id=".$chat_id."&message_id=".$message_id);
        }
    }

    // Check for normal command
    $msg = $update['message']['text'];
    if ($msg === "/start") {

        // Create keyboard
        $data = http_build_query([
            'text' => 'Entre su Código de Activación',
            'chat_id' => $update['message']['from']['id']
        ]);

        file_get_contents($botAPI . "/sendMessage?{$data}");
    }else // END START
    if($msg === "/getsaldo"){
        $chat_id = $update['message']['from']['id'];
        $telegram_id = $update['message']['from']['id'];
        getSaldo($botAPI,$update,$chat_id,$telegram_id,$keyboard_Taxista);
        
}else
if(substr($msg,0,3) == 'BL-'){  // END getSaldo
        if( strlen(substr($msg,3,11)) != 8){
           $data = http_build_query([
            'text' => 'Un código correcto tiene 8 dígitos',
            'chat_id' => $update['message']['from']['id']
            ]);
            
            file_get_contents($botAPI . "/sendMessage?{$data}");
        }else{
            $data = http_build_query([
                'telegram_id' => $update['message']['from']['id'],
                'code' => substr($msg,3,11)
            ]);
            
            $urlRegistro = "http://www.blink.nat.cu/telegram/register?{$data}";
            $response = file_get_contents($urlRegistro);
            
            if($response != 'Código no Activado'){
                file_put_contents("registro_de_codigos.log", $response, FILE_APPEND);
                
                $r = json_decode($response);
                $keyboard = null;
                 
                switch($r->rol){
                    case 'Taxista':{
                        
                        $keyboard = ""; //$keyboard_Taxista;
                    }
                    break;
                    case 'Comercial':{
                        $keyboard = "";
                        
                    }
                    break;
                    case 'Administrador': {
                        $keyboard = "";
                    }
                }
                
                $data = http_build_query([
                    'text' => $r->text,
                    'chat_id' => $update['message']['from']['id'],
                    'parse_mode' => 'Markdown'
                ]);
                
                
                file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard}");
            }else{
                $data = http_build_query([
                    'text' => $response,
                    'chat_id' => $update['message']['from']['id']
                ]);
                
                
                file_get_contents($botAPI . "/sendMessage?{$data}");
            }
        }
    }
    
///////// Funciones //////////
    function getSaldo($botAPI,$update,$chat_id,$telegram_id,$keyboard){
        $data = http_build_query([
            'telegram_id' => $telegram_id
        ]);
        
        $urlSaldo = "http://www.blink.nat.cu/telegram/getSaldo?{$data}";
        $response = file_get_contents($urlSaldo);
        $r = json_decode($response);
        
        file_put_contents("registro_de_saldo.log", json_encode($response), FILE_APPEND);
        
       if($response != false)
            $dataT = http_build_query([
                'text' => $r->name." su saldo es de: <b>".$r->saldo." MN</b>",
                'chat_id' => $chat_id,
                'parse_mode' => 'HTML'
            ]);
        else
            $dataT = http_build_query([
                'text' => "La Cuenta no está asociada a un taxista",
                'chat_id' => $chat_id,
                    
            ]);
            
        file_get_contents($botAPI . "/sendMessage?{$dataT}");
        
        
        $data = http_build_query([
            'text' => '¿Que desea Hacer?',
            'chat_id' => $chat_id
        ]);
        file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard}");
    }
    
    // Quiero el viaje
    function yoViaje($botAPI,$update,$chat_id,$message_id,$telegram_id,$viaje_id,$keyboard){
        $data = http_build_query([
            'telegram_id' => $telegram_id,
            'viaje_id' => $viaje_id
        ]);
        
        
        $url = "http://www.blink.nat.cu/telegram/yo?{$data}";
        $response = file_get_contents($url);
        
        $r = json_decode($response);
        
        //file_put_contents("registro_de_YO.log", json_encode($output), FILE_APPEND);
        
        if($r->code == 404){ // Viae fue eliminado
            
           $dataT = http_build_query([
                'text' => "El viaje fue eliminado del sistema \xF0\x9F\x98\x94",
                'chat_id' => $chat_id,
                'parse_mode' => 'HTML'
                    
            ]);
            
            file_get_contents($botAPI . "/sendMessage?{$dataT}");
            
            return null;
        }else
        if($r->code == 400){ // Viaje ya fue solicitado
           
           $dataT = http_build_query([
                'text' => "Lo Sentimos <b>".$r->name."</b>, alguien le ganó en rapidéz \xF0\x9F\x98\x9C",
                'chat_id' => $chat_id,
                'parse_mode' => 'HTML'
                    
            ]);
            
            file_get_contents($botAPI . "/sendMessage?{$dataT}");
            
            return null;
        }else
        if($r->code == 201){ // Es un empleado
        
            
            $data = http_build_query([
                'text' => $r->datos,
                'chat_id' => $r->comercial,
                'parse_mode' => 'HTML'
            ]);
            
            $keyboard_Viaje_Comercial = json_encode([
                "inline_keyboard" => [
                    [
                        [
                            "text" => "\xE2\x9D\x8C Eliminar",
                            "callback_data" => "quit|".$chat_id."|".$message_id."|".$viaje_id
                        ]
                        
                    ]
                ]
            ]);
        
            file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard_Viaje_Comercial}");
            
            return false;
        } // END Comercial
        
        $dataT = http_build_query([
            'text' => "\xF0\x9F\x98\x83 <b>".$r->name."</b> esta vez has sido muy veloz.",
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML'
                
        ]);
        
        file_get_contents($botAPI . "/sendMessage?{$dataT}");
        
        $dataT = http_build_query([
            'text' => $r->datos,
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML'
                
        ]);
        
        file_get_contents($botAPI . "/sendMessage?{$dataT}");
        
        
        
        //Enviar datos al comercial
        $dataC = http_build_query([
            'viaje_id' => $viaje_id
                
        ]);
        $url = "http://www.blink.nat.cu/telegram/viaje/data/comercial?{$dataC}";
        $datosComercial = file_get_contents($url);
        
        
        $data = http_build_query([
            'text' => $datosComercial,
            'chat_id' => $r->comercial,
            'parse_mode' => 'HTML'
        ]);
        
        $keyboard_Viaje_Comercial = json_encode([
                "inline_keyboard" => [
                    [
                        [
                            "text" => "\xE2\x86\xA9 Cambiar",
                            "callback_data" => "change|".$chat_id."|".$message_id."|".$viaje_id
                        ]
                        
                    ],
                ]
            ]);
        
        file_get_contents($botAPI . "/sendMessage?{$data}&reply_markup={$keyboard_Viaje_Comercial}");
        
        // Modificar check
        $keyboard_selected = json_encode([
            "inline_keyboard" => [
                [
                    [
                        "text" => "\xE2\x9C\x85 \xE2\x9C\x85",
                        "callback_data" => " "
                    ]
                    
                ]
            ]
        ]);
        
        $dataG = http_build_query([
            'viaje_id' => $viaje_id
                
        ]);
        $url = "http://www.blink.nat.cu/telegram/viaje/data/grupo?{$dataG}";
        $text = file_get_contents($url);
        $reply_markup = $keyboard_selected;
        
        // Editar mensaje en el grupo
        $response = file_get_contents($botAPI . "/editMessageText?chat_id=-1001477353077&message_id=".$message_id."&text=".$text."&parse_mode=HTML&reply_markup={$reply_markup}");
        
        return true;
    }
