<?php 

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Viaje;
use App\Models\Cierre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comercial extends Model
{
    use HasFactory;
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

    /**
     * Get all of the viajes for the Comercial
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajes()
    {
        return $this->hasMany(Viaje::class,'comercial_id','id')->where('model','App\Models\Comercial'); 
    }

    // Obiene el salario en un rango de fechas
    public function getSalario($star,$end,$monto = null){ // Solo se pasa en monto en caso de que sea un economico
       
        if($this->salario_fijo == null)
            $fijo = 0;
        else    
            $fijo = $this->salario_fijo;

        if(!$this->is_economico){ // No es Economico
            
            if($star == null){ 
                $lastCierre = Cierre::orderBy('created_at','DESC')->first();
                if($lastCierre == null)
                    $star = '2023-01-01';
                else{
                    $last = new Carbon($lastCierre->end);
                    $star = $last->addDay();
                }
            }

           
            if($this->porciento_viaje == null)
                $porciento = 0;
            else    
                $porciento = $this->porciento_viaje;


            $salario = 0;

            if($porciento > 0){
               
               $build = Viaje::where(function ($q) use($star,$end){
                    $q->whereBetween('created_at',[$star." 00:00:00",$end." 23:59:59"])
                     ->whereBetween(\DB::raw("time(`created_at`)"),[\DB::raw("'00:00:00'"),\DB::raw("'05:59:59'")]);
                })->where('taxista_id','<>',null)->where('comercial_id',$this->user->id);
                
                $tmp = $build->selectRaw(" sum( (costo * moneda_valor) * descuento) as Monto")->first(); 
                $salario = $tmp->Monto * ( 50 / 100); // se cobra el 50%

                $build = Viaje::where(function ($q) use($star,$end){
                    $q->whereBetween('created_at',[$star." 00:00:00",$end." 23:59:59"])
                     ->whereBetween(\DB::raw("time(`created_at`)"),[\DB::raw("'06:00:00'"),\DB::raw("'23:59:59'")]);
                })->where(function($q){
                    $q->where('taxista_id','<>',null)->where('colaborador_id',null);
                })->where('comercial_id',$this->user->id);
                
                $tmp = $build->selectRaw(" sum( (costo * moneda_valor) * descuento) as Monto")->first(); 
                $salario += $tmp->Monto * ( $this->porciento_viaje / 100); // se cobra el % definido

                //******** Colaboraciones  *********/

                $build = Viaje::whereBetween('created_at',[$star." 00:00:00",$end." 23:59:59"])
                    ->where('comercial_id',$this->user->id)
                    ->where(function($q){
                        $q->where('colaborador_id',"<>",null);//->where('type_colaboracion','salida');
                    }); 
                    
                $tmpColabo = $build->selectRaw(" sum( (costo * moneda_valor) * descuento ) as Monto")->first();
                $salario += ($tmpColabo->Monto/2) * 0.25;
               
            }

            return $fijo + $salario;
        } 
        
        // Es Economico
        return number_format($fijo + ($monto * 0.10),2);
    }
}
