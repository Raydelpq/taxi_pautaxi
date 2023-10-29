<?php

namespace App\Models;

use App\Models\CierreGasto;
use App\Models\CierreViaje;
use App\Models\CierreSalario;
use App\Models\CierreViajeEliminado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cierre extends Model
{
    use HasFactory;

    protected $dates = [
        'end','star'
    ];

    private $meses = [
        'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
    ];

    public function getPeriodo(){

        return $this->star->format('d').' de '.$this->meses[ $this->star->format('m')-1 ].' de '.$this->star->format('Y').' al '.$this->end->format('d').' de '.$this->meses[ $this->end->format('m')-1 ].' de '.$this->end->format('Y');
    }

    /**
     * Get all of the gastos for the Cierre
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gastos()
    {
        return $this->hasMany(CierreGasto::class);
    }

    /**
     * Get all of the salarios for the Cierre
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empleados()
    {
        return $this->hasMany(CierreSalario::class);
    }

    /**
     * Get all of the viajes for the Cierre
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function listViajes()
    {
        return $this->hasMany(CierreViaje::class);
    }

    /**
     * Get all of the eliminados for the Cierre
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eliminados()
    {
        return $this->hasMany(CierreViajeEliminado::class);
    }

    //Suma de gastos
    private function sumGastos(){
        return $this->gastos()->sum('valor'); 
    }

    // Suma de los Gastos en el periodo
    private function sumSalarios(){
        $salario = 0;
        foreach($this->empleados as $empleado)
            $salario += $empleado->salario;

        return $salario;
    }

    public function gastosTotales(){
        return $this->sumGastos() + $this->sumSalarios();
    }
}
