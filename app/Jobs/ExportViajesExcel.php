<?php

namespace App\Jobs;

use App\Models\Colaboracion;
use Illuminate\Bus\Queueable;
use App\Exports\ViajesExports;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ExportViajesExcel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $star, $end, $colaborador_id, $user_id; 

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($star,$end,$colaborador_id = null,$user_id = null){
        $this->star = $star;
        $this->end = $end;
        $this->colaborador_id = $colaborador_id;
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        $c = Colaboracion::find($this->colaborador_id)->name;

       
        $fileName = "public/pdf/{$c}_{$this->star}_a_{$this->end}.xlsx";
        $file = "pdf/{$c}_{$this->star}_a_{$this->end}.xlsx";
        //$file = Storage::path( "public/pdf/Viajes_{$this->star}_a_{$this->end}.xlsx");
        
        //$fileName = str_replace('-','_',$fileName);

        $exp = $this->saveExcel($fileName);
        sleep(5);
        if( $exp )
            Auth::user()->addMediaFromDisk($file, 'public')->toMediaCollection('reporte');
    }

    public function saveExcel($fileName){
        return Excel::store(new ViajesExports($this->star,$this->end,$this->colaborador_id,$this->user_id), $fileName);
    }
}
