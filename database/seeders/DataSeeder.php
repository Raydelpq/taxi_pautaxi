<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Divisa;
use App\Models\Administrador;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() 
    {   // Super Usuario
        $user = User::create([
            'name' => 'Raydel',
            'apellidos' => 'Piloto Quesada',
            'telefono' => '58242187',
            'email' => 'pilotoraydel@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        Administrador::create([
            'user_id' => $user->id,
            'salario_fijo' => 0,
            'porciento_viaje' => 0
        ]);

        // Crear Roles en Spatie
        $roles = ['Administrador','Comercial','Taxista'];
        foreach($roles as $rol){
            Role::create([
                'name' => $rol,
                'guard_name' => 'web'       
            ]);
        }

        // Asignar rol al Super usuario
        $user->assignRole('Administrador'); 

        // Crera Divisa CUP por defecto
        Divisa::create([
            'sigla' => 'CUP',
            'valor' => '1',
            'tag'   => 'cup'
        ]);
    }
}
