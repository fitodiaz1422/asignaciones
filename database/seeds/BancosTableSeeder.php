<?php

use Illuminate\Database\Seeder;

class BancosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bancos=[
            ['BANCO ESTADO'],
            ['BANCO DE CHILE'],
            ['BANCO FALABELLA'],
            ['BANCO SANTANDER'],
            ['BANCO CREDICHILE'],
            ['BANCO RIPLEY'],
            ['BANCO CREDITO E INVERSIONES'],
            ['BANCO NOVA'],
        ];
        $bancos=array_map(function ($valor){
            return[
                'nombre'=>$valor[0],
            ];

        },$bancos);

        DB::table('bancos')->insert($bancos);
    }
}
