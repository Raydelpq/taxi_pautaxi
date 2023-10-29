<?php

namespace App\Http\Livewire\Taxista;

use App\Models\Divisa;
use App\Models\Cambio as ModelCambio;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Cambio extends Component
{
    use WithPagination;

    public function mount(){
        
    }

    public function render()
    {   
        $cambios = ModelCambio::paginate(25);
        return view('livewire.taxista.cambio',['cambios' => $cambios])->layoutData(['titulo'=>'Cambios por Autorizar']);
    }


    // Confirmar el cambio
    public function confirmar(ModelCambio $cambio){
        
        $taxista = $cambio->taxista;
        $user = $taxista->user;
        switch ($cambio->campo) {
            case 'name':{
                $user->name = $cambio->valor;
                $user->update();   
            }
                break;
            case 'apellidos':{
                $user->apellidos = $cambio->valor;
                $user->update();   
            }
                break;
            case 'telefono':{
                $user->telefono = $cambio->valor;
                $user->update();   
            }
                break;

            case 'marca':{
                $taxista->marca = $cambio->valor;
                $taxista->update();   
            }
                break;
            case 'modelo':{
                $taxista->modelo = $cambio->valor;
                $taxista->update();   
            }
                break;
            case 'color':{
                $taxista->color = $cambio->valor;
                $taxista->update();   
            }
                break;
            case 'aire':{
                $taxista->aire = $cambio->valor;
                $taxista->update();   
            }
                break;
            case 'lic_operativa':{
                $taxista->lic_operativa = $cambio->valor;
                $taxista->update();   
            }
                break;
            case 'taxi':{
                if( $taxista->getMedia('taxi')->first()) 
                    $taxista->getMedia('taxi')->first()->delete();

                $taxista->addMedia($cambio->getMedia('taxi')->first()->getPath())->toMediaCollection('taxi');
                $cambio->getMedia('taxi')->first()->delete();
                   
            }
                break;
            case 'avatar':{
                if( $user->getMedia('avatar')->first()) 
                    $user->getMedia('avatar')->first()->delete();

                $user->addMedia($cambio->getMedia('avatar')->first()->getPath())->toMediaCollection('avatar');
                $cambio->getMedia('avatar')->first()->delete();
                   
            }
        }

        $cambio->delete();
        $this->emit('message',"Cambio Confirmado",'success');
    }

    public function cancelar(ModelCambio $cambio){
        $taxista = $cambio->taxista;
        $user = $taxista->user;

        switch ($cambio->campo) {
            case 'taxi':{
                $cambio->getMedia('taxi')->first()->delete();
            }
                break;
            case 'avatar':{
                $cambio->getMedia('avatar')->first()->delete();    
            }
        }

        $cambio->delete();
        $this->emit('message',"Cambio Cancelado",'success');
    }
   
}
