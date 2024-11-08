<?php

use Illuminate\Database\Seeder;

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $empresas=[
            ['FCOM'],
            ['RENEXT'],
            ['EFIPRO'],
        ];
        $empresas=array_map(function ($valor){
            return[
                'nombre'=>$valor[0],
            ];

        },$empresas);

        DB::table('empresas')->insert($empresas);
    }
}
