<?php

namespace App\Http\Livewire\Empleado;

use App\Models\User;
use Livewire\Component;

class ListadoEmpleado extends Component
{
    public $title = "Listado de Empleados";

    public $search = '';

    public $eliminados = false;

    protected $queryString = [
        'search' => ['except' => ''], 
    ];

    protected $listeners = ['delete','restar'];

    public function render()
    {
        $build = User::where('id','<>',1)->whereHas('roles', function($query){
            $query->where('name','Administrador')->orWhere('name','Comercial'); 
        });
                   
        if($this->search != '')
            $build->where(function($query){
                $query->where('name','Like', "%{$this->search}%")->orWhere('apellidos','Like', "%{$this->search}%")->orWhere('telefono','Like', "%{$this->search}%");
            });

        if($this->eliminados)
            $build->onlyTrashed();

        $empleados = $build->paginate(15);

        return view('livewire.empleado.listado-empleado',['empleados' => $empleados])->layoutData(['titulo' => "Listado de Empleados"]);
    }

    public function delete($user_id){
        $user = User::find($user_id);

        $this->emit('message',"Empleado(a) {$user->name} eliminado(a)",'success'); 

        $user->delete();
        
    }

    public function restar($user_id){
        $user = User::onlyTrashed()->where('id',$user_id)->first(); 

        $this->emit('message',"Empleado(a) {$user->name} restaurado(a)",'success'); 

        $user->restore();
        
    }
}
