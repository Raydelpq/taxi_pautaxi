<?php

namespace App\Http\Livewire\Viajes;

use App\Models\Auto;


use App\Models\Opcion;
use App\Models\Horario;
use Livewire\Component;

class Calcular extends Component
{

    public $horarios;
    public $autos;

    public $parada;
    public $espera;
    public $equipaje;

    public $horario = 1, $minimo;

    public function mount(){
        $this->horarios = Horario::get();
        $this->autos = Auto::get();

        $this->espera = Opcion::where('clave','precio_espera')->first()->valor;
        $this->parada = Opcion::where('clave','precio_parada')->first()->valor;
        $this->equipaje = Opcion::where('clave','precio_equipaje')->first()->valor;

        $hora = date("H:m:s");
        
        $h = Horario::whereBetween(\DB::raw("time('".$hora."')"),[\DB::raw("time(`inicio`)"),\DB::raw("time(`fin`)")])->first();
        $this->horario = $h->id;
        $this->minimo = $h->precio_min;
        
    }

    public $rules = [
        'horario' => 'numeric'
    ];

    public function render()
    {
        return view('livewire.viajes.calcular');
    }

    public function getKm($auto){
        $h = Horario::find($this->horario);

        $kms = $h->autos()->where('auto_id',$auto)->first();

        return $kms->pivot->km;
    }

    public function getMinimo($auto_id,$horario_id){
        $a = Auto::find($auto_id);
        return $a->horarios()->where('horario_id',$horario_id)->first()->pivot->minimo;
    }
}
