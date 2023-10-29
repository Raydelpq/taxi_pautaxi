<?php

namespace App\Http\Livewire\Taxista;

use App\Models\User;
use App\Models\Cambio;
use App\Models\Viaje;
use App\Models\Taxista;
use Livewire\Component;
use App\Jobs\OptimizeImagen;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    use WithFileUploads;
    
    public Taxista $taxista;

    public $tab;

    public $avatar;
    public $avatarUrl;

    protected $queryString = ['tab'];
    protected $listeners = ['updateData','getData','aprobar'];

    public $viajesHoy;
    public $viajesMes;
    public $viajesTotal;

    public function mount(Request $request, $id){

        if($request->tab)
            $this->tab = $request->tab;
        else
            $this->tab = 1;
        
        $this->taxista = Taxista::withTrashed()->where('id',$id)->first();  

        if($this->taxista->user->getMedia('avatar')->first())
            $this->avatarUrl = $this->taxista->user->getMedia('avatar')->first()->getFullUrl();
        else
            $this->avatarUrl = asset('img/no-avatar.png');

    }

    public function render()
    {
        return view('livewire.taxista.show')->layoutData(['titulo' => "Taxista > {$this->taxista->user->name}"]);
    }

    // Guardar Avatar Luego que se seleccione
    public function saveAvatar(){

        if(Auth::user()->id == $this->taxista->user->id){
            $cambio = new Cambio();
            $cambio->taxista_id = $this->taxista->id;
            $cambio->campo = 'avatar';
            $cambio->valor = null;
            $cambio->save();
            $cambio->addMedia($this->avatar->getRealPath())->toMediaCollection('avatar');

            $img = $cambio->getMedia('avatar')->first();
            OptimizeImagen::dispatch($img->getPath());
            $this->emit('message',"Informacion en Proceso de  Actualización. Debe esperar a que sea aprobada",'success',5000);

        }else{
            if($this->taxista->user->getMedia('avatar')->first())
                $this->taxista->user->getMedia('avatar')->first()->delete();

            $this->taxista->user->addMedia($this->avatar->getRealPath())->toMediaCollection('avatar');
            $this->avatar = null;

            $this->emit('message','Foto de Perfil Actualizada','success');
            $this->taxista = Taxista::findOrFail($this->taxista->id);
            $this->avatarUrl = $this->taxista->user->getMedia('avatar')->first()->getFullUrl();

            $imgAvatar = $this->taxista->user->getMedia('avatar')->first();
            OptimizeImagen::dispatch($imgAvatar->getPath());
        }

    }

    public function updateData(){
        $this->taxista = Taxista::findOrFail($this->taxista->id);
    }

    public function getData(){

        $this->viajesHoy    = Viaje::whereDate('created_at',date('Y-m-d'))->where('taxista_id',$this->taxista->id)->count();
        $this->viajesMes    = Viaje::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->where('taxista_id',$this->taxista->id)->count();
        $this->viajesTotal  = Viaje::where('taxista_id',$this->taxista->id)->count();

    }

    public function desactivar(){

        if($this->taxista->user->deleted_at == null){
            $this->taxista->user->delete();
            $this->emit('message','Taxista Desactivado','success');
        }else{
            $this->taxista->user->restore();
            $this->emit('message','Taxista Activado','success');
        }
    }


    public function aprobar($user_id){
        $taxista = Taxista::where('user_id',$user_id)->first(); 
        $taxista->aprobado = true;
        $taxista->update();
        $this->emit('aprobado',$taxista->user->telefono);
        $this->emit('message',"Taxista {$taxista->user->name} Aprobado",'success');
    }
}
