<?php

namespace App\Http\Livewire\Economia;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Fondo;
use App\Models\Taxista;
use App\Models\Gasto;
use App\Models\Ingreso;
use App\Models\Viaje;
use Livewire\Component;
use App\Jobs\SaveCierre;
use App\Models\CierreGasto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Cierre as ModelCierre;

class Cierre extends Component
{   
    public $cargado = false;

    public $lastCierre;

    public $fechas;

    public $empleados = [];
    public $listGatos = [];
    public $listViajes = [];
    public $listViajesEliminados = [];

    public $star , $end;

    public $ingresos = 0;

    // Sobre viajes
    public $importeTotal = 0;
    public $montoTotal   = 0;
    public $viajesTotal  = 0;
    public $viajesEliminados = 0;

    public $viajesDiarios = [];
    public $cantidadDiarios = [];
    public $viajesDiariosEliminados = [];
    public $cantidadDiariosEliminados = [];

    public $gastos = 0;
    public $salarios = 0;

    protected $listeners = ['loadState','setFecha'];

    public function mount(){

        $this->lastCierre = ModelCierre::orderBy('created_at','DESC')->first();

    }

    public function setFecha($fecha){
        dd($fecha);
    }

    public function render()
    {   
        return view('livewire.economia.cierre');
    }

    // Procesar Viajes
    public function procesarFecha(){

        $data = str_replace(' ','',$this->fechas);
        $data = explode('a',$data);

        $this->star = $data[0];
        $this->end  = $data[1];

        if($this->lastCierre){
            // Poner fecha minima en el ultimo cierre
            $f_init = new Carbon($this->star);
            $f_fin = new Carbon($this->lastCierre->end);
            if( $f_init <=  $f_fin){
                $this->emit('message',"La fecha de inicio no es válida. \n {$f_fin->addDay()->format('d-m-Y')} debería ser la correcta",'warning',4000);
                return null;
            }
        }

        // Poner fecha maxima en eldia actual -1
        $f_init = new Carbon($this->end);
        $f_fin = new Carbon();
        $f_fin = $f_fin->subDay();
        if( $f_init >  $f_fin){
            $this->emit('message',"La fecha final no es válida. \n {$f_fin->format('d-m-Y')} debería ser la correcta",'warning',4000);
            return null;
        }

        $this->sumViajes();
        $this->gastos = $this->sumGastos();
        //$this->sumSalarios();

        $this->cargado = true;
        $this->emit('endLoad');
        
        // Para eliminar error de salarios
        //$this->loadState();
    }


    // COnteo y suma en viajes
    private function sumViajes(){

        $this->viajesTotal = Viaje::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])->count(); 
        $this->viajesEliminados = Viaje::onlyTrashed()->whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])->count();
        
        $suma = Viaje::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])
                    ->where('colaborador_id',null)
                    ->selectRaw(" sum((costo * moneda_valor) * descuento) as Monto")
                    ->selectRaw(" sum((costo * moneda_valor)) as Importe")
                    ->first();
        
        $this->importeTotal = $suma->Importe;
        $this->montoTotal = $suma->Monto;

        $colab = Viaje::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])
                    ->where('colaborador_id','<>',null)
                    ->selectRaw(" sum((costo * moneda_valor) * descuento) as Monto")
                    ->selectRaw(" sum((costo * moneda_valor)) as Importe")
                    ->first();
        
        $this->importeTotal += $colab->Importe;
        $this->montoTotal += $colab->Monto/2;
    }

    // Suma de los Gastos en el periodo
    private function sumGastos(){
        return Gasto::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])->orWhere('fijo',true)->sum('valor');
    }

     // Suma de los Gastos en el periodo
     private function sumSalarios(){
        $this->empleados = User::whereNotIn('id',[1])->whereHas('roles', function($q){
            $q->where('name','Administrador')->orWhere('name','Comercial');
        })->get(); 
        
        foreach($this->empleados as $key => $empleado){
            $sal = $empleado->comercial->getSalario($this->star, $this->end,$this->montoTotal);
            $this->salarios += $sal;
            $this->empleados[$key]->salario = $sal;

        }
        //dd($this->empleados);
     }

    // Devuelve la cantidad de viajes por cada dia del periodo, muestra los eliminados
    private function getViajesDiarios(){

        $this->listViajes    = DB::select(DB::raw("SELECT DAY(`created_at`) AS dia, COUNT(*) AS cant FROM `viajes` WHERE `created_at` BETWEEN '{$this->star} 00:00:00' AND '{$this->end} 23:59:59' and `deleted_at` is null  GROUP BY DAY(`created_at`) "));
        
        $this->listViajesEliminados = DB::select(DB::raw("SELECT DAY(`created_at`) AS dia, COUNT(*) AS cant FROM `viajes` WHERE `created_at` BETWEEN '{$this->star} 00:00:00' AND '{$this->end} 23:59:59' and `deleted_at` is not null  GROUP BY DAY(`created_at`) "));
        

        foreach ($this->listViajes as $key => $value) {
            $this->viajesDiarios[$key]      = $value->dia;
            $this->cantidadDiarios[$key]   = $value->cant; 
        }

        
        foreach ($this->listViajesEliminados as $key => $value) {
            $this->viajesDiariosEliminados[$key]      = $value->dia;
            $this->cantidadDiariosEliminados[$key]   = $value->cant; 
        }

        

        //dd($this->viajesDiarios);
        $this->emit('paint',$this->viajesDiarios, $this->cantidadDiarios, $this->viajesDiariosEliminados,$this->cantidadDiariosEliminados);
        $this->emit('paintBalance',$this->gastos, $this->salarios, ( $this->montoTotal - ($this->gastos + $this->salarios)) );
    }

     // Cargar los Card
    public function loadState(){
        $this->sumSalarios();
        $this->listGatos = Gasto::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])->orWhere('fijo',true)->get();
        $this->getViajesDiarios();
        $this->emit('ready');

        $tmp = Ingreso::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])->selectRaw(" sum(valor) as ingresos")->first();
        $this->ingresos = $tmp->ingresos;
    }

    public function save(){
        
        // Cierre
        $cierre                     = new ModelCierre();
        $cierre->star               = $this->star;
        $cierre->end                = $this->end;
        $cierre->ingreso_semanal    = $this->getIngresosSemanales();
        $cierre->importe            = $this->importeTotal;
        $cierre->ingresos           = $this->ingresos;
        $cierre->ganancia           = $this->montoTotal;
        $cierre->viajes             = $this->viajesTotal;
        $cierre->viajes_eliminados  = $this->viajesEliminados;
        $cierre->administrador_id   = Auth::user()->id;
        $cierre->save();

        // Job para procesar el cierre en 2doPlano
        SaveCierre::dispatch($cierre ,$this->listGatos,$this->empleados,$this->listViajes,$this->listViajesEliminados);

        $this->emit('message', 'Cierre Realizado 😌','success',4500);
        return redirect()->route('show.cierre',$cierre->id);
        

    }

    public function getIngresosSemanales(){
        
        $temp = Fondo::whereBetween('created_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])
                                    ->selectRaw("sum(saldo) as ingresoSemalan")
                                    ->first();

        $taxistasEliminados = Taxista::onlyTrashed()
                                    ->whereBetween('deleted_at', [$this->star.' 00:00:00', $this->end.' 23:59:59'])
                                    ->selectRaw("sum(fondo) as fondos")
                                    ->first();    
        

       return ( $temp->ingresoSemalan - $taxistasEliminados->fondos );
    }
}
