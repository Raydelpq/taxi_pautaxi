<?php

namespace App\Http\Livewire\Taxista;

use App\Models\Taxista;
use App\Models\Cambio;
use Livewire\Component;
use App\Jobs\OptimizeImagen;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Auto extends Component
{
    use WithFileUploads;

    public $auto;
    public $autoUrl;

    public Taxista $taxista;

    protected $rules = [
        'taxista.marca' => "required",
        'taxista.modelo' => "required",
        'taxista.color' => "required",
        'taxista.aire' => "",
        'taxista.lic_operativa' => ""
    ];

    public function mount($taxista){

        $this->taxista = $taxista;

        if($this->taxista->getMedia('taxi')->first())
            $this->autoUrl = $this->taxista->getMedia('taxi')->first()->getFullUrl();
        else
            $this->autoUrl = asset('img/taxi.png');

    }

    public function render()
    {
        return view('livewire.taxista.auto');
    }

    // Guardar Taxi Luego que se seleccione
    public function saveAuto(){
        
        
        if(Auth::user()->id == $this->taxista->user->id){
            $cambio = new Cambio();
            $cambio->taxista_id = $this->taxista->id;
            $cambio->campo = 'taxi';
            $cambio->valor = null;
            $cambio->save();
            $cambio->addMedia($this->auto->getRealPath())->toMediaCollection('taxi');

            $img = $cambio->getMedia('taxi')->first();
            OptimizeImagen::dispatch($img->getPath());
            $this->emit('message',"Informacion en Proceso de  Actualización. Debe esperar a que sea aprobada",'success',5000);

        }else{
            if( $this->taxista->getMedia('taxi')->first()) 
                $this->taxista->getMedia('taxi')->first()->delete();

            $this->taxista->addMedia($this->auto->getRealPath())->toMediaCollection('taxi');
            $this->auto = null;

            $this->emit('message','Foto del Auto Actualizada','success');
            $this->taxista = Taxista::findOrFail($this->taxista->id);
            $this->autoUrl = $this->taxista->getMedia('taxi')->first()->getFullUrl();

            $imgAvatar = $this->taxista->getMedia('taxi')->first();
            OptimizeImagen::dispatch($imgAvatar->getPath());
            $this->emit('message',"Informacion Actualizada",'success');
        }
        
    }

    public function change(){
        $this->validate();

        if(Auth::user()->id == $this->taxista->user->id){

            $userOriginal = Taxista::find($this->taxista->id);

            if($userOriginal->marca != $this->taxista->marca){
                $cambio = new Cambio();
                $cambio->taxista_id = $this->taxista->id;
                $cambio->campo = 'marca';
                $cambio->valor = $this->taxista->marca;
                $cambio->save();
            }

            if($userOriginal->modelo != $this->taxista->modelo){
                $cambio = new Cambio();
                $cambio->taxista_id = $this->taxista->id;
                $cambio->campo = 'modelo';
                $cambio->valor = $this->taxista->modelo;
                $cambio->save();
            }

            if($userOriginal->color != $this->taxista->color){
                $cambio = new Cambio();
                $cambio->taxista_id = $this->taxista->id;
                $cambio->campo = 'color';
                $cambio->valor = $this->taxista->color;
                $cambio->save();
            }

            if($userOriginal->aire != $this->taxista->aire){
                $cambio = new Cambio();
                $cambio->taxista_id = $this->taxista->id;
                $cambio->campo = 'aire';
                $cambio->valor = $this->taxista->aire;
                $cambio->save();
            }

            if($userOriginal->lic_operativa != $this->taxista->lic_operativa){
                $cambio = new Cambio();
                $cambio->taxista_id = $this->taxista->id;
                $cambio->campo = 'lic_operativa';
                $cambio->valor = $this->taxista->lic_operativa;
                $cambio->save();
            }
        }

        //$this->taxista->update();
        $this->emit('message',"Informacion en Proceso de  Actualización",'success',5000);
    }
}
