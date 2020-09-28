<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class DirectorioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('directorios')->insert([
            [
                'nombre' => 'Pablo Renteria',
                'direccion' => 'Patrona #34',
                'telefono' => 5566778899,
                'foto' => null

            ],
            [
                'nombre' => 'Andrea Renteria',
                'direccion' => 'Palma #34',
                'telefono' => 5566764899,
                'foto' => null

            ],

        ]);
    }
}
