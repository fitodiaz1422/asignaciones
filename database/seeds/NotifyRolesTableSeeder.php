<?php

use Illuminate\Database\Seeder;

class NotifyRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notifyroles=[
            ['asignaciones.atraso','Cuando se asigna un Atraso','Asignaciones'],
            ['asignaciones.falta','Cuando se asigna una Falta','Asignaciones']
        ];
        $notifyroles=array_map(function ($valor){
            return[
                'name'=>$valor[0],
                'description'=>$valor[1],
                'global_group'=>$valor[2],
            ];

        },$notifyroles);

        DB::table('notifyroles')->insert($notifyroles);

        $notifyroles=DB::table('notifyroles')->get();

        foreach ($notifyroles as $rol) {
                 $notifyroles_cargos[]=[
                     'cargo_id'=>1,
                     'notifyrole_id'=>$rol->id,
                 ];
                 $notifyroles_users[]=[
                     'user_id'=>1,
                     'notifyrole_id'=>$rol->id,
                 ];
         }
         DB::table('notifyroles_cargos')->insert($notifyroles_cargos);
         DB::table('notifyroles_users')->insert($notifyroles_users);
    }
}


