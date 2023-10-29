<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Auto;

class Horario extends Model
{
    use HasFactory;

    /**
     * Get the horario associated with the Auto
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function autos()
    {
        return $this->belongsToMany(Auto::class)->withPivot('km','minimo');
    }
}
