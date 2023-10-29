<?php

namespace App\Http\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Cierre;
use Livewire\Component;

class Dashboard extends Component
{   
    public $title = "Panel de Control";

    public $lastCierre;
    public $star = null;
    public $end = null;

    public function mount(){

        $this->lastCierre = Cierre::orderBy('created_at','DESC')->first();

        if($this->lastCierre != null){
            $date_s = new Carbon($this->lastCierre->end);
            $this->star = $date_s->addDay();
            $this->end = date('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard')->layoutData(['titulo' => $this->title]);
    }
}
