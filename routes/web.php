
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');

Route::post('/asignaciones/ajax/iniciafin', ['as'=>'asignaciones.set_ajax_iniciafin' ,'uses'=>'AsignacionesController@setAjaxIniciaFin'])
	->middleware('rol:asignaciones.iniciafin');

Route::post('/asignaciones/ajax/upload_checklist', ['as'=>'asignaciones.upload_checklist' ,'uses'=>'AsignacionesController@setUploadChecklist'])
->middleware('rol:asignaciones.iniciafin');

Route::delete('/asignaciones/ajax/delete_checkList', ['as'=>'asignaciones.delete_checkList' ,'uses'=>'AsignacionesController@DeleteCheckList'])
->middleware('rol:asignaciones.iniciafin');

Route::get('/asignaciones/ajax/isFree/{user_id}/{fecha}/{horas}', ['as'=>'asignaciones.is_free' ,'uses'=>'AsignacionesController@isFree']);

Route::post('/asignaciones/ajax/modificar_actividad', ['as'=>'asignaciones.get_ajax_modificar_actividad' ,'uses'=>'AsignacionesController@getAjaxModificarActividad'])
    ->middleware('rol:asignaciones.index');
Route::post('/asignaciones/ajax/actividad', ['as'=>'asignaciones.get_ajax_actividad' ,'uses'=>'AsignacionesController@getAjaxActividad'])
    ->middleware('rol:asignaciones.index');
Route::post('/asignaciones/ajax/falta', ['as'=>'asignaciones.set_ajax_falta' ,'uses'=>'AsignacionesController@setAjaxFalta'])
    ->middleware('rol:asignaciones.create');
Route::post('/asignaciones/ajax/atraso', ['as'=>'asignaciones.set_ajax_atraso' ,'uses'=>'AsignacionesController@setAjaxAtraso'])
	->middleware('rol:asignaciones.create');
Route::get('/asignaciones', ['as'=>'asignaciones.index', 'uses'=>'AsignacionesController@Index'])
	->middleware('rol:asignaciones.index');
Route::post('/asignaciones', ['as'=>'asignaciones.store' ,'uses'=>'AsignacionesController@Store'])
	->middleware('rol:asignaciones.create');
Route::put('/asignaciones/{id}', ['as'=>'asignaciones.update' ,'uses'=>'AsignacionesController@Update'])
	->middleware('rol:asignaciones.edit');
Route::delete('/asignaciones', ['as'=>'asignaciones.destroy' ,'uses'=>'AsignacionesController@Destroy'])
	->middleware('rol:asignaciones.destroy');

Route::post('/asignaciones/hora', ['as'=>'asignaciones.hora' ,'uses'=>'AsignacionesController@Hora'])
	->middleware('rol:asignaciones.edit');
Route::post('/asignaciones/masiva', ['as'=>'asignacion.masiva' ,'uses'=>'AsignacionesController@Masiva'])
	->middleware('rol:asignaciones.create');	

Route::get('/asignaciones_excel/{fecha}', ['as'=>'reportes.asignaciones', 'uses'=>'AsignacionesController@Reportes_asignaciones']);	


Route::get('/asistencia/asistencia', ['as'=>'asistencia.index', 'uses'=>'AsistenciaController@Index'])
	->middleware('rol:asistencia.index');
Route::post('/asistencia', ['as'=>'asistencia.store' ,'uses'=>'AsistenciaController@Store'])
	->middleware('rol:asistencia.create');
Route::put('/asistencia/{id}', ['as'=>'asistencia.update' ,'uses'=>'AsistenciaController@Update'])
	->middleware('rol:asistencia.edit');
Route::delete('/asistencia/{id}', ['as'=>'asistencia.destroy' ,'uses'=>'AsistenciaController@Destroy'])
	->middleware('rol:asistencia.destroy');
Route::get('/asistencia/carta_amonestacion', ['as'=>'carta_amonestacion.index', 'uses'=>'AsistenciaController@carta_amonestacion'])
	->middleware('rol:asistencia.index');
Route::post('/importAmonestacionPDF', ['as'=>'carta_amonestacion.importAmonestacionPDF' ,'uses'=>'AsistenciaController@importAmonestacionPDF']);
Route::get('/asistencia/bono', ['as'=>'bono.index', 'uses'=>'AsistenciaController@Bono'])
	->middleware('rol:bono.index');
Route::post('/asistencia/bono/store', ['as'=>'bono.store', 'uses'=>'AsistenciaController@BonoStore'])
	->middleware('rol:bono.index');
