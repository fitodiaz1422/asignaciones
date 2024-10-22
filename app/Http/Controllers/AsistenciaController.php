<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AsistenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$users=\App\User::where('usuario_cliente',null)->get();
    	$users_tipo=\App\User_Actividad::selectRaw("user_id,actividad_id, min(fecha) as minf, max(fecha) as maxf")->with('Usuario')->with('Actividad')->groupBy('actividad_id','user_id')->havingRaw(('max(fecha)>='.date('Ymd')))->get();
    	$tipos_asistencias=\App\TipoAsistencia::where('tipo','<>',0)->where('estado','=','ACTIVO')->get();
    	return view('asistencias.index',compact('users','users_tipo','tipos_asistencias'));
    }

    public function store(Request $request){
        $tipo=\App\TipoAsistencia::where('tipo',$request->tipo)->firstorfail();
    	DB::beginTransaction();
    	try {
            $actividad=new \App\Actividad;
            $actividad->nombre=$tipo->nombre;
            $actividad->tipo_asistencia_id=$tipo->tipo;
            $actividad->descripcion=($request->nota)??"";
            $actividad->user_id=$request->usuario_id;
            $actividad->coordinacion=auth()->user()->id;
            $actividad->save();
            $fechas=explode(" - ", $request->fechadatos);
            $start_date = Carbon::createFromFormat('m/d/Y', $fechas[0]);
            $end_date = Carbon::createFromFormat('m/d/Y', $fechas[1]);
            $horas=[7,8,9,10,11,12,13,14,15,16,17,18,19];
            $period = new \Carbon\CarbonPeriod($start_date, '1 day', $end_date);
            foreach ($period as $dt) {
                foreach ($horas as $hora) {
                    $relacion=new \App\User_Actividad;
                    $relacion->user_id=$request->usuario_id;
                    $relacion->actividad_id=$actividad->id;
                    $relacion->fecha=$dt->format("Ymd");
                    $relacion->hora=$hora;
                    $relacion->save();
                }
            }
            DB::commit();
    	} catch (\Exception $e) {
    		DB::rollback();
    		return redirect()->route('asistencia.index')->with(['info'=>$e->getMessage(),'color'=>"bg-red"]);
    	}


    	return redirect()->route('asistencia.index')->with(['info'=>"Se Guardo la Asistencia",'color'=>"bg-green"]);

    }


    public function carta_amonestacion(Request $request){	

        $date = Carbon::now();

        $mes = $date->format('m');
        $anio = $date->format('Y');

        $fecha_c = $anio.'-'.$mes;

        if($request->fechaasign)
        {
            $fecha_c=$request->fechaasign;
           $anio = substr($fecha_c,0,4);
           $mes = substr($fecha_c,5,2);
           
        }
    		
    
       

        //dd($anio);


        $inasistencias = DB::table('actividades')
     //   ->select('ac.id','ac.descripcion','users_actividades.fecha','users.id','users.name','users.apaterno')
     ->select('actividades.id as actividad_id','actividades.descripcion','users_actividades.fecha','users.id as user_id','users.name','users.apaterno','users.amaterno',DB::raw('date_format(fecha, "%d-%m-%Y") as fecha_formateada, date_format(fecha, "%Y%m%d") as fecha_formateada2 '))
    ->Join('users_actividades', function($join)
    {
        $join->on('actividades.id','=','users_actividades.actividad_id')
             ->where('users_actividades.hora','=',7);
    })
    ->Join('users','users.id','=','actividades.user_id')
    ->where('actividades.estado_inasistencia','=',null)
    ->where('actividades.tipo_asistencia_id','=','-1')
    ->whereRaw('EXTRACT(MONTH FROM fecha) = ?',[$mes])
    ->whereRaw('EXTRACT(YEAR FROM fecha) = ?',[$anio])
    ->get();

        $amonestacion = DB::table('amonestaciones')
        ->Join('users','users.id','=','amonestaciones.user_id')
        ->whereRaw('EXTRACT(MONTH FROM fecha_actividad) = ?',[$mes])
        ->whereRaw('EXTRACT(YEAR FROM fecha_actividad) = ?',[$anio])
        ->orderBy('user_id')
        ->get();

        //dd($amonestacion);

    	
    	return view('asistencias.amonestacion',compact('inasistencias','amonestacion','mes','anio','fecha_c'));
    }

    public function importAmonestacionPDF(Request $request){
        $date = Carbon::now();
        $file=$request->file('archivo');
        $actividades=\App\Actividad::findOrFail($request->solicitud);

        $path=$file->store('public/amonestacion');

       /* if($request->tipo=="original"){
             $solicitud->guia_original=$path;
        }*/
        if($request->tipo=="final"){
            $actividades->estado_inasistencia="Amonestado";
        //     $solicitud->guia_final=$path;
        $amonestacion = new \App\Amonestacion;
        $amonestacion->fecha = $date->toDateString();
        $amonestacion->amonestacion = str_replace('public','storage',$path);
        $amonestacion->estado = "AMONESTADO";
        $amonestacion->actividad_id = $request->solicitud;
        $amonestacion->user_id = $actividades->user_id;
        $amonestacion->fecha_actividad = $request->fecha;

        $amonestacion->save();
        }
      /*  if($request->tipo=="transito"){
            $FechaActual=new \DateTime();
            $FechaActual=$FechaActual->format('Y-m-d H:i:s');
            $solicitud->guia_transito=$path;
            $solicitud->estado="PENDIENTE";
            $solicitud->updated_at=$FechaActual;
            $solicitud->updated_by=auth()->user()->id;
            DB::table('actividades')->where('solicitud_id',$solicitud->id)->where('estado','<>','FINALIZADA')->update([
                'estado'=>"PENDIENTE"
            ]);

            $mov=DB::table('movimientos_detalle')->where('movimiento_id',$solicitud->movimiento_id)->get();
            foreach ($mov as $prod) {
                DB::table('productos')->where('id',$prod->serie_id)->update([
                    'proceso'=>'ACTIVIDAD'
                ]);
            }


        }*/

        $actividades->save();

        /*return redirect()->route('carta_amonestacion.index')->with(['info'=>"Se subio Carta de Amonestacion de forma correcta",'color'=>"bg-green"]);*/



       return response()->json([
            "status" => "OK"
        ]);
       // $files1 = "../storage/app/".$path;
    }

    function Bono(Request $request){

        $date = Carbon::now();

        $mes = $date->format('m');
        $anio = $date->format('Y');

        $fecha_c = $anio.'-'.$mes;

        if($request->fechaasign)
        {
            $fecha_c=$request->fechaasign;
           $anio = substr($fecha_c,0,4);
           $mes = substr($fecha_c,5,2);
           
        }

        $bono = \App\Bonos::select('users.rut','users.name','users.apaterno','bonos.id','bonos.nota','bonos.monto','bonos.fecha','bonos.created_at','bonos.jp_id','bonos.name_jp')
        ->join('users','users.id','=','bonos.user_id')
        ->where('jp_id', auth()->user()->id)
        ->whereRaw('EXTRACT(MONTH FROM fecha) = ?',[$mes])
        ->whereRaw('EXTRACT(YEAR FROM fecha) = ?',[$anio])
        ->get();

        $bono_total = \App\Bonos::select('users.rut','users.name','users.apaterno','users.amaterno','bonos.id','bonos.nota','bonos.monto','bonos.fecha','bonos.created_at','bonos.jp_id','bonos.name_jp','bonos.user_id')
        ->join('users','users.id','=','bonos.user_id')
        ->whereRaw('EXTRACT(MONTH FROM fecha) = ?',[$mes])
        ->whereRaw('EXTRACT(YEAR FROM fecha) = ?',[$anio])
        ->orderBy('bonos.user_id')
        ->get();

        $bono_contador = \App\Bonos::select('users.rut','users.name','users.apaterno','users.amaterno','bonos.id','bonos.nota','bonos.monto','bonos.fecha','bonos.created_at','bonos.jp_id','bonos.name_jp','bonos.user_id')
        ->join('users','users.id','=','bonos.user_id')
        ->whereRaw('EXTRACT(MONTH FROM fecha) = ?',[$mes])
        ->whereRaw('EXTRACT(YEAR FROM fecha) = ?',[$anio])
        ->count();

        

        $users=\App\User::where('usuario_cliente',null)->get();
    	$users_tipo=\App\User_Actividad::selectRaw("user_id,actividad_id, min(fecha) as minf, max(fecha) as maxf")->with('Usuario')->with('Actividad')->groupBy('actividad_id','user_id')->havingRaw(('max(fecha)>='.date('Ymd')))->get();
    	$tipos_asistencias=\App\TipoAsistencia::where('tipo','<>',0)->get();
    	return view('asistencias.bono',compact('users','users_tipo','tipos_asistencias','mes','anio','fecha_c','bono','bono_total','bono_contador'));

    }

    function BonoStore(Request $request){

        $date = Carbon::now();

        $fecha_c=$request->mes_ingreso;
        $anio = substr($fecha_c,0,4);
        $mes = substr($fecha_c,5,2);

        $bono_count = \App\Bonos::select('users.name','users.apaterno','bonos.id','bonos.nota','bonos.monto','bonos.fecha','bonos.created_at','bonos.jp_id','bonos.name_jp')
        ->join('users','users.id','=','bonos.user_id')
        ->where('jp_id', auth()->user()->id)
        ->where('user_id', $request->usuario_id)
        ->whereRaw('EXTRACT(MONTH FROM fecha) = ?',[$mes])
        ->whereRaw('EXTRACT(YEAR FROM fecha) = ?',[$anio])
        ->count();

     if($bono_count == 0)
     {

        $bono = new \App\Bonos;
        $bono->user_id = $request->usuario_id;
        $bono->nota = $request->nota;
        $bono->monto = $request->total_ingreso;

        $mes = $request->mes_ingreso;

        

        $mes = str_replace('-','',$mes);
        $mes = $mes.'01';

       



        $bono->fecha = $mes;
        $bono->created_at = $date;
        $bono->jp_id = auth()->user()->id;
        $bono->name_jp = auth()->user()->name ." " . auth()->user()->apaterno;

        $bono->save();

        return redirect()->route('bono.index')->with(['info'=>"Se Guardo el Bono",'color'=>"bg-green"]);


     }else{

        return redirect()->route('bono.index')->with(['info'=>"Solo puede asignar 1 bono por persona al mes",'color'=>"bg-red"]);

     }

        
        
        


    }



    function BonoEdit(Request $request){

        $date = Carbon::now();



        $bono_edit = \App\Bonos::where('id', $request->bono_id)->first();

        DB::table('bonos_actualizacion')->insert(['bonos_id' => $bono_edit->id, 'nota' => $bono_edit->nota, 'monto' => $bono_edit->monto, 'fecha' => $date]);




        $bono = \App\Bonos::where('id', $request->bono_id)->first();
       
        $bono->nota = $request->nota;
        $bono->created_at = $date;
        $bono->monto = $request->total_ingreso;


        $bono->save();

        return redirect()->route('bono.index')->with(['info'=>"Se modifico el Bono",'color'=>"bg-green"]);


    

        
        
        


    }






}
