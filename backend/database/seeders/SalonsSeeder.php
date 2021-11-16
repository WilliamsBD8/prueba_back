<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models\Salon;

class SalonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //guardar 20 registros
        $arrays = range(0,20);
        foreach ($arrays as $key => $valor) {
          Salon::create([	            
              'name' => 'A'.($key+1).Str::random(1),
              'code' => Str::random(6),
              'aforo' => rand(15, 25),
          ]);
        }
    }
}
