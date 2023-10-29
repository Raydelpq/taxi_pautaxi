<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fondo extends Model
{
    use HasFactory;

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
    public function comercial()
    {   return $this->belongsTo(User::class,'comercial_id')->withTrashed(); 
    }

   
}
