<?php

namespace App\Models;

use App\Models\User;
use App\Models\Divisa;
use App\Models\Parada;
use App\Models\Cliente;
use App\Models\Taxista;
use App\Models\Comercial;
use App\Models\Colaboracion;
use App\Models\Administrador;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Viaje extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['origen','destino','moneda','costo','descuento','pasajeros','fecha','observaciones','comercial_id','cliente_id']; 

    protected $dates = ['fecha'];

    protected $casts = [
        'fecha' => 'datetime:d/m/Y h:i A',
    ];

    /**
     * Get the taxista that owns the Viaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo 
     */
    public function taxista()
    {   
        return $this->belongsTo(Taxista::class)->withTrashed();
        
    }

    /**
     * Get the comercial that owns the Viaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo 
     */
    public function user(): BelongsTo 
    {   //$model = $this->model;
        return $this->belongsTo(User::class,'comercial_id')->withTrashed();
    }

    /**
     * Get the deleted that owns the Viaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo 
     */
    public function deleteby(): BelongsTo 
    {   //$model = $this->model;
        return $this->belongsTo(User::class,'deleted_id')->withTrashed();
    }

    /**
     * Get the colaborador that owns the Viaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo 
     */
    public function colaborador(){
        return $this->belongsTo(Colaboracion::class,'colaborador_id','id')->withTrashed();
    }
    

    /**
     * Get all of the paradas for the Viaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paradas(): HasMany
    {
        return $this->hasMany(Parada::class);
    }

    /**
     * Get the cliente that owns the Viaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class)->withTrashed();
    }


    /**
     * Get the divisa that owns the Viaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisa(): BelongsTo
    {
        return $this->belongsTo(Divisa::class,'moneda','id')->withTrashed();
    }
}