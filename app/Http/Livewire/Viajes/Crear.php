<?php

namespace App\Http\Livewire\Viajes;

use App\Models\Viaje;
use App\Models\Divisa;
use App\Models\Parada;
use App\Models\Cliente;
use App\Models\Taxista;
use Livewire\Component;
use App\Models\Colaboracion;
use Illuminate\Http\Request;
use App\Events\NewViajeEvent;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TelegramNotificationController;

class Crear extends Component
{

    public Viaje $viaje;
    public Taxista $modelTaxista;
    public $moneda_name;
    public $moneda;
    public $moneda_valor;
    public $paradas = [];

    public $taxista;
    public $info_taxista;
    public $cliente;
    
    public $otraFecha = false;
    public $fecha= null;
    
    public $options='';
    
    public $copy = false;
    public $edit = false;

    public $typeColaboracion = '';
    public $isColaboracion = false;
    public $colaborador = '';
    public $nameColaborador = '';

    public $otra_fecha = false;
    public $otra_fechaValor = null;

    protected $listeners = ['checkTaxista','getColaborador','setViajeCosto'];

    protected function rules(){

        $rules = [
            'paradas.*.nombre' => '',
            'viaje.costo' => 'required|numeric',
            'viaje.pasajeros' => 'numeric',
            'viaje.origen' => 'required',
            'viaje.destino' => 'required',
            'viaje.back' => 'required',
            'viaje.aire' => 'required',
            'viaje.observaciones' => '',
        ];
        
        if($this->isColaboracion){
            $rules['typeColaboracion'] = 'required|in:entrada,salida';

            if($this->typeColaboracion == 'entrada'){
                //$rules['cliente'] = 'required';
                $rules['taxista'] = 'required';
            }
        }
        else{
            $rules['taxista'] = 'required';
            $rules['cliente'] = 'required';
        }
        
        if($this->otraFecha)
            $rules['fecha'] = 'required';
            /*return [
                'taxista' => 'required',
                'cliente' => 'required',
                'fecha' => 'required',
                'paradas.*.nombre' => '',
                'viaje.costo' => 'required|numeric',
                'viaje.pasajeros' => 'numeric',
                'viaje.origen' => 'required',
                'viaje.destino' => 'required',
                'viaje.back' => 'required',
                'viaje.aire' => 'required',
                'viaje.observaciones' => '',
            ];*/
            

        /*return [
            'taxista' => 'required',
            'cliente' => 'required',
            'paradas.*.nombre' => '',
            'viaje.costo' => 'required|numeric',
            'viaje.pasajeros' => 'numeric',
            'viaje.origen' => 'required',
            'viaje.destino' => 'required',
            'viaje.back' => 'required',
            'viaje.aire' => 'required',
            'viaje.observaciones' => '',
        ];*/

        return $rules;
        
    }

    protected $validationAttributes = [

        'typeColaboracion' => 'tipo de colaboración'

    ];

    public function mount(Request $request){
        $this->modelTaxista = new Taxista();

        if($request->copy){
            $original = Viaje::findOrFail($request->copy);
            $array = $original->toArray();
            if($original->fecha){
                $fecha = $original->fecha->format('Y-m-d H:i:s');
                $array['fecha'] = $fecha;
            }
            
            unset($array['id']);

            $this->viaje = new Viaje();
            $this->moneda = $original->moneda;
            $this->moneda_valor = $original->moneda_valor;
            $this->moneda_name = $original->divisa->sigla;
            $this->viaje->costo = $original->costo;
            $this->viaje->pasajeros = $original->pasajeros;
            $this->viaje->origen = $original->origen;
            $this->viaje->destino = $original->destino;
            $this->viaje->observaciones = $original->observaciones;
            $this->paradas = $original->paradas()->get()->toArray();

            $this->viaje->back = $original->back;
            $this->viaje->aire = $original->aire;

            $this->copy = true;
            $this->cliente = $original->cliente->numero;

            //dd($original->paradas()->get()->toArray());

            if($original->fecha != null){
                $this->otraFecha = true;
                $this->fecha = $original->fecha; 
            }
           
            if($original->colaborador_id != null){
                $this->colaborador = $original->colaborador_id;
                $this->nameColaborador = $original->colaborador->name;
            }
        }else
        if($request->edit){
            
            $this->viaje = Viaje::findOrFail($request->edit);
            $this->moneda = $this->viaje->moneda;
            $this->moneda_valor = $this->viaje->moneda_valor;
            $this->moneda_name = $this->viaje->divisa->sigla;
            $this->paradas =  $this->viaje->paradas()->get()->toArray();

            $this->cliente = $this->viaje->cliente->numero;

            if($this->viaje->taxista)
            $this->taxista = $this->viaje->taxista->user->telefono; 

            if($this->viaje->fecha != null){
                $this->otraFecha = true;
                $this->fecha = $this->viaje->fecha;
            }

            $this->edit = true;
            if($this->viaje->colaborador_id != null){
                $this->colaborador = $this->viaje->colaborador_id;
                $this->nameColaborador = $this->viaje->colaborador->name;
                $this->typeColaboracion = $this->viaje->type_colaboracion;
            
            }
        }else{
            $m = Divisa::find(1);
            $this->moneda = $m->id;
            $this->moneda_valor = $m->valor;
            $this->moneda_name = $m->sigla;
            $this->viaje = new Viaje();
            $this->viaje->back = false;
            $this->viaje->aire = false;
        }
        
    }

