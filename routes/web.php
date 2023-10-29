<?php

use App\Models\Viaje;
use TelegramBot\Api\BotApi;
use Illuminate\Http\Request;
use App\Http\Livewire\Viajes\Crear;
use App\Http\Livewire\Auth\Registro;

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Divisas\Divisas;
use App\Http\Livewire\Taxista\Publico;
use App\Http\Livewire\Economia\Economia;
use App\Http\Livewire\Horarios\Horarios;
use App\Http\Livewire\Cliente\ShowCliente;
use App\Http\Livewire\Dashboard\Dashboard;
use App\Http\Livewire\Economia\ShowCierre;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Livewire\Viajes\ListadoViajes;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\TelegramController;
use App\Http\Livewire\Empleado\ShowEmpleado;
use App\Http\Controllers\DashboardController;
use App\Http\Livewire\Cliente\ListadoCliente;
use App\Http\Livewire\Configuracion\Opciones;
use App\Http\Livewire\Empleado\CrearEmpleado;
use App\Http\Livewire\Taxista\ListadoTaxista;
use App\Http\Livewire\Empleado\ListadoEmpleado;
use App\Http\Livewire\Viajes\Show as ShowViaje;
use App\Http\Livewire\Colaboracion\Colaboracion;
use App\Http\Livewire\Taxista\Show as TaxistaShow;
use App\Http\Livewire\Taxista\Cambio;
use NotificationChannels\Telegram\TelegramMessage;
use App\Http\Livewire\Configuracion\Horario\Horario;
use App\Http\Controllers\TelegramNotificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'login')->name('home');

Route::get('/taxista/public/{id}', Publico::class)->name('taxista.public'); 


//Route::post('/telegram/webhook/'.config('services.telegram-bot-api.webhook'), [TelegramNotificationController::class, 'store']);

Route::post('/telegram/webhook/'.config('services.telegram-bot-api.webhook'), function(Request $request){
    $updates = Telegram::getWebhookUpdates(); 

    $telegram = new TelegramController($updates);

   /*Log::build([
        'driver' => 'single',
        'path' => storage_path('logs/webhook.log'),
    ])->info($updates);*/

    if (isset($updates['callback_query'])) {
        $telegram->callback();
    }else{
        $telegram->start();
    }

    /*$bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));

    $bot->sendMessage($chatId, "Parece Bueno");*/

    
});


Route::get('/pp',function(){ 
    
    $viajes = Viaje::get();
    $titulo = "Cierre 2023-08-01 - 2023-08-13";

    return Excel::download(new App\Exports\ViajesExport, 'viajes.xlsx');
    return view('pdf.excel', [
        'viajes' => $viajes,'titulo' => $titulo
    ]);
});



Route::get('/register', Registro::class)->name('register');
Route::get('/terminos', function(){
    return view('terminos');
})->name('terminos');

Route::group(['middleware' => ['auth','role:Administrador|Comercial']],function(){

    Route::get('/viaje/add',Crear::class)->name('viaje.add');

});

Route::group(['middleware' => ['auth']],function(){  

    Route::get('/viaje/show/{id}',ShowViaje::class)->name('viajes.show')->middleware('propiedad'); 

    Route::get('/viaje/filter/', ListadoViajes::class)->name('viajes.list')->middleware('propiedad');

    // Mostrar Empleado
    Route::get('/empleado/show/{id}', ShowEmpleado::class)->name('empleado.show')->middleware('perfilEmpleado'); 

    // Rutas para Taxistas
    Route::get('/taxista',ListadoTaxista::class)->name('taxista');
    Route::get('/taxista/show/{id}', TaxistaShow::class)->name('taxista.show')->middleware('perfilTaxista');

});

Route::group(['middleware' => ['auth','role:Administrador']],function(){

    // Rutas de Gestion de Empleados
    Route::get('/empleado', ListadoEmpleado::class)->name('empleado.list'); 
    // Rutas de Gestion de Empleados
    Route::get('/empleado/add', CrearEmpleado::class)->name('empleado.add');
    

    // Ruta para gestion de Clienetes
    Route::get('/cliente', ListadoCliente::class)->name('cliente.list'); 
    // Mostrar cliente
    Route::get('/cliente/show/{id}', ShowCliente::class)->name('cliente.show');

    // Ruta para gestion de Economia
    Route::get('/economia', Economia::class)->name('economia'); 
    Route::get('/cierre/{id}', ShowCierre::class)->name('show.cierre');
    
    // Rutas de Gestion de Colaboraciones
    Route::get('/colaboracion', Colaboracion::class)->name('colaboracion'); 

    // Rutas de Gestion de Colaboraciones
    Route::get('/divisas', Divisas::class)->name('divisas'); 

    // Rutas de Gestion de Colaboraciones
    Route::get('/cambios', Cambio::class)->name('cambios'); 

    // Rutas de Gestion de Horarios y Autos
    Route::get('/horarios', Horarios::class)->name('horarios'); 

    // Rutas de Configuraciones Globales del Sistema
    Route::get('/configuracion', Opciones::class)->name('configuracion'); 

});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard1', [DashboardController::class, 'index'])->name('dashboard1');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    
    /*Route::fallback(function() {
        return view('pages/utility/404');  
    });   */ 
});