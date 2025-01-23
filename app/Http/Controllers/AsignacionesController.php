<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Repositories\Notifications\NotificationRepository;
use App\Http\Requests\CreateAsignacionRequest;
use App\Http\Requests\SetFaltaRequest;
use App\Http\Requests\SetAtrasoRequest;
use App\Http\Requests\SetIniFinRequest;
use App\Http\Requests\SetUploadCheckListRequest;
use App\User;
use App\Comuna;
use App\Region;
use App\Proyecto;
use App\Actividad;
use App\Anticipo;
use App\Motivos;
use App\User_Actividad;
use App\Deposito_Archivo;
use App\Actividad_Modificacion;
use App\Deposito;
use App\Atraso;
use App\Http\Excel\AsignacionExcel;
class AsignacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){


    	$filter_region_id= ($request->filter_region_id) ? $request->filter_region_id : null;
    	$filter_proyecto_id= ($request->filter_proyecto_id) ? $request->filter_proyecto_id : null;
    	$filter_sin_asignar = (isset($request->filter_sin_asignar)) ? $request->filter_sin_asignar : -1;

    	$date=$request->fechaasign ? $request->fechaasign : date('Y-m-d');

        if(auth()->user()->hasRoles('permisos.coordinador'))
            $users=User::where('proyecto_id',auth()->user()->proyecto_id)->where('estado_contrato',1)->where('usuario_cliente',null);
        elseif(auth()->user()->hasRoles('permisos.tecnico'))
            $users=User::where('id',auth()->user()->id)->where('estado_contrato',1)->where('usuario_cliente',null)->where('proyecto_id','<>',24);
        else
            $users=User::where('estado_contrato',1)->where('usuario_cliente',null)->where('proyecto_id','<>',24);

             if($filter_sin_asignar === "1"){
                $users=$users->whereDoesntHave('horas', function ($query) use ($date){
                    $query->where('fecha',str_replace("-", "", $date));
                });

            }elseif($filter_sin_asignar === "0"){
                $users=$users->whereHas('horas', function ($query) use ($date){
                    $query->where('fecha',str_replace("-", "", $date));
                });
            }else{
                $users=$users;
            }


        if(!auth()->user()->hasRoles('permisos.coordinador') && $filter_proyecto_id)
            $users=  $users->where('proyecto_id',$filter_proyecto_id);
        $users= ($filter_region_id)
            ? $users->whereHas('comuna',function ($query) use ($filter_region_id){
                                $query->where('region_id',$filter_region_id);
            })->get()

            : $users->get();


    	$comunas=Comuna::query()->orderby('nombre','asc')->with('Region')->get();

    	$costo = DB::table('centro_costos')->where('estado','=','ACTIVO')->get();

		$motivos = Motivos::where('estado','ACTIVO')->get();

		$solicitados = User::where('estado_contrato',1)->where('usuario_cliente',null)->whereIn('cargo_id',[1,3,4])->get();

    	$regiones = Region::all();
    	//$proyectos=Proyecto::all();
    	$proyectos=Proyecto::where('estado','ACTIVO')->get();



