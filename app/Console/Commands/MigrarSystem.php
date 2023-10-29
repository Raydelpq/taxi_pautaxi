<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Taxista;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class MigrarSystem extends Command
{
    protected $api = null;

    protected $fondo;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:system {--F|fondo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra los datos de la version anterior del sistema';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() 
    {
        $baseUrl = $this->ask('Entre la base de la URL');

        $api = $baseUrl."/api/users";


        $r = Http::acceptJson()->post($api);
        $users = json_decode($r->body());

        $bar = $this->output->createProgressBar(count($users));

        $bar->start();
        foreach($users as $u){
            

           $usuarioLocal = User::where('telefono',$u->telefono)->first();

            // Si ya se registro el usuario
            if($usuarioLocal == null){
                $user = new User();
                $user->name = $u->name;
                $user->apellidos = $u->apellidos;
                $user->telefono = $u->telefono;
                $user->email = $u->email;
                $user->password = Hash::make("12345678");
                
                
                $taxista = new Taxista();
                $taxista->aprobado = $u->aprobado == 'true' ? 1 : 0;
                $taxista->fondo = $u->fondo;
                $taxista->marca = $u->marca;
                $taxista->modelo = $u->modelo;
                $taxista->color = $u->color_taxi;
                $taxista->lic_operativa = $u->operativa == 'true' ? 1 : 0;;
                $taxista->aire = $u->aire_acondicionado == 'true' ? 1 : 0;
        
                $user->save();
                
                $taxista->user_id = $user->id;
                $taxista->save();
                
                $user->assignRole('Taxista');
            

                $slug = $u->slug;

                $img = str_replace(' ','%20',$u->avatar);
                $url = $baseUrl."/Taxistas/{$slug}/{$img}";         
                
                $response = Http::get($url);

                if(!$response->failed())
                    $user->addMediaFromUrl($url)->toMediaCollection('avatar');
                else
                    $this->error($user->name.": ({$user->telefono}) Avatar");

                $img = str_replace(' ','%20',$u->taxi_delantera);
                $url = $baseUrl."/Taxistas/{$slug}/{$img}";

                $response = Http::get($url);
                
                if(!$response->failed())
                    $taxista->addMediaFromUrl($url)->toMediaCollection('taxi');
                else
                    $this->error($user->name.": ({$user->telefono}) Taxi");
            }
             

            $bar->advance();
            
        }

        $bar->finish();
        $this->info("Migración de Datos Completada");
        return Command::SUCCESS;
    }

}
