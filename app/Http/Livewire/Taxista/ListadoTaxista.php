<?php

namespace App\Http\Livewire\Taxista;

use App\Models\User;
use App\Models\Taxista;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class ListadoTaxista extends Component
{   
    use WithPagination;

    public $title;
    public $search;

    public $filtro; // listado, con_deuda, por_aprobar, eliminados, con_lic_operativa, sin_lic_operativa, nuevos, sin_viajes, sin_viajes_el_mes, top
    //public $filtros = [];

    // Para ordenamiento
    public $orderBy;
    public $orden = 'ASC';

    protected $queryString = [
        'filtro',
        'search' => ['except' => ''],
        'orderBy',
        'orden',
    ];

    protected $listeners = ['delete','restar', 'aprobar'];

    public function mount(Request $request){

        /*if($request->filtro){
            $t = str_replace('_'," ",$request->filtro);
            $this->title = "Filtrando: ".ucwords($t);
        }else
            $this->title = "Listado de Taxistas";*/

        if(!$request->orderBy)
            $this->orderBy = 'name';

        if(!$request->orden)
            $this->orden = 'ASC';
    }

    public function render()
    {  
        
        if($this->filtro){
            $t = str_replace('_'," ",$this->filtro);
            $this->title = "Filtrando: ".ucwords($t);
        }else
            $this->title = "Listado de Taxistas";

        $build = User::select('users.*', 'taxistas.*')
                ->join('taxistas', 'users.id', '=', 'taxistas.user_id');

        // Orden
        $build->orderBy($this->orderBy,$this->orden);

        // Filtros
        // listado, con_deuda, por_aprobar, eliminados, con_lic_operativa, sin_lic_operativa, sin_viajes, sin_viajes_el_mes, top
        switch($this->filtro){
            case 'con_deuda' : {$build->where('fondo', '<=', 150); }
            break;
            case 'por_aprobar' : $build->where('aprobado', false);
            break;
            case 'eliminados' : $build->onlyTrashed();
            break;
            case 'con_lic_operativa' : $build->where('lic_operativa', true);
            break;
            case 'sin_lic_operativa' : $build->where('lic_operativa', false);
            break;
            case 'sin_viajes' : {}
            break;
            case 'sin_viajes_mes' : {}
            break;
            case 'top' : {}
            break;
            default: {  $this->title = "Filtrando: Listado"; }
            
        }
        
        // Is Search
        if($this->search != '')
            $build->where(function($query){
                $query->where('name','LIKE',"%{$this->search}%")
                      ->orWhere('apellidos','LIKE',"%{$this->search}%")
                      ->orWhere('telefono','LIKE',"%{$this->search}%");
            });

        $taxistas = $build->paginate(15);
        
        return view('livewire.taxista.listado-taxista',['taxistas' => $taxistas])->layoutData(['titulo' => "Listado de Taxistas"]);
    }


    public function delete($user_id){
        $user = User::find($user_id);
        $user->delete();
        $this->emit('message',"Taxista {$user->name} eliminado",'success');
    }

    public function restar($user_id){
        $user = User::onlyTrashed()->where('id',$user_id)->first(); 
        $user->restore();
        $this->emit('message',"Taxista {$user->name} restaurado",'success');
    }
    
    
    public function aprobar($user_id){
        $taxista = Taxista::where('user_id',$user_id)->first(); 
        $taxista->aprobado = true;
        $taxista->update();
        $this->emit('aprobado',$taxista->user->telefono);
        $this->emit('message',"Taxista {$taxista->user->name} Aprobado",'success'); 
    }
}
