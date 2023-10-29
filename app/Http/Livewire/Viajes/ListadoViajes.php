<?php

namespace App\Http\Livewire\Viajes;

use DateTime;
use App\Models\User;
use App\Models\Viaje;
use App\Models\Taxista;
use Livewire\Component;
use App\Models\Comercial;
use App\Jobs\GeneratePdf5;
use App\Models\Colaboracion;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\Administrador;
use App\Jobs\ExportViajesExcel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 

class ListadoViajes extends Component
{
    use WithPagination;

    public $modo;
    public $data;
    public $global;
    public $tipo_usuario;
    public $user;
    public $user_id;
    
    public $colaborador_id = null;

    public $pendientes = false;

    public $title;

    public $importe;
    public $monto;

    protected $queryString = ['user_id']; 

    protected $listeners= ['delete','reload'];

    public function mount(Request $request){  

        $this->modo = $request->modo; // fecha, rango, mes
        $this->data = $request->data;
        $this->global = $request->global;


        $agencia = '';
        if(isset($request->colaborador_id)){
            $this->colaborador_id = $request->colaborador_id;
            $agencia = '['.Colaboracion::find($this->colaborador_id)->name.']';
        }
        
        if(!$this->global){
            $this->tipo_usuario = $request->tipo_usuario;
            

            
            if($this->tipo_usuario =='Comercial'){
                $t = Comercial::where('user_id',$request->user_id)->first();
            }else
            if($this->tipo_usuario == 'Taxista'){

                $t = Taxista::find($request->user_id);

            }else
            if($this->tipo_usuario =='Administrador' && Auth::user()->hasRole('Administrador'))
                $t = Administrador::find($request->user_id);
            else
                return redirect()->back()->with('status','No Tiene Acceso a esta Sección');
            
        
            $this->user = $t->user;
            //$this->user_id = $t->id;

            $this->title = $agencia.' Viajes de '.$this->user->name.' por '.ucfirst($this->modo).': '.$request->data;
        }else
            $this->title = $agencia.' Viajes por '.ucfirst($this->modo).': '.$request->data;

    }

    public function render() 
    {   
        $build = null;
        $buildSuma = null;

        if($this->modo == 'fecha'){
            $build = Viaje::whereDate('created_at',$this->data);
            $buildSuma = Viaje::whereDate('created_at',$this->data)->where('colaborador_id',null)->where('taxista_id','<>',null);
            $buildColab = Viaje::whereDate('created_at',$this->data)->where('colaborador_id','<>',null);
        }else
        if($this->modo == 'rango'){
            
            $data = explode('a',$this->data);
            $start = str_replace(' ','',$data[0]);
            $end = str_replace(' ','',$data[1]);
            
            $build = Viaje::whereBetween('created_at',[$start." 00:00:00",$end." 23:59:59"]);
            $buildSuma = Viaje::whereBetween('created_at',[$start." 00:00:00",$end." 23:59:59"])->where('colaborador_id',null)->where('taxista_id','<>',null);
            $buildColab= Viaje::whereBetween('created_at',[$start." 00:00:00",$end." 23:59:59"])->where('colaborador_id','<>',null);
                
        }else
        if($this->modo == 'mes'){
            $data = explode('-',$this->data);
            $year = $data[0];
            $month = $data[1];

            $build = Viaje::whereMonth('created_at',$month)->whereYear('created_at',$year);
            $buildSuma = Viaje::where(function($query) use ($month,$year){
                $query->whereMonth('created_at',$month)->whereYear('created_at',$year);
            })->where(function($query){
                $query->where('colaborador_id',null)->where('taxista_id','<>',null);
            });
            $buildColab = Viaje::whereMonth('created_at',$month)->whereYear('created_at',$year)->where('colaborador_id','<>',null);
        }else
        if($this->modo == 'pendiente'){
            $this->pendientes = true;
            $build = Viaje::where('taxista_id','=',null);
            $buildSuma = Viaje::where('taxista_id','=',null)->where('colaborador_id',null);
            $buildColab = Viaje::where('taxista_id','=',null)->where('colaborador_id','<>',null);
        }

        if(!$this->global){
            
            if($this->tipo_usuario == 'Administrador' || $this->tipo_usuario == 'Comercial'){
               
                $build->where(function($q){
                    $q->where('comercial_id',$this->user->id);//->where('model','App\Models\\'.$this->tipo_usuario);
                });

                $buildSuma->where(function($q){
                    $q->where('comercial_id',$this->user->id);//->where('model','App\Models\\'.$this->tipo_usuario);
                });

                $buildColab->where(function($q){
                    $q->where('comercial_id',$this->user->id);//->where('model','App\Models\\'.$this->tipo_usuario);
                });

            }else
            if($this->tipo_usuario == 'Taxista'){
                $build->where(function($q){
                    $q->where('taxista_id',$this->user_id);
                });

                $buildSuma->where(function($q){
                    $q->where('taxista_id',$this->user_id);
                });

                $buildColab->where(function($q){
                    $q->where('taxista_id',$this->user_id);
                });
            }
        }

        if($this->colaborador_id){
            $build->where(function($q){
                $q->where('colaborador_id',$this->colaborador_id);
            });
        }

        /*if($this->pendientes){
            $build->where('taxista_id','=', null);
            $buildSuma->where('taxista_id','=', null);
        }else{
            $build->where('taxista_id','<>', null);
            $buildSuma->where('taxista_id','<>', null);
        }*/

        //dd($buildSuma->toSql());
        //dd($buildColab->paginate(20));

        $suma = $buildSuma->selectRaw(" sum( (costo * moneda_valor) * descuento) as Monto")->selectRaw(" sum((costo * moneda_valor)) as Importe")->first(); 
        $sumaColab = $buildColab->selectRaw("  sum( (costo * moneda_valor) * descuento) as Monto")->selectRaw(" sum((costo * moneda_valor)) as Importe")->first(); 
        
        //dd($suma->Importe , $sumaColab->Importe, $suma->Monto   , $sumaColab->Monto);

        $this->importe = $suma->Importe += $sumaColab->Importe;
        $this->monto   = $suma->Monto += ($sumaColab->Monto / 2);

        $viajes = $build->orderBy('created_at','Desc')->paginate(15);

        return view('livewire.viajes.listado-viajes', ['viajes' => $viajes,'suma' => $suma])->layoutData(['titulo'=>$this->title]);
    }

