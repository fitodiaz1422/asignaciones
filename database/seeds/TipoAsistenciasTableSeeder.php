<?php

use Illuminate\Database\Seeder;

class TipoAsistenciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo_asistencias=[
            ['-1','INASISTENCIA','FF0000'],
            ['0','TRABAJADO','000000'],
            ['1','VACACIONES','0070C0'],
            ['2','LICENCIA MEDICA','00B0E0'],
            ['3','PERMISO','00B050'],
            ['4','TRABAJO REMOTO','92D040'],
        ];
        $tipo_asistencias=array_map(function ($valor){
            return[
                'tipo'=>$valor[0],
                'nombre'=>$valor[1],
                'color'=>$valor[2],
            ];

        },$tipo_asistencias);

        DB::table('tipo_asistencias')->insert($tipo_asistencias);
    }
}
