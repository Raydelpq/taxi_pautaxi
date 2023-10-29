<?php

namespace Database\Seeders;

use App\Models\Opcion;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OpcionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Opcion::create([
            'label' => 'Porciento de La Agencia por Viaje',
            'clave' => 'descuento_porciento',
            'valor' => '10'
        ]);

        Opcion::create([
            'label' => 'Precio de Cada Parada',
            'clave' => 'precio_parada',
            'valor' => '50'
        ]);

        Opcion::create([
            'label' => 'Precio del tiempo de espera por minuto',
            'clave' => 'precio_espera',
            'valor' => '10'
        ]);

        Opcion::create([
            'label' => 'Precio de equipaje',
            'clave' => 'precio_equipaje',
            'valor' => '10'
        ]);

    }
}