    public function render()
    {   
        $colaboradores = Colaboracion::get();
        $divisas = Divisa::get();
        return view('livewire.viajes.crear',['colaboradores' => $colaboradores,'divisas' => $divisas])->layout('layouts.app',['titulo'=>'Crear Viaje']);  
    }

    public function trimCliente(){
        $this->cliente = str_replace('',' ',$this->cliente); 
        $this->cliente = str_replace('',')',$this->cliente); 
        $this->cliente = str_replace('','(',$this->cliente); 
        $this->cliente = str_replace('','-',$this->cliente); 
    }

    // Validar en tiempo real
    //public function updated($only){ return $this->validateOnly($only);}

    public function addParada(){
        array_push($this->paradas, new Parada());
    }

    public function delParada($key){
        unset($this->paradas[$key]);
    }


    // Checar el taxista
    public function checkTaxista(){
        
        $this->taxista = str_replace("+","",$this->taxista);
        $this->taxista = str_replace(" ","",$this->taxista);
        $this->taxista = str_replace(")","",$this->taxista);
        $this->taxista = str_replace("(","",$this->taxista);
        $this->taxista = str_replace("-","",$this->taxista);
        $len = strlen($this->taxista);

        //dd($this->taxista);

        if( substr($this->taxista,0,2) == 53 && $len == 10)
            $this->taxista = substr($this->taxista,2,$len);

        //dd($this->taxista);

        $t = Taxista::whereHas('user', function($query) {
            $query->where('telefono', $this->taxista)->where('aprobado',true);
        })->first();

        if($t == null){
            $this->modelTaxista = new Taxista();
            $this->viaje->taxista_id = null;
            $this->emit('notTaxista');
            return $this->emit('message',"No se ha encontrado el taxista. \n \n O aun no ha sido aprobado",'warning',4000);
        }

        $this->modelTaxista = $t;
        $this->modelTaxista->name = $this->modelTaxista->user->name;
        
        $this->emit('checkTaxistaOK',$this->modelTaxista);
    
    }


    // Guardar Viaje
    public function store(){ 

        $this->validate();

        // Usuario Logueado
        $user = Auth::user();

        // Poner taxista id en null si es copia
        $this->viaje->taxista_id = null; 

        //Agregar cliente al sistema
        $cliente = $this->clientes();

        $this->viaje->type_colaboracion = $this->typeColaboracion == '' ? null : $this->typeColaboracion;
        $this->viaje->moneda = $this->moneda;
        $this->viaje->moneda_valor = $this->moneda_valor;
        $this->viaje->descuento = $this->modelTaxista->id != null ? $this->modelTaxista->getDescuento() : env('DESCUENTO');
        $this->viaje->fondo_antes = $this->modelTaxista->fondo ? $this->modelTaxista->fondo : 0;
        $this->viaje->comercial_id = $user->id;
        $this->viaje->taxista_id = $this->modelTaxista->id; 
        $this->viaje->cliente_id = $cliente->id;

        if($this->colaborador != null)
            $this->viaje->colaborador_id = $this->colaborador;

        // Si es una reserva
        if($this->otraFecha)
            $this->viaje->fecha = $this->fecha;

        $this->viaje->model = "App\Models\\".$user->roles()->first()->name;

        if($this->otra_fechaValor != null ){
            $this->viaje->created_at = $this->otra_fechaValor;
            $this->viaje->updated_at = $this->otra_fechaValor;
        }

        $this->viaje->save(); 

        

        if(count($this->paradas) > 0)
        foreach ($this->paradas as $parada) {
            if($parada['nombre'] != ''){
                $newParada = new Parada();
                $newParada->nombre = $parada['nombre'];
                $newParada->viaje_id = $this->viaje->id;
                $newParada->save();
            }
        }


        // Enviar Viaje a Grupo de Telegram 
        if($this->viaje->taxista_id == null){
            $telegram = new TelegramNotificationController();
            $telegram->sendViaje($this->viaje);
            
        }else{
            // Descontar Saldo Al Taxista
            $user = Taxista::find($this->viaje->taxista_id);
            $user->delSaldo($this->viaje);
        }

        // Lanzar Evento
        event(new NewViajeEvent($this->viaje));

        return redirect()->route('viajes.show',$this->viaje->id);
    }



