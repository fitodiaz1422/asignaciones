<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=[
            ['valida.index','Listado de Rendiciones a validar','Validacion Rendiciones'],
            ['valida.create','Validar Rendicion','Validacion Rendiciones'],
            ['valida.edit','Editar Rendicion Validada','Validacion Rendiciones'],
            ['valida.destroy','Elimina Rendicion','Validacion Rendiciones'],
            ['users.index','Listado de Usuarios','Usuarios'],
            ['users.create','Crear Usuario','Usuarios'],
            ['users.edit','Editar Usuario','Usuarios'],
            ['users.show','Ver Usuario','Usuarios'],
            ['users.destroy','Eliminar Usuario','Usuarios'],
            ['rendiciones.index','Ver Rendiciones','Rendiciones'],
            ['rendiciones.create','Crear Rendicion','Rendiciones'],
            ['rendiciones.edit','Editar Rendicion','Rendiciones'],
            ['rendiciones.destroy','Eliminar Rendicion','Rendiciones'],
            ['permisos.tecnico','Tecnico','Permisos Especiales'],
            ['permisos.jp','Jefe Proyecto','Permisos Especiales'],
            ['permisos.coordinador','Coordinador','Permisos Especiales'],
            ['depositos.index','Ver Depositos','Depositos'],
            ['depositos.create','Crear Deposito','Depositos'],
            ['depositos.edit','Editar Deposito','Depositos'],
            ['depositos.destroy','Eliminar Deposito','Depositos'],
            ['cargos.index','Listado de Cargos','Grupos'],
            ['cargos.create','Crear Cargo','Grupos'],
            ['cargos.edit','Editar Cargo','Grupos'],
            ['cargos.destroy','Eliminar Cargo','Grupos'],
            ['asistencia.index','Listado de Asistencias','Asistencia'],
            ['asistencia.create','Crear Asistencia','Asistencia'],
            ['asistencia.edit','Editar Asistencia','Asistencia'],
            ['asistencia.destroy','Eliminar Asistencia','Asistencia'],
            ['asignaciones.index','Ver Asignaciones','Asignaciones'],
            ['asignaciones.create','Crear Asignaciones','Asignaciones'],
            ['asignaciones.edit','Editar Asignaciones','Asignaciones'],
            ['asignaciones.destroy','Eliminar Asignacion','Asignaciones'],
            ['asignaciones.iniciafin','Inicia o Finaliza Actividades','Asignaciones'],
            ['reportes.asistencia','Reportes de Asistencia','Reportes'],
            ['maestros.index','Ingresa a Maestros del sistema','Maestros'],
            ['reportes.usuarios','Reporte de Datos de Usuarios','Reportes'],
            ['reportes.depositos_proyectos','Reporte de Depositos por Proyectos','Reportes'],
            ['cotizaciones.index','Ver Cotizaciones','Cotizaciones'],
            ['cotizaciones.create','Crear Cotizacion','Cotizaciones'],
            ['cotizaciones.edit','Editar Cotizacion','Cotizaciones'],
            ['cotizaciones.destroy','Eliminar Cotizacion','Cotizaciones'],
            ['reportes.proyecto_tecnicos','Reporte de Asistencia por Proyecto','Reportes'],
    ];
    $roles=array_map(function ($valor){
        return[
            'name'=>$valor[0],
            'description'=>$valor[1],
            'global_group'=>$valor[2],
        ];

    },$roles);

    DB::table('roles')->insert($roles);

   $roles=DB::table('roles')->get();

   foreach ($roles as $rol) {
       if($rol->global_group!='Permisos Especiales'){
            $roles_group[]=[
                'cargo_id'=>1,
                'role_id'=>$rol->id,
            ];
            $users_roles[]=[
                'user_id'=>1,
                'role_id'=>$rol->id,
            ];
       }
    }
    DB::table('roles_cargos')->insert($roles_group);
    DB::table('roles_users')->insert($users_roles);



    }
}



