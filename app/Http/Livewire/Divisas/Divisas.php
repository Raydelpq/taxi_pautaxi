<?php

namespace App\Http\Livewire\Divisas;

use App\Models\Divisa;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Divisas extends Component
{
    use WithPagination;

    public Divisa $divisa;

    public function rules() {

        return  [
            'divisa.sigla' => 'required',
            'divisa.valor' => 'required|numeric',
        ];

    }

    protected $messages = [
        'divisa.tag' => 'Esta divisa ya se encuentra en el sistema.',
    ];

    public function mount(){
        $this->divisa = new Divisa();
    }

    public function render()
    {   
        $divisas = Divisa::where('id','<>',1)->paginate(20);

        return view('livewire.divisas.divisas',['divisas' => $divisas])->layoutData(['titulo'=>'Divisas']);
    }

    public function resetInput(){
        $this->divisa = new Divisa();
    }

    public function save(){
        $this->validate();

        $this->divisa->tag = Str::slug($this->divisa->sigla);

        if($this->divisa->id == null){
            $this->validate(['divisa.tag' => 'required|unique:divisas,tag']);
            $this->divisa->save();
            $this->emit('message','Divisa Agregada','success');
        }else{
            $this->validate(['divisa.tag' => 'required|unique:divisas,tag,'.$this->divisa->id]);
            $this->divisa->update();
            $this->emit('message','Divisa Editada','success');
        }

        $this->resetInput();
        $this->emit('closeAdd');
    }


    public function edit(Divisa $c){
        $this->divisa = $c;
        $this->emit('edit');
    }

    public function delete(Divisa $c){
        $c->delete();
        $this->emit('message','Divisa Eliminada','success');
    }
}
