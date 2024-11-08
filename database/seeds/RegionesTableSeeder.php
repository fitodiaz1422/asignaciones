<?php

use Illuminate\Database\Seeder;

class RegionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regiones=[
            [1,'Arica y Parinacota', 'XV',1],
            [2,'Tarapacá', 'I',1],
            [3,'Antofagasta', 'II',1],
            [4,'Atacama', 'III',1],
            [5,'Coquimbo', 'IV',1],
            [6,'Valparaiso', 'V',1],
            [7,'Metropolitana de Santiago', 'RM',1],
            [8,'Libertador General Bernardo O\'Higgins', 'VI',1],
            [9,'Maule', 'VII',1],
            [10,'Ñuble', 'XVI',1],
            [11,'Biobío', 'VIII',1],
            [12,'La Araucanía', 'IX',1],
            [13,'Los Ríos', 'XIV',1],
            [14,'Los Lagos', 'X',1],
            [15,'Aisén del General Carlos Ibáñez del Campo', 'XI',1],
            [16,'Magallanes y de la Antártica Chilena', 'XII',1],
    ];
    $regiones=array_map(function ($valor){
        return[
            'nombre'=>$valor[1],
            'codigo'=>$valor[2],               
            'pais_id'=>$valor[3],
        ];

    },$regiones);

    DB::table('regiones')->insert($regiones);
    }
}
