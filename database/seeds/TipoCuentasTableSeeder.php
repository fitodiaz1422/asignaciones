<?php

use Illuminate\Database\Seeder;

class TipoCuentasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo_cuentas=[
            ['CUENTA VISTA'],
            ['CUENTA CORRIENTE'],
            ['CUENTA DE AHORRO'],
        ];
        $tipo_cuentas=array_map(function ($valor){
            return[
                'nombre'=>$valor[0],
            ];

        },$tipo_cuentas);

        DB::table('tipo_cuentas')->insert($tipo_cuentas);
    }
}
