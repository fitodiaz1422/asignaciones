<?php

use Illuminate\Database\Seeder;

class TipoContratosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo_contratos=[
            ['INDEFINIDO'],
            ['PLAZO FIJO'],
            ['EXTERNO'],
        ];
        $tipo_contratos=array_map(function ($valor){
            return[
                'nombre'=>$valor[0],
            ];

        },$tipo_contratos);

        DB::table('tipo_contratos')->insert($tipo_contratos);
    }

}