    // Editar Viaje
    public function edit(){
        $this->viaje->taxista_id = $this->modelTaxista->id;
        $viaje = Viaje::find($this->viaje->id);

        // Le agrego saldo al taxista que tiene la carrera
        if($viaje->taxista != null)
        $viaje->taxista->addSaldo($viaje);

        /*$mismo = true;
        $distintaMoneda = false;

        if($this->viaje->moneda != $viaje->moneda){
            if($viaje->taxista_id != null){
                $viaje->taxista->addSaldo($viaje);
                $distintaMoneda = true;
            }
        }
        $this->viaje->moneda_valor = $this->moneda_valor;
        

        if($viaje->taxista_id == null){
            $mismo = false;
            $this->viaje->fondo_antes = $this->modelTaxista->fondo ? $this->modelTaxista->fondo : 0;
        }else

        // Si no es el mismo taxista
        if($this->viaje->taxista_id != $viaje->taxista_id){ 
            //dd('Diferente Taxista');
            $mismo = false;

            // Si no se ha cambiado la moneda, se le reintegra el saldo al taxista.
            // Si se cambio la moneda, ya le fue reintegrado
            if($distintaMoneda == false){ 
                // Se busca el taxista anterior
                $taxistaOld = Taxista::find($viaje->taxista_id);
                // Se le reintegra el credito
                $taxistaOld->addSaldo($viaje); 
            }

        }
        
        // Si tiene precio diferente
        if($this->viaje->costo != $viaje->costo){
            
            if($mismo){
                if($viaje->taxista_id){
                    // Se busca el taxista anterior
                    $taxistaOld = Taxista::find($viaje->taxista_id);
                    // Se le reintegra el credito
                    $taxistaOld->addSaldo($viaje);
                    // Se retira el credito del viaje actual
                    $taxistaOld->delSaldo($this->viaje);
                }
            }else{
                if($this->viaje->taxista_id){
                    // Se busca el nuevo taxista
                    $user = Taxista::find($this->viaje->taxista_id);
                    // Se retira el credito del viaje actual
                    $user->delSaldo($this->viaje);
                }
            }
        }else{
            // Tienen el mismo precio

            if($mismo){ // Si es el mismo taxista
                if($viaje->taxista_id){
                    // Se busca el taxista anterior
                    $taxistaOld = Taxista::find($viaje->taxista_id);
                    // Se le reintegra el credito
                    $taxistaOld->addSaldo($viaje);
                    // Se retira el credito del viaje actual
                    $taxistaOld->delSaldo($this->viaje);
                }
            }else{
                if($this->viaje->taxista_id){
                    // Se busca el nueo taxista
                    $user = Taxista::find($this->viaje->taxista_id);
                    // Se retira el credito del viaje actual
                    $user->delSaldo($this->viaje);
                    // Se busca su fonado actual
                    $this->viaje->fondo_antes = $user->fondo; 
                }
            }

        }*/

        //Agregar cliente al sistema
        $cliente = $this->clientes();

        $this->viaje->moneda = $this->moneda;
        $this->viaje->descuento = $this->modelTaxista->getDescuento();
        
        $this->viaje->cliente_id = $cliente->id;

        // Si es una reserva
        if($this->otraFecha)
            $this->viaje->fecha = $this->fecha;
            $this->viaje->type_colaboracion = $this->typeColaboracion == '' ? null : $this->typeColaboracion;
        if($this->colaborador != '')
            $this->viaje->colaborador_id = $this->colaborador;
        else
        $this->viaje->colaborador_id = null;

        $this->viaje->update();

        // Descontar Saldo Al Taxista
        if($this->viaje->taxista_id != null){
            $user = Taxista::find($this->viaje->taxista_id);
            $user->delSaldo($this->viaje);
        }

        // Si hayparadas y son diferentes se eliminan
        if(count($viaje->paradas) > 0 )
            $viaje->paradas()->delete();

        foreach ($this->paradas as $parada) {
            if($parada['nombre'] != ''){
                $newParada = new Parada();
                $newParada->nombre = $parada['nombre'];
                $newParada->viaje_id = $this->viaje->id;
                $newParada->save();
            }
        }

        return redirect()->route('viajes.show',$this->viaje->id);
    }

    // Agregar Cliente
    protected function clientes(){
        $this->cliente = str_replace(' ','',$this->cliente); 
        $this->cliente = str_replace(')','',$this->cliente); 
        $this->cliente = str_replace('(','',$this->cliente); 
        $this->cliente = str_replace('-','',$this->cliente);
        

        $cliente = Cliente::where('numero',$this->cliente)->first();
        
        if($cliente == null){
            $cliente = new Cliente();
            $cliente->numero = $this->cliente; 
            $cliente->save();
        }

        return $cliente;
    } 
    
    public function getColaborador($id){
        
        if($id != ''){
            $this->isColaboracion  = true;
            $this->nameColaborador = Colaboracion::find($id)->tag;
        }else
            $this->isColaboracion  = false;
    }

    public function setViajeCosto($costo){
        $this->viaje->costo = $costo;
    }
}
