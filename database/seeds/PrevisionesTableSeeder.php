<?php

use Illuminate\Database\Seeder;

class PrevisionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $previsiones=[
            ['FONASA'],
            ['CONSALUD'],
            ['BANMEDICA'],
            ['CRUZ BLANCA'],
            ['COLMENA GOLDEN CROSS'],
            ['NUEVA MASVIDA'],
        ];
        $previsiones=array_map(function ($valor){
            return[
                'nombre'=>$valor[0],
            ];

        },$previsiones);

        DB::table('previsiones')->insert($previsiones);
    }
}