Route::post('/asistencia/bono/edit', ['as'=>'bono.edit', 'uses'=>'AsistenciaController@BonoEdit'])
	->middleware('rol:bono.index');	





Route::get('/depositos', ['as'=>'depositos.index', 'uses'=>'DepositosController@Index'])
	->middleware('rol:depositos.index');
Route::post('/depositos', ['as'=>'depositos.store' ,'uses'=>'DepositosController@Store'])
	->middleware('rol:depositos.create');
Route::put('/depositos/{id}', ['as'=>'depositos.update' ,'uses'=>'DepositosController@Update'])
	->middleware('rol:depositos.edit');
Route::delete('/depositos/{id}', ['as'=>'depositos.destroy' ,'uses'=>'DepositosController@Destroy'])
	->middleware('rol:depositos.destroy');

Route::get('/rendiciones', ['as'=>'rendiciones.index', 'uses'=>'RendicionesController@Index'])
	->middleware('rol:rendiciones.index');
Route::post('/rendiciones', ['as'=>'rendiciones.store' ,'uses'=>'RendicionesController@Store'])
	->middleware('rol:rendiciones.create');
Route::put('/rendiciones/{id}', ['as'=>'rendiciones.update' ,'uses'=>'RendicionesController@Update'])
	->middleware('rol:rendiciones.edit');
Route::delete('/rendiciones/{id}', ['as'=>'rendiciones.destroy' ,'uses'=>'RendicionesController@Destroy'])
	->middleware('rol:rendiciones.destroy');

Route::get('/valida', ['as'=>'valida.index', 'uses'=>'ValidaController@Index'])
	->middleware('rol:valida.index');
Route::post('/valida', ['as'=>'valida.store' ,'uses'=>'ValidaController@Store'])
	->middleware('rol:valida.create');
Route::put('/valida/{id}', ['as'=>'valida.update' ,'uses'=>'ValidaController@Update'])
	->middleware('rol:valida.edit');
Route::delete('/valida/{id}', ['as'=>'valida.destroy' ,'uses'=>'ValidaController@Destroy'])
	->middleware('rol:valida.destroy');


Route::post('/users/reactive/{id}', ['as'=>'users.reactive' ,'uses'=>'UsersController@reactive'])
	->middleware('rol:users.destroy');
Route::get('/users', ['as'=>'users.index', 'uses'=>'UsersController@Index'])
	->middleware('rol:users.index');
Route::get('/users/crear', ['as'=>'users.create' ,'uses'=>'UsersController@Create'])
	->middleware('rol:users.create');
Route::post('/users', ['as'=>'users.store' ,'uses'=>'UsersController@Store'])
	->middleware('rol:users.create');
Route::get('/users/{id}', ['as'=>'users.show' ,'uses'=>'UsersController@Show'])
	->middleware('rol:users.show');
Route::get('/users/{id}/edit', ['as'=>'users.edit' ,'uses'=>'UsersController@Edit'])
	->middleware('rol:users.edit');
Route::put('/users/{id}', ['as'=>'users.update' ,'uses'=>'UsersController@Update'])
	->middleware('rol:users.edit');
Route::delete('/users/{id}', ['as'=>'users.destroy' ,'uses'=>'UsersController@Destroy'])
	->middleware('rol:users.destroy');
Route::put('/users/password/update/{id}', ['as'=>'users.updatepassword' ,'uses'=>'UsersController@UpdatePassword'])
    ->middleware('rol:users.edit');
Route::get('/users/ajax/getDisponibles/{proyecto}/{region}/{fecha}', ['as'=>'users.get.disponibles' ,'uses'=>'UsersController@getDisponibles']);
Route::get('/users/ajax/getByArea/{proyecto}/{fecha}/{area?}', ['as'=>'users.get.by_area' ,'uses'=>'UsersController@getByArea']);


Route::get('/users/ajax/validaRut/{q}', ['as'=>'users.ajax.valida_rut' ,'uses'=>'UsersController@validaRut']);

Route::put('/users/self/password/update', ['as'=>'users.update_self_password' ,'uses'=>'UsersController@UpdateSelfPassword']);
Route::put('/users/self/update', ['as'=>'users.self_update' ,'uses'=>'UsersController@SelfUpdate']);
Route::get('/users/self/perfil', ['as'=>'users.perfil' ,'uses'=>'UsersController@perfil']);

Route::get('/cargos', ['as'=>'cargos.index', 'uses'=>'CargosController@Index'])
	->middleware('rol:cargos.index');
Route::get('/cargos/crear', ['as'=>'cargos.create' ,'uses'=>'CargosController@Create'])
	->middleware('rol:cargos.create');
