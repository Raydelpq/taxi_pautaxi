<?php

namespace App\Http\Livewire\Empleado;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Cierre;
use App\Models\Viaje;
use Livewire\Component;
use App\Models\Comercial;
use App\Jobs\OptimizeImagen;
use Illuminate\Http\Request;
use App\Models\Administrador;
use Livewire\WithFileUploads;

class ShowEmpleado extends Component
{   
    use WithFileUploads;

    public $title;

    public User $empleado;
    public $salario = 0;
    public $comercial_id;

    public $tab;

    public $avatar;
    public $avatarUrl;

    protected $queryString = ['tab'];
    protected $listeners = ['updateData','getData']; 

    public $viajesHoy;
    public $viajesSemana;
    public $viajesMes;
    public $viajesTotal;

    public $isEconomico;


    public $star;

    public function mount(Request $request,$id){

        if($request->tab)
            $this->tab = $request->tab;
        else
            $this->tab = 1;

        $this->empleado = User::withTrashed()->where('id',$id)->first(); 
        $this->comercial_id = $this->empleado->id;

        $this->salario = $this->empleado->comercial->getSalario(null,date('Y-m-d'));

        
        $this->isEconomico = $this->empleado->comercial->is_economico;

        if($this->empleado->getMedia('avatar')->first())
            $this->avatarUrl = $this->empleado->getMedia('avatar')->first()->getFullUrl();
        else
            $this->avatarUrl = asset('img/no-avatar.png');

        $this->title = 'Empleado: '.$this->empleado->name;


        $lastCierre = Cierre::orderBy('created_at','DESC')->first();
        if($lastCierre == null)
            $this->star = '2023-01-01';
        else{
            $last = new Carbon($lastCierre->end);
            $this->star = $last->addDay()->format('Y-m-d');
        }
        
    }

    public function render()
    {
        return view('livewire.empleado.show-empleado')->layoutData(['titulo'=>$this->title]);
    }

    // Guardar Avatar Luego que se seleccione
    public function saveAvatar(){ 
        
        if($this->empleado->getMedia('avatar')->first()) 
        $this->empleado->getMedia('avatar')->first()->delete();

        // Eliminar Imagen
        /*$file = $this->empleado->getMedia('avatar')->first()->getPath();
        unlink("{$file}");*/

        $this->empleado
            ->addMedia($this->avatar->getRealPath())->toMediaCollection('avatar');
        $this->avatar = null;

        $this->emit('message','Foto de Perfil Actualizada','success');
        $this->empleado = User::findOrFail($this->empleado->id);
        $this->avatarUrl = $this->empleado->getMedia('avatar')->first()->getFullUrl(); 

        $imgAvatar = $this->empleado->getMedia('avatar')->first();
        OptimizeImagen::dispatch($imgAvatar->getPath()); 

        $this->emit('message','Imangen Actualizada','success');
    }

    public function updateData(){
        $this->empleado = User::findOrFail($this->empleado->id);
    }

    public function getData(){
        $rol = $this->empleado->roles()->first()->name;
        
        $this->viajesHoy    = Viaje::where('taxista_id','<>',null)->whereDate('created_at',date('Y-m-d'))->where('comercial_id',$this->comercial_id)->where('model','App\\Models\\'.$rol)->count();

        $this->viajesSemana    = Viaje::whereBetween('created_at',[$this->star." 00:00:00",date('Y-m-d')." 23:59:59"])
                                      ->where('comercial_id',$this->comercial_id)
                                      ->where('model','App\\Models\\'.$rol)->count();

        $this->viajesMes    = Viaje::where('taxista_id','<>',null)->whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->where('comercial_id',$this->comercial_id)->where('model','App\\Models\\'.$rol)->count();
        $this->viajesTotal  = Viaje::where('taxista_id','<>',null)->where('comercial_id',$this->comercial_id)->where('model','App\\Models\\'.$rol)->count();

        $this->viajesHoy    += Viaje::where(function($q){
            $q->where('taxista_id',null)->where('colaborador_id','<>',null);
        })->whereDate('created_at',date('Y-m-d'))->where('comercial_id',$this->comercial_id)->where('model','App\\Models\\'.$rol)->count();

        $this->viajesMes    += Viaje::where(function($q){
            $q->where('taxista_id',null)->where('colaborador_id','<>',null);
        })->whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->where('comercial_id',$this->comercial_id)->where('model','App\\Models\\'.$rol)->count();
        
        $this->viajesTotal  += Viaje::where(function($q){
            $q->where('taxista_id',null)->where('colaborador_id','<>',null);
        })->where('comercial_id',$this->comercial_id)->where('model','App\\Models\\'.$rol)->count();

    }

    public function desactivar(){

        if($this->empleado->deleted_at == null){ 
            $this->empleado->delete();
            $this->emit('message','Empleado Desactivado','success');
        }else{
            $this->empleado->restore();
            $this->emit('message','Empleado Activado','success');
        }
    }

    public function setEconomico($id, $rol){
        $comercial = null;
        if($rol == 'Administrador')
            $comercial = Administrador::where('user_id',$id)->first();
        else
            $comercial = Comercial::where('user_id',$id)->first();

        $comercial->is_economico = $this->isEconomico;
        $comercial->update();

        if($this->isEconomico)
            $this->emit('message','El Usuario ha pasado a ser Económico','success');
        else
            $this->emit('message','El Usuario ha dejado de ser Económico','success');
    }
}
