<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Horario;

class Auto extends Model
{
    use HasFactory;

    /**
     * Get the horario associated with the Auto
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function horarios()
    {
        return $this->belongsToMany(Horario::class)->withPivot('km','minimo');
    }
}
