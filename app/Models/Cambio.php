<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Cambio extends Model implements HasMedia  
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * Get the taxista that owns the Viaje
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo 
     */
    public function taxista()
    {   
        return $this->belongsTo(Taxista::class)->withTrashed();
        
    }
}
