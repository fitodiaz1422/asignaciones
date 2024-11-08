<?php

use Illuminate\Database\Seeder;

class PaisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paises=[
            [1,'CHILE','CL'],
        ];
        $paises=array_map(function ($valor){
            return[
                'nombre'=>$valor[1],
                'codigo'=>$valor[2],               
            ];

        },$paises);

        DB::table('paises')->insert($paises);
    }
}
