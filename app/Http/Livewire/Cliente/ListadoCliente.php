<?php

namespace App\Http\Livewire\Cliente;

use App\Models\Cliente;
use Livewire\Component;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class ListadoCliente extends Component
{   
    use WithPagination;

    public $title = "Listado de Clientes";
    public $search;
    public $filtro;

    // Para ordenamiento
    public $orderBy = 'numero';
    public $orden = 'Asc';

    protected $queryString = [
       'search' => ['except' => ''],
       'orderBy',
       'orden',
    ];

    public function mount(Request $request){

        if($request->orderBy)
            $this->orderBy = $request->orderBy;
        else
            $this->orderBy = 'numero';
        
        if($request->orden)
            $this->orden = $request->orden;
        else
            $this->orden = 'Asc';

        $this->filtro = "{$this->orderBy}-{$this->orden}";

    }

    public function render()
    {     
        $vals = explode('-', $this->filtro);
        
        $this->orderBy = $vals[0];
        $this->orden = $vals[1];

        if($this->orderBy == 'numero')
            $build = Cliente::orderBy($this->orderBy,$this->orden);
        else
            $build = Cliente::join('viajes', 'clientes.id','=','viajes.cliente_id')
                        ->where('viajes.deleted_at','=',null)
                        ->select('clientes.numero','clientes.id',\DB::raw("count('id') as total"))
                        ->groupBy('clientes.id')
                        ->orderBy('total',$this->orden);


        if($this->search != '')
            $build->where(function($query){
                $query->where('name','LIKE',"%{$this->search}%")
                      ->orWhere('numero','LIKE',"%{$this->search}%");
            });

        //dd($build->toSql());
        $clientes = $build->paginate(15);
            

        return view('livewire.cliente.listado-cliente',['clientes' => $clientes])->layoutData(['titulo' => $this->title]);
    }
}
