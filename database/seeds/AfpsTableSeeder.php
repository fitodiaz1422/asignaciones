<?php

use Illuminate\Database\Seeder;

class AfpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $afps=[
            ['MODELO'],
            ['CAPITAL'],
            ['PLANVITAL'],
            ['PROVIDA'],
            ['HABITAT'],
            ['UNO'],
            ['CUPRUM'],
        ];
        $afps=array_map(function ($valor){
            return[
                'nombre'=>$valor[0],
            ];

        },$afps);

        DB::table('afps')->insert($afps);
    }
}