    public function exportar(){
        
        $build = null;

        if($this->modo == 'fecha'){
            $build = Viaje::whereDate('created_at',$this->data);
        }else
        if($this->modo == 'rango'){
            
            $data = explode('a',$this->data);
            $start = str_replace(' ','',$data[0]);
            $end = str_replace(' ','',$data[1]);
            
            $build = Viaje::whereBetween('created_at',[$start." 00:00:00",$end." 23:59:59"]);
                
        }else
        if($this->modo == 'mes'){
            $data = explode('-',$this->data);
            $year = $data[0];
            $month = $data[1];

            $build = Viaje::whereMonth('created_at',$month)->whereYear('created_at',$year);
        }else
        if($this->modo == 'pendiente'){
            $build = Viaje::where('taxista_id','=',null);
        }

        if(!$this->global){

            if($this->tipo_usuario == 'Administrador' || $this->tipo_usuario == 'Comercial'){
                $build->where(function($q){
                    $q->where('comercial_id',$this->user_id);//->where('model','App\Models\\'.$this->tipo_usuario);
                });

                /*$buildSuma->where(function($q){
                    $q->where('comercial_id',$this->user_id)->where('model','App\Models\\'.$this->tipo_usuario);
                });*/
            }else
            if($this->tipo_usuario == 'Taxista'){
                $build->where(function($q){
                    $q->where('taxista_id',$this->user_id);
                });

                /*$buildSuma->where(function($q){
                    $q->where('taxista_id',$this->user_id); 
                });*/
            }
        }

        
        $build->where(function($q){
            $q->where('taxista_id','<>', null)->orWhere('colaborador_id','<>',null);
        });

        if($this->colaborador_id){
            $build->where(function($q){
                $q->where('colaborador_id',$this->colaborador_id);
            });
        }

        $viajes = $build->orderBy('created_at','Desc')->get();

        GeneratePdf5::dispatch(Auth::user(),$viajes,$this->title,$this->importe,$this->monto);
        $this->emit('message',"Proceso En Ejecución \n Revise su sección de Reportes",'success');
    }

    

    public function exportarExcel(){
        $start = null;
        $end = null;
        if($this->modo == 'fecha'){
            $start = $this->data;
            $end = $this->data;
        }else
        if($this->modo == 'rango'){
            $data = explode('a',$this->data);
            $start = str_replace(' ','',$data[0]);
            $end = str_replace(' ','',$data[1]);
        }else
        if($this->modo == 'mes'){
            $data = explode('-',$this->data);
            $year = $data[0];
            $month = $data[1];

            $fecha = new DateTime("{$year}-{$month}-01");
            $fecha->modify('last day of this month');
            $d = $fecha->format('d');

            $start = "{$year}-{$month}-01";
            $end = "{$year}-{$month}-{$d}";
            
        }

        //dd($start,$end);
        $user_id = null;
        if($this->user != null)
            $user_id = $this->user->id;

        ExportViajesExcel::dispatch($start,$end,$this->colaborador_id,$user_id);
        $this->emit('message',"Proceso en Ejecución",'success');
    }

    // Eliminar Viaje
    public function delete($viaje_id){
        $viaje = Viaje::find($viaje_id);
        if($viaje->taxista_id != null)
            $viaje->taxista->addSaldo($viaje);
        $viaje->deleted_id = Auth::user()->id;
        $viaje->update();
        $viaje->delete();

        $this->emit('message',"Viaje eliminado",'success');         
    }

    public function reload($colaborador_id){
        $this->colaborador_id = $colaborador_id;
        $agencia = '['.Colaboracion::find($this->colaborador_id)->name.']';

        if(!$this->global){
            $this->title = $agencia.' Viajes de '.$this->user->name.' por '.ucfirst($this->modo).': '.$this->data;
        }else
            $this->title = $agencia.' Viajes por '.ucfirst($this->modo).': '.$this->data;
    }
    
}
