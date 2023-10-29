<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Viaje;
use App\Models\Taxista;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TopTaxista extends Component
{
    
    public $star = null;
    public $end = null;

    public function render()
    {   
        $user = Auth::user();

        $build  = Taxista::join('viajes', 'taxistas.id','=','viajes.taxista_id')
                    ->select('taxistas.id',\DB::raw("count('id') as total"))
                    ->where('viajes.deleted_at',null);
                    //->groupBy('users.id')
                    //->orderBy('total','DESC')
                    //->get()
                    //->take(5);
                    
        
        if($this->star != null)
            $build->whereBetween('viajes.created_at',[$this->star." 00:00:00",$this->end." 23:59:59"]);
            
        $taxistas = $build->groupBy('taxistas.id')->orderBy('total','DESC')->get()->take(5);
    
        return view('livewire.dashboard.top-taxista',['taxistas' => $taxistas]);
    }

    public function getuser($taxista_id){
        return Taxista::find($taxista_id)->user;
    }
}
