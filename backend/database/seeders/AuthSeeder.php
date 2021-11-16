<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use App\Models\User;

class AuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrays = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin2021'),
                'rol_id' => 1
            ],
            [
                'name' => 'Profesor Biologia',
                'email' => 'profesorBio@gmail.com',
                'password' => Hash::make('profesor2021'),
                'rol_id' => 2
            ],
            [
                'name' => 'Profesor Ingles',
                'email' => 'profesorIng@gmail.com',
                'password' => Hash::make('profesor2021'),
                'rol_id' => 2
            ],
            [
                'name' => 'Profesor Castellano',
                'email' => 'profesorCas@gmail.com',
                'password' => Hash::make('profesor2021'),
                'rol_id' => 2
            ],
            [
                'name' => 'Profesor Matematicas',
                'email' => 'profesorMat@gmail.com',
                'password' => Hash::make('profesor2021'),
                'rol_id' => 2
            ],
            [
                'name' => 'Estudiante matematicas',
                'email' => 'estudianteMat@gmail.com',
                'password' => Hash::make('estudiante2021'),
                'rol_id' => 3
            ],
            [
                'name' => 'Estudiante biologia',
                'email' => 'estudianteBio@gmail.com',
                'password' => Hash::make('estudiante2021'),
                'rol_id' => 3
            ],
            [
                'name' => 'Estudiante ingles',
                'email' => 'estudianteIng@gmail.com',
                'password' => Hash::make('estudiante2021'),
                'rol_id' => 3
            ],
            [
                'name' => 'Estudiante castellano',
                'email' => 'estudianteCas@gmail.com',
                'password' => Hash::make('estudiante2021'),
                'rol_id' => 3
            ]
        ];
        foreach ($arrays as $key => $valor) {
          User::create([	            
              'name' => $valor['name'],
              'email' => $valor['email'],
              'password' => $valor['password'],
              'rol_id' => $valor['rol_id']
          ]);
        }
    }
}
