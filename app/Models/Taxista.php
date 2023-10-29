<?php

namespace App\Models;

use App\Models\Fondo;
use App\Models\Viaje;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Taxista extends Model implements HasMedia 
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    /**
     * Get the user that owns the Taxista
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo  
     */
    public function user()
    {   
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getDescuento() {
        $default = Opcion::where('clave','descuento_porciento')->first()->valor;
        return $this->descuento != null ? ($this->descuento/100) : ($default/100);
    }

    public function addSaldo(Viaje $viaje){
        $this->fondo += ($viaje->costo * $viaje->moneda_valor) * $viaje->descuento;
        $this->update();
    }

    public function delSaldo(Viaje $viaje){
        $this->fondo -= ($viaje->costo * $viaje->moneda_valor) * $viaje->descuento; 
        $this->update(); 
    }

     /**
     * Get all of the fondos for the Fondo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fondos()
    {
        return $this->hasMany(Fondo::class)->orderBy('created_at','Desc');
    }
}
