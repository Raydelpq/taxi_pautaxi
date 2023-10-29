<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Taxista;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class MigrateFondo extends Command
{
    protected $api = null;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:fondo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra el fondo de la version anterior del sistema';

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

            if($usuarioLocal != null){
                $taxista = $usuarioLocal->taxista;
                $taxista->fondo = $u->fondo;
                $taxista->update();
            }else
                $this->error($u->name.": ({$u->telefono}) No fue encontrado en la base de Datos Local");
        

            $bar->advance();
            
        }

        $bar->finish();

        $this->info("Fondos Actualizados");
        return Command::SUCCESS;
    }

}
