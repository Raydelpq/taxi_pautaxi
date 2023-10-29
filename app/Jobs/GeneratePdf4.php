<?php

namespace App\Jobs; 

use App\Models\Viaje;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GeneratePdf4 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /*public $viajes;
    public $title;
    public $importe;
    public $monto;*/
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($viajes,$title,$importe,$monto) 
    {
        /*$this->title  = $title;
        $this->viajes  = $viajes;
        $this->importe = $importe;
        $this->monto   = $monto;*/

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
        $titulo = $this->data['title'];
        

        $pdf = Pdf::loadView('pdf.viajes', $this->data);
        $pdf->save(storage_path("pdf/{$titulo}.pdf"));
        return $pdf->download("{$titulo}.pdf");

        /*$pdf = PDF::setOptions ([
            'logOutputFile' => public_path( 'logs / log.htm' ),
            'tempDir' => public_path( 'logs /' )
       ])->loadView('pdf.viajes',['data'=> $this->data]);
       $pdf->save(storage_path("pdf/{$titulo}.pdf"));

        /*
        $pdf = PDF::setOptions ([
            'logOutputFile' => public_path( 'logs / log.htm' ),
            'tempDir' => public_path( 'logs /' )
       ])->loadView('reportes.corte',['corte'=>$corte]);
       return $pdf->download($titulo.'.pdf'); 
       */
    }
}