Route::post('/cargos', ['as'=>'cargos.store' ,'uses'=>'CargosController@Store'])
	->middleware('rol:cargos.create');
Route::get('/cargos/{id}/edit', ['as'=>'cargos.edit' ,'uses'=>'CargosController@Edit'])
	->middleware('rol:cargos.edit');
Route::put('/cargos/{id}', ['as'=>'cargos.update' ,'uses'=>'CargosController@Update'])
	->middleware('rol:cargos.edit');
Route::delete('/cargos/{id}', ['as'=>'cargos.destroy' ,'uses'=>'CargosController@Destroy'])
	->middleware('rol:cargos.destroy');
Route::get('/cargos/ajax/get/{id}', ['as'=>'cargos.roles_group', 'uses'=>'CargosController@RolesGroup'])
	->middleware('rol:users.create');

Route::get('/reportes/asistencia', ['as'=>'reportes.asistencia', 'uses'=>'ReportesController@asistencia'])->middleware('rol:reportes.asistencia');
Route::post('/reportes/asistencia', ['as'=>'reportes.asistencia', 'uses'=>'ReportesController@asistenciapost'])->middleware('rol:reportes.asistencia');
Route::get('/reportes/usuarios', ['as'=>'reportes.usuarios', 'uses'=>'ReportesController@Usuarios'])->middleware('rol:reportes.usuarios');
Route::post('/reportes/usuarios', ['as'=>'reportes.usuarios', 'uses'=>'ReportesController@UsuariosPost'])->middleware('rol:reportes.usuarios');
Route::get('/reportes/depositos_proyectos', ['as'=>'reportes.depositos_proyectos', 'uses'=>'ReportesController@DepositosProyectos'])->middleware('rol:reportes.depositos_proyectos');
Route::post('/reportes/depositos_proyectos', ['as'=>'reportes.depositos_proyectos', 'uses'=>'ReportesController@DepositosProyectosPost'])->middleware('rol:reportes.depositos_proyectos');

Route::get('/reportes/proyecto_tecnicos', ['as'=>'reportes.proyecto_tecnicos', 'uses'=>'ReportesController@ProyectosTecnicos'])->middleware('rol:reportes.proyecto_tecnicos');
Route::post('/reportes/proyecto_tecnicos', ['as'=>'reportes.proyecto_tecnicos', 'uses'=>'ReportesController@ProyectosTecnicosPost'])->middleware('rol:reportes.proyecto_tecnicos');


Route::get('/reportes/control_coordinacion', ['as'=>'reportes.control_coordinacion', 'uses'=>'ReportesController@control_coordinacion'])->middleware('rol:reportes.control_coordinacion');
Route::post('/reportes/control_coordinacion', ['as'=>'reportes.control_coordinacion', 'uses'=>'ReportesController@control_coordinacionPost'])->middleware('rol:reportes.control_coordinacion');

Route::get('/reportes/centro_costo', ['as'=>'reportes.centro_costo', 'uses'=>'ReportesController@centro_costo'])->middleware('rol:reportes.centro_costo');
Route::post('/reportes/centro_costo', ['as'=>'reportes.centro_costo', 'uses'=>'ReportesController@centro_costoPost'])->middleware('rol:reportes.centro_costo');


Route::get('/reportes/atraso', ['as'=>'reportes.atraso', 'uses'=>'ReportesController@atraso'])->middleware('rol:reportes.atraso');
Route::post('/reportes/atraso', ['as'=>'reportes.atraso', 'uses'=>'ReportesController@atrasopost'])->middleware('rol:reportes.atraso');




    //Ruta de Notificaciones    ok
Route::get('/notificaciones', ['as'=>'notifications.index', 'uses'=>'NotificationsController@Index']);
Route::get('/notificaciones/ajax/list', ['as'=>'notifications.ajax.list', 'uses'=>'NotificationsController@List']);
Route::get('/GetNotifications', ['as'=>'notifications.get', 'uses'=> 'NotificationsController@GetNotifications']);
Route::post('/SetUnreadNotifications', ['as'=>'notifications.set', 'uses'=> 'NotificationsController@SetUnreadNotifications']);

