<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DeleteReporte extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:reporte';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina reportes Luego de 24h';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::get();

        foreach($users as $user){

            foreach($user->getMedia('reporte') as $reporte){

                $creado  = new Carbon($reporte->created_at);
                $creado = $creado->addHours(24); 

                $now = Carbon::now();

                if($now > $creado) {
                    $file = $reporte->getPath();
                    $this->info("Eliminando: {$file}");
                    unlink("{$file}");
                    $reporte->delete();
                }
            }

        }
    }
}