        $mod=true;
        $futuro=true;
    	if($date<date('Y-m-d'))
    		$mod=false;
        if($date>date('Y-m-d'))
    		$futuro=false;
    	return view('asignaciones.index',compact('users','proyectos','comunas','date','regiones','mod','futuro','costo','motivos','solicitados','filter_region_id','filter_proyecto_id','filter_sin_asignar'));
    }

    public function store(CreateAsignacionRequest $request){
    	$proyecto=Proyecto::find($request->proyecto_id);
    	$comuna=Comuna::find($request->comuna_id);
    	$fecharecibida=str_replace("-", "", $request->fechadatos);
    	DB::beginTransaction();
    	try {
			$datos="";
            $datos.="Cliente: ".$proyecto->Cliente->nombre."\n";
            $datos.="Proyecto: ".$proyecto->nombre."\n";
			$datos.="Nro. Actividad: ".$request->actividad."\n";
			$datos.="Direccion: ".$request->direccion."\n";
			$datos.="Comuna: ".$comuna->nombre."\n";
			$datos.="Usuario: ".$request->usuario."\n";
			$datos.="Detalle: ".$request->detalle."\n";
			$datos.="Nota: ".$request->nota."\n";
			$datos.="Deposito: ".$request->deposito."\n";
	    	$actividad=new Actividad;
	    	$actividad->nombre=$request->actividad;
	    	$actividad->tipo_asistencia_id=0;
	    	$actividad->proyecto_id=$request->proyecto_id;
	    	$actividad->comuna_id=$request->comuna_id;
			$actividad->descripcion=$datos;
			$actividad->user_id=$request->user_id;
			$actividad->coordinacion=$request->coordinacion;
			$actividad->coordinacion_name=$request->coordinacion_name;
			$actividad->centro_costo_id=$request->costo_id;
	    	$actividad->save();
	    	foreach ($request->horas as $hora) {
		    	$relacion=new User_Actividad;
		    	$relacion->user_id=$request->user_id;
		    	$relacion->actividad_id=$actividad->id;
		    	$relacion->fecha=$fecharecibida;
		    	$relacion->hora=$hora;
		    	$relacion->save();
			}
			if($request->deposito>0){
				$date = Carbon::createFromFormat('d/m/Y H:i',$request->fecha_para_deposito)->format('Y-m-d H:i:s');
				$deposito=new Deposito;
				$deposito->user_id=$request->user_id;
				$deposito->actividad_id=$actividad->id;
				$deposito->deposito_solicitado=$request->deposito;
				$deposito->estado="SOLICITADO";
				$deposito->fecha_para_deposito=$date;
				$deposito->coordinacion=$request->coordinacion;
				$deposito->coordinacion_name=$request->coordinacion_name;
				$deposito->centro_costo_id=$request->costo_id;
				$deposito->save();
			}
    	} catch (\Exception $e) {
            Log::error("Error: ".$e->getMessage());
    		DB::rollback();
    		return redirect()->route('asignaciones.index')->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red"]);
    	}
        DB::commit();
    	return redirect()->route('asignaciones.index')->with(['info'=>"Se Genero la Tarea",'color'=>"bg-green"]);
    }

    public function getAjaxActividad(Request $request){



		$actividad=Actividad::with('CentroCosto')->find($request->id);


    	if(!$actividad){
            return response()->json(['status' => 'error','msg' =>  "No se Encontro la Actividad"], 400 );
		}
        return response()->json(['status' => 'OK','actividad' =>  $actividad,'deposito'=>$actividad->Deposito]);
    }

	public function getAjaxModificarActividad(Request $request){

		$actividad=User_Actividad::where('actividad_id',$request->id)->orderBy('id')->get();




    	if(!$actividad){
            return response()->json(['status' => 'error','msg' =>  "No se Encontro la Actividad"], 400 );
		}
		return response()->json(['status' => 'OK','actividad' =>  $actividad]);

    }




    public function setAjaxFalta(SetFaltaRequest $request){
    	$user=User::findorFail($request->user_id);
    	$fecha=str_replace("-", "", $request->fechafalta);
    	DB::beginTransaction();
    	try {
	    	$actividad=new Actividad;
	    	$actividad->nombre="INASISTENCIA";
	    	$actividad->tipo_asistencia_id=-1;
			$actividad->descripcion=($request->nota)??'';
			$actividad->user_id=$request->user_id;
			$actividad->coordinacion=auth()->user()->id;
            $actividad->coordinacion_name= auth()->user()->name. " " . auth()->user()->apaterno;
	    	$actividad->save();
			$horas=[7,8,9,10,11,12,13,14,15,16,17,18,19];
	    	foreach ($horas as $hora) {
		    	$relacion=new User_Actividad;
		    	$relacion->user_id=$request->user_id;
		    	$relacion->actividad_id=$actividad->id;
		    	$relacion->fecha=$fecha;
		    	$relacion->hora=$hora;
		    	$relacion->save();
            }
            $notification=new NotificationRepository('asignaciones.falta');
            $notification->failed('Se creo una Falta',DbToFecha($fecha)."- Se asigno una falta a :".$user->name." ".$user->apaterno." ".$user->amaterno );
		}catch (\Illuminate\Database\QueryException  $e) {
			DB::rollBack();
			Log::error($e->getMessage());
			return back()->with(['info'=>"Error : ".$e->getCode(),'status'=>"Error",'color'=>"bg-red"]);
		}catch (\Exception $e) {
			DB::rollback();
			return back()->with(['info'=>"Error : ".$e->getMessage(),'status'=>"Error",'color'=>"bg-red"]);
		}
        DB::commit();
    	return redirect()->route('asignaciones.index')->with(['info'=>"Se marco la falta",'color'=>"bg-green"]);
    }


    public function setAjaxAtraso(SetAtrasoRequest $request){
    	$user=User::findorFail($request->user_id);
    	$fecha=str_replace("-", "", $request->fechaatraso);
    	DB::beginTransaction();
    	try {
            $inicio = Carbon::createFromFormat('Y-m-d H:i',$request->fechaatraso." ".$request->hora_inicio);
            $llegada = Carbon::createFromFormat('Y-m-d H:i',$request->fechaatraso." ".$request->hora_llegada);
            $atraso=new Atraso;
            $atraso->diferencia=$inicio->diffInMinutes($llegada);
            $atraso->hora_inicio=$inicio->format('Y-m-d H:i:s');
            $atraso->hora_llegada=$llegada->format('Y-m-d H:i:s');
            $atraso->fecha=$fecha;
            $atraso->nota=$request->nota;
            $atraso->user_id=$user->id;
            $atraso->save();
            $notification=new NotificationRepository('asignaciones.atraso');
            $notification->alert('Se creo un Atraso',DbToFecha($fecha)."- Se asigno una atraso de ".$atraso->diferencia." minutos a :".$user->name." ".$user->apaterno." ".$user->amaterno );
		} catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
    		return redirect()->route('asignaciones.index')->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red"]);
        }
        DB::commit();
    	return redirect()->route('asignaciones.index')->with(['info'=>"Se marco el atraso",'color'=>"bg-green"]);
    }


	public function DeleteCheckList(Request $request){
		$actividad=Actividad::findorFail($request->actividad_id);
		try {
			if(auth()->user()->hasRoles('permisos.tecnico')){
				if($actividad->user->id!=auth()->user()->id)
					throw new \Exception("La tarea no la tienes Asignada", 1);
			}
			$actividad->archivo=null;
			$actividad->save();
		}catch (\Illuminate\Database\QueryException  $e) {
			DB::rollBack();
			Log::error($e->getMessage());
			return back()->with(['info'=>"Error : ".$e->getCode(),'status'=>"Error",'color'=>"bg-red"]);
		}catch (\Exception $e) {
			DB::rollback();
			return back()->with(['info'=>"Error : ".$e->getMessage(),'status'=>"Error",'color'=>"bg-red"]);
		}
		DB::commit();
		return back()->with(['info'=>"Se elimino correctamente el Archivo",'color'=>"bg-green"]);
	}

	public function setUploadChecklist(SetUploadCheckListRequest $request){
		$actividad=Actividad::findorFail($request->actividad_id);
		try {
			if(auth()->user()->hasRoles('permisos.tecnico')){
				if($actividad->user->id!=auth()->user()->id)
					throw new \Exception("La tarea no la tienes Asignada", 1);
			}
			if($actividad->fecha_fin==null)
					throw new \Exception("La tarea no esta Finalizada", 1);
			if($actividad->archivo != null)
				throw new \Exception("La tarea ya tiene un archivo Ingresado", 1);

			$file=$request->file('archivo');
			$extension = $file->getClientOriginalExtension();
			$name = time() . str_pad(random_int(1, 1000),4,"0",STR_PAD_LEFT) . "." . $extension;
			$path=$file->storeAs('public/archivos',$name);
			$actividad->archivo='storage/archivos/'.$name;
			$actividad->save();
		}catch (\Illuminate\Database\QueryException  $e) {
			DB::rollBack();
			Log::error($e->getMessage());
			return back()->with(['info'=>"Error : ".$e->getCode(),'status'=>"Error",'color'=>"bg-red"]);
		}catch (\Exception $e) {
			DB::rollback();
			return back()->with(['info'=>"Error : ".$e->getMessage(),'status'=>"Error",'color'=>"bg-red"]);
		}
		DB::commit();
		return back()->with(['info'=>"Se Subio Correctamente el Archivo!",'color'=>"bg-green"]);

	}

    public function setAjaxIniciaFin(SetIniFinRequest $request){
    	$tipo=$request->inifin;
        $actividad=Actividad::findorFail($request->actividad_id);
		$fecha=date('Y-m-d H:i:s');
		DB::beginTransaction();
		try {
			if(auth()->user()->hasRoles('permisos.tecnico')){
				if($actividad->user->id!=auth()->user()->id)
					throw new \Exception("La tarea no la tienes Asignada", 1);
			}
			if($tipo=="iniciar")
				$actividad->fecha_ini=$fecha;
			elseif($tipo=="finalizar")
				$actividad->fecha_fin=$fecha;
			else
				throw new \Exception("Datos incorrectos", 1);

			$actividad->save();
			DB::commit();
		}catch (\Illuminate\Database\QueryException  $e) {
			DB::rollBack();
			Log::error($e->getMessage());
			return back()->with(['info'=>"Error : ".$e->getCode(),'status'=>"Error",'color'=>"bg-red"]);
		}catch (\Exception $e) {
			DB::rollback();
			return back()->with(['info'=>"Error : ".$e->getMessage(),'status'=>"Error",'color'=>"bg-red"]);
		}
    	return back()->with(['info'=>"Se ".$tipo." Correctamente la Tarea",'color'=>"bg-green"]);
    }


    public function destroy(Request $request){
    	DB::beginTransaction();


    	try {
			$actividad=Actividad::where('id',$request->delete_id)->firstorfail();

			$user_activi1= User_Actividad::where('actividad_id',$request->delete_id)->first();
			$user_activi2= User_Actividad::where('actividad_id',$request->delete_id)->orderBy('id','desc')->first();

			$actividad->hora_i = $user_activi1->hora;
			$actividad->hora_f = $user_activi2->hora;

			$actividad->motivo_id = $request->motivo;
			$actividad->solicitado_por_id = $request->solicitado;

			$usuario = User::where('id',$request->solicitado)->first();

			$actividad->solicitado_por_name = $usuario->name ." ". $usuario->apaterno . " ". $usuario->amaterno ;

			if($request->archivo_respaldo)
			{

				$file=$request->file('archivo_respaldo');
			$extension = $file->getClientOriginalExtension();
			$name = time() . str_pad(random_int(1, 1000),4,"0",STR_PAD_LEFT) . "." . $extension;
			$path=$file->storeAs('public/archivos',$name);
			$actividad->respaldo_eliminacion='storage/archivos/'.$name;
			}


			$actividad->save();




			//$actividad_detalle =

		//	dd($actividad);




			$deposito=$actividad->Deposito;
			if($deposito){
        		if($deposito->estado=='RENDIDO'||$deposito->estado=='VALIDADO'){
					throw new \Exception("La Actividad ya tiene deposito ".$deposito->estado, 1);
                }
                if($deposito->estado=='DESPOSITADO'){
                    $anticipo=new Anticipo;
                    $anticipo->created_by=auth()->user()->id;
                    $anticipo->user_id=$actividad->user_id;
                    $anticipo->monto=$deposito->deposito_depositado;
                    $anticipo->nota="Generado por Eliminacion de Actividad :".$actividad->id;
					$anticipo->actividad_id = $actividad->id;
					$anticipo->deposito_id = $deposito->id;
					$deposito_archi = Deposito_Archivo::where('deposito_id',$deposito->id)->where('tipo','DEPOSITO')->first();


					$anticipo->archivo_deposito = $deposito_archi->archivo;



                    $anticipo->save();
                   /* $archivos_adj=$deposito->archivo;
                    foreach ($archivos_adj as $adj){
                        //$adj->delete();
                    }*/
                    $deposito->delete();
                }
                if($deposito->estado=='SOLICITADO'){
					$deposito->delete();
                }
			}
			User_Actividad::where('actividad_id',$request->delete_id)->delete();
			$actividad->delete();
		}catch (\Illuminate\Database\QueryException  $e) {
			DB::rollBack();
			Log::error($e->getMessage());
			return back()->with(['info'=>"Error : ".$e->getCode(),'status'=>"Error",'color'=>"bg-red"]);
		}catch (\Exception $e) {
			DB::rollback();
			return back()->with(['info'=>"Error : ".$e->getMessage(),'status'=>"Error",'color'=>"bg-red"]);
		}
		DB::commit();
        return redirect()->route('asignaciones.index')->with(['info'=>"Se elimino la Asignacion",'color'=>"bg-green"]);
    }

    public function isFree($user_id,$fecha,$horas){
        $horas=explode(',',$horas);
        $fecha=str_replace("-","",$fecha);
        $actividad=User_Actividad::where('user_id',$user_id)->where('fecha',$fecha)->whereIn('hora',$horas)->first();
        if($actividad){
            return response()->json(['status' => 'error','msg' =>  "El usuario tiene asignaciones, debe eliminarlas primero!"], 400 );
		}
       return response()->json(['status' => 'OK']);
    }

	public function hora(Request $request){
    	//DB::beginTransaction();


		$actividad_m = new Actividad_Modificacion();
		$actividad_m->actividad_id= $request->actividad_id_modificacion;
		$actividad_m->motivo_id = $request->motivo_modificar;

		$user_activi1= User_Actividad::where('actividad_id',$request->actividad_id_modificacion)->first();
			$user_activi2= User_Actividad::where('actividad_id',$request->actividad_id_modificacion)->orderBy('id','desc')->first();

			$actividad_m->hora_i = $user_activi1->hora;
			$actividad_m->hora_f = $user_activi2->hora;

			$actividad_m->solicitado_por_id = $request->solicitado_modificar;

			$usuario = User::where('id',$request->solicitado_modificar)->first();

			$actividad_m->solicitado_por_name = $usuario->name ." ". $usuario->apaterno . " ". $usuario->amaterno ;

			if($request->archivo_respaldo_modificar)
			{

				$file=$request->file('archivo_respaldo_modificar');
			$extension = $file->getClientOriginalExtension();
			$name = time() . str_pad(random_int(1, 1000),4,"0",STR_PAD_LEFT) . "." . $extension;
			$path=$file->storeAs('public/archivos',$name);
			$actividad_m->respaldo_modificacion='storage/archivos/'.$name;
			}

			$actividad_m->save();

	    	foreach ($request->horas as $hora) {
		    	$user= User_Actividad::findOrFail($hora);;
		    	$user->delete();
			}


		//	DB::commit();

    	return redirect()->route('asignaciones.index')->with(['info'=>"Se Modifico la Tarea",'color'=>"bg-green"]);
    }

	public function Masiva(Request $request){

		if (isset( $request->seleccion_masiva)) {

		$seleccion_masiva = $request->seleccion_masiva;


		foreach($seleccion_masiva as $s)
		{

		if($s == "Proyectos")
		{

           $proyecto = \App\Proyecto::where('id',$request->proyecto_masivo)->firstorfail();
		   DB::beginTransaction();

		   try {
			$fechas=explode(" - ", $request->fechadatos);
			$start_date = Carbon::createFromFormat('m/d/Y', $fechas[0]);
            $end_date = Carbon::createFromFormat('m/d/Y', $fechas[1]);
			$period = new \Carbon\CarbonPeriod($start_date, '1 day', $end_date);

			//$proyecto=Proyecto::find($request->proyecto_id);
    	$comuna=Comuna::find($request->comuna_id);
		$datos="";
		$datos.="Cliente: ".$proyecto->Cliente->nombre."\n";
		$datos.="Proyecto: ".$proyecto->nombre."\n";
		$datos.="Nro. Actividad: ".$request->actividad."\n";
		$datos.="Direccion: ".$request->direccion."\n";
		$datos.="Comuna: ".$comuna->nombre."\n";
		$datos.="Usuario: ".$request->usuario."\n";
		$datos.="Detalle: ".$request->detalle."\n";
		$datos.="Nota: ".$request->nota."\n";
			foreach ($period as $dt) {

				$dia_actual = $dt->format("w");
				$dia_actual = intval($dia_actual);



				if($dia_actual > 0 && $dia_actual < 6)
				{

					$usuario = \App\User::where('proyecto_id',$request->proyecto_masivo)->get();
				foreach($usuario as $us)
				{
					$actividad=new \App\Actividad;
					$actividad->nombre=$request->actividad;
					$actividad->tipo_asistencia_id=0;
					$actividad->proyecto_id=$request->proyecto_masivo;
					$actividad->comuna_id=$request->comuna_id;
			$actividad->descripcion=$datos;

					$actividad->user_id=$us->id;
					$actividad->coordinacion=auth()->user()->id;
					$actividad->coordinacion_name=auth()->user()->name ." ". auth()->user()->apaterno;
					$actividad->centro_costo_id=0;
				    $actividad->save();

					//dd("estoy");
				//	$horas=[7,8,9,10,11,12,13,14,15,16,17,18,19];
					$horas = $request->horas;

				//	dd($horas);
						foreach ($horas as $hora) {
							$relacion=new \App\User_Actividad;
							$relacion->user_id=$us->id;
							$relacion->actividad_id=$actividad->id;
							$relacion->fecha=$dt->format("Ymd");
							$relacion->hora=$hora;
						    $relacion->save();
						}
						DB::commit();

				}


					} // fin del if del dia actual


				} // fin del foreach de periodo


    	} catch (\Exception $e) {
    		DB::rollback();
    		return redirect()->route('asignaciones.index')->with(['info'=>$e->getMessage(),'color'=>"bg-red"]);
    	}

		return redirect()->route('asignaciones.index')->with(['info'=>"Se Guardaron las Asignaciones Masiva",'color'=>"bg-green"]);

		}

		if($s == "Usuarios")
		{
           $usuario = \App\User::where('id',$request->usuario_masivo)->firstorfail();
		   DB::beginTransaction();

		   try {
			$fechas=explode(" - ", $request->fechadatos);
			$start_date = Carbon::createFromFormat('m/d/Y', $fechas[0]);
            $end_date = Carbon::createFromFormat('m/d/Y', $fechas[1]);
			$period = new \Carbon\CarbonPeriod($start_date, '1 day', $end_date);

			$proyecto=Proyecto::find($request->proyecto_id);
    	$comuna=Comuna::find($request->comuna_id);
		$datos="";
		$datos.="Cliente: ".$proyecto->Cliente->nombre."\n";
		$datos.="Proyecto: ".$proyecto->nombre."\n";
		$datos.="Nro. Actividad: ".$request->actividad."\n";
		$datos.="Direccion: ".$request->direccion."\n";
		$datos.="Comuna: ".$comuna->nombre."\n";
		$datos.="Usuario: ".$request->usuario."\n";
		$datos.="Detalle: ".$request->detalle."\n";
		$datos.="Nota: ".$request->nota."\n";
			foreach ($period as $dt) {

				$dia_actual = $dt->format("w");
				$dia_actual = intval($dia_actual);



				if($dia_actual > 0 && $dia_actual < 6)
				{


					$actividad=new \App\Actividad;
					$actividad->nombre=$request->actividad;
					$actividad->tipo_asistencia_id=0;
					$actividad->proyecto_id=$request->proyecto_id;
					$actividad->comuna_id=$request->comuna_id;
			$actividad->descripcion=$datos;

					$actividad->user_id=$usuario->id;
					$actividad->coordinacion=auth()->user()->id;
					$actividad->coordinacion_name=auth()->user()->name ." ". auth()->user()->apaterno;
					$actividad->centro_costo_id=0;
				    $actividad->save();


				//	$horas=[7,8,9,10,11,12,13,14,15,16,17,18,19];


						foreach ($request->horas as $hora) {
							$relacion=new \App\User_Actividad;
							$relacion->user_id=$usuario->id;
							$relacion->actividad_id=$actividad->id;
							$relacion->fecha=$dt->format("Ymd");
							$relacion->hora=$hora;
						    $relacion->save();
						}




					} // fin del if del dia actual
					DB::commit();

				} // fin del foreach de periodo


    	} catch (\Exception $e) {
    		DB::rollback();
    		return redirect()->route('asignaciones.index')->with(['info'=>$e->getMessage(),'color'=>"bg-red"]);
    	}

		return redirect()->route('asignaciones.index')->with(['info'=>"Se Guardaron las Asignaciones Masiva",'color'=>"bg-green"]);
		}

	} // fin al foreach de seleccion masiva


} // fin a la validacion del array de seleccion masiva

else{
	return redirect()->route('asignaciones.index')->with(['info'=>"Debe Seleccionar que tipo de Asignacion Realizara",'color'=>"bg-red"]);
}


	} // fin de la funcion masiva

	public function Reportes_asignaciones($fecha)
	{
		$fecha2=str_replace("-","",$fecha);
        $asignacion=new AsignacionExcel($fecha2);
        $asignacion->download();

	}


}