//Ruta de maestros
Route::get('/maestros', ['as'=>'maestros.index', 'uses'=>'MaestrosController@index'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/empresa/store', ['as'=>'maestros.empresa.store', 'uses'=>'MaestrosController@storeEmpresa'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/cliente/store', ['as'=>'maestros.cliente.store', 'uses'=>'MaestrosController@storeCliente'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/proyecto/store', ['as'=>'maestros.proyecto.store', 'uses'=>'MaestrosController@storeProyecto'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/asistencia/store', ['as'=>'maestros.asistencia.store', 'uses'=>'MaestrosController@storeAsistencia'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/skill/store', ['as'=>'maestros.skill.store', 'uses'=>'MaestrosController@storeSkill'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/afp/store', ['as'=>'maestros.afp.store', 'uses'=>'MaestrosController@storeAfp'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/prevision/store', ['as'=>'maestros.prevision.store', 'uses'=>'MaestrosController@storePrevision'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/banco/store', ['as'=>'maestros.banco.store', 'uses'=>'MaestrosController@storeBanco'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/herramienta/store', ['as'=>'maestros.herramienta.store', 'uses'=>'MaestrosController@storeHerramienta'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/costo/store', ['as'=>'maestros.costo.store', 'uses'=>'MaestrosController@storeCosto'])
    ->middleware('rol:maestros.index');
Route::post('/maestros/motivo/store', ['as'=>'maestros.motivo.store', 'uses'=>'MaestrosController@storeMotivo'])
    ->middleware('rol:maestros.index'); 	    


Route::put('/maestros/empresa/update', ['as'=>'maestros.empresa.update', 'uses'=>'MaestrosController@updateEmpresa'])
    ->middleware('rol:maestros.index');
Route::put('/maestros/cliente/update', ['as'=>'maestros.cliente.update', 'uses'=>'MaestrosController@updateCliente'])
    ->middleware('rol:maestros.index');
Route::put('/maestros/proyecto/update', ['as'=>'maestros.proyecto.update', 'uses'=>'MaestrosController@updateProyecto'])
    ->middleware('rol:maestros.index');
Route::put('/maestros/asistencia/update', ['as'=>'maestros.asistencia.update', 'uses'=>'MaestrosController@updateAsistencia'])
    ->middleware('rol:maestros.index');
Route::put('/maestros/skill/update', ['as'=>'maestros.skill.update', 'uses'=>'MaestrosController@updateSkill'])
    ->middleware('rol:maestros.index');
Route::put('/maestros/afp/update', ['as'=>'maestros.afp.update', 'uses'=>'MaestrosController@updateAfp'])
    ->middleware('rol:maestros.index');
Route::put('/maestros/prevision/update', ['as'=>'maestros.prevision.update', 'uses'=>'MaestrosController@updatePrevision'])
    ->middleware('rol:maestros.index');
Route::put('/maestros/banco/update', ['as'=>'maestros.banco.update', 'uses'=>'MaestrosController@updateBanco'])
    ->middleware('rol:maestros.index');
Route::put('/maestros/herramienta/update', ['as'=>'maestros.herramienta.update', 'uses'=>'MaestrosController@updateHerramienta'])
    ->middleware('rol:maestros.index');
    Route::put('/maestros/costo/update', ['as'=>'maestros.costo.update', 'uses'=>'MaestrosController@updateCosto'])
    ->middleware('rol:maestros.index');
	Route::put('/maestros/motivo/update', ['as'=>'maestros.motivo.update', 'uses'=>'MaestrosController@updateMotivo'])
    ->middleware('rol:maestros.index');

//Cotizaciones
Route::get('/cotizaciones', ['as'=>'cotizaciones.index', 'uses'=>'CotizacionesController@Index'])
	->middleware('rol:cotizaciones.index');
Route::post('/cotizaciones', ['as'=>'cotizaciones.store' ,'uses'=>'CotizacionesController@Store'])
	->middleware('rol:cotizaciones.create');
Route::put('/cotizaciones', ['as'=>'cotizaciones.update' ,'uses'=>'CotizacionesController@Update'])
	->middleware('rol:cotizaciones.edit');
Route::delete('/cotizaciones', ['as'=>'cotizaciones.destroy' ,'uses'=>'CotizacionesController@Destroy'])
	->middleware('rol:cotizaciones.destroy');
Route::get('/cotizaciones/ajax/{id}', ['as'=>'cotizaciones.ajax_show' ,'uses'=>'CotizacionesController@AjaxShow'])
	->middleware('rol:cotizaciones.edit');

Route::post('/importCotiPDF', ['as'=>'importCotiPDF' ,'uses'=>'CotizacionesController@importCotiPDF']);	

Route::post('/cotizacionesPO', ['as'=>'cotizaciones.subirPO' ,'uses'=>'CotizacionesController@subirPO'])
	->middleware('rol:cotizaciones.edit');

Route::post('/cotizacionesFactura', ['as'=>'cotizaciones.subirFactura' ,'uses'=>'CotizacionesController@subirFactura'])
	->middleware('rol:cotizaciones.edit');	


Route::get('/clearcache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    return "cache eliminada correctamente";
});

