<?php

namespace App\Jobs; 

use App\Models\User;
use App\Models\Viaje;
use Illuminate\Bus\Queueable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GeneratePdf5 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,$viajes,$title,$importe,$monto) 
    {
        $this->user = $user;

        $this->data = [ 
            'title'   => $title,
            'viajes'  => $viajes,
            'importe' => $importe,
            'monto'   => $monto,
        ];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $titulo = str_replace(':','',$this->data['title']);

        $pdf = PDF::loadView('pdf.viajes', $this->data)->download()->getOriginalContent();
        
        Storage::disk('public')->put("pdf/{$titulo}.pdf", $pdf);
        
        $file = "pdf/{$titulo}.pdf";
        $this->user->addMediaFromDisk($file, 'public')->toMediaCollection('reporte');
    }
}
