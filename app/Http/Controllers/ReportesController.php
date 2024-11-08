<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Excel\UsuariosExcel;
use App\Http\Excel\AsistenciaExcel;
use App\Http\Excel\AtrasoExcel;
use App\Http\Excel\ProyectoTecnicosExcel;
use App\Http\Resources\exportUsers;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function asistencia(){
        return view('reportes.asistencia');
    }

    public function asistenciaPost(Request $request){
        $fecha=str_replace("-","",$request->fecha);
        $asistencia=new AsistenciaExcel($fecha);
        $asistencia->download();
    }

    public function atraso(){
        return view('reportes.atraso');
    }

    public function atrasoPost(Request $request){
        $fecha=str_replace("-","",$request->fecha);
        $asistencia=new AtrasoExcel($fecha);
        $asistencia->download();
    }

    public function Usuarios(){
        $arr=datosUsuario();
        return view('reportes.usuarios',compact('arr'));
    }

    public function UsuariosPost(Request $request){
        $asistencia=new UsuariosExcel($request->campos);
        $asistencia->download();
    }


    public function DepositosProyectos(){
        return view('reportes.depositos_proyectos');
    }

    public function DepositosProyectosPost(Request $request){
        $depositos=\App\Deposito::selectRaw('SUM(deposito_depositado) as depositado, proyectos.nombre')
        ->leftJoin('actividades','actividades.id','=','depositos.actividad_id')
        ->leftJoin('proyectos','proyectos.id','=','actividades.proyecto_id')
        ->where('depositos.estado','DESPOSITADO')
        ->whereBetween('fecha_para_deposito', [$request->fechaini, $request->fechafin])
        ->groupBy('proyectos.nombre')
        ->get();
        return view('reportes.depositos_proyectos',compact('depositos'), [$request->flash()]);
    }


    public function ProyectosTecnicos(){
        $proyectos=\App\Proyecto::all();
        return view('reportes.proyectos_tecnicos',compact('proyectos'));
    }

    public function ProyectosTecnicosPost(Request $request){
        $proyecto=\App\Proyecto::findorfail($request->proyecto_id);
        $fecha=str_replace("-","",$request->fecha);
        $proyecto_tecnicos=new ProyectoTecnicosExcel($fecha,$proyecto);
        $proyecto_tecnicos->download();
    }
    
     public function control_coordinacion(){
        return view('reportes.control_coordinacion');
    }

    public function control_coordinacionPost(Request $request){
        
        $fechaIni = date("Ymd",strtotime($request->fechaini));
        $fechaFin = date("Ymd",strtotime($request->fechafin));
        
      /*  $actividades=\App\Actividad::selectRaw('DISTINCT(actividades.id), actividades.fecha_ini, actividades.fecha_fin, actividades.nombre,actividades.coordinacion, actividades.coordinacion_name')
        ->Join('users_actividades','users_actividades.actividad_id','=','actividades.id')
        ->whereBetween('users_actividades.fecha', [$fechaIni, $fechaFin])
        ->get();*/
        $actividades=\App\Actividad::selectRaw('COUNT(DISTINCT(actividades.id)) as cantidad,actividades.coordinacion, actividades.coordinacion_name')
        ->Join('users_actividades','users_actividades.actividad_id','=','actividades.id')
        ->whereBetween('users_actividades.fecha', [$fechaIni, $fechaFin])
        ->groupBy('actividades.coordinacion','actividades.coordinacion_name')
        ->get();
        
      /*  $ini=\App\Actividad::selectRaw('count(actividades.fecha_ini) as ini,actividades.coordinacion, actividades.coordinacion_name')
        ->Join('users_actividades','users_actividades.actividad_id','=','actividades.id')
        ->whereBetween('users_actividades.fecha', [$fechaIni, $fechaFin])
        ->groupBy('actividades.coordinacion','actividades.coordinacion_name')
        ->get();*/
        
        $ini=DB::select(DB::raw('SELECT count(a.fecha_ini) as ini,a.coordinacion, a.coordinacion_name FROM actividades  as a
JOIN (SELECT DISTINCT(users_actividades.actividad_id) as id FROM users_actividades WHERE users_actividades.fecha BETWEEN "'.$fechaIni.'" and "'.$fechaFin.'") x  ON x.id = a.id
group BY a.coordinacion, a.coordinacion_name'));
        
     /*   $fin=\App\Actividad::selectRaw('count(actividades.fecha_fin) as fin,actividades.coordinacion, actividades.coordinacion_name')
        ->Join('users_actividades','users_actividades.actividad_id','=','actividades.id')
        ->whereBetween('users_actividades.fecha', [$fechaIni, $fechaFin])
        ->groupBy('actividades.coordinacion','actividades.coordinacion_name')
        ->get();*/
        
         $fin=DB::select(DB::raw('SELECT count(a.fecha_fin) as fin,a.coordinacion, a.coordinacion_name FROM actividades  as a
JOIN (SELECT DISTINCT(users_actividades.actividad_id) as id FROM users_actividades WHERE users_actividades.fecha BETWEEN "'.$fechaIni.'" and "'.$fechaFin.'") x  ON x.id = a.id
group BY a.coordinacion, a.coordinacion_name'));
        
        $actividades = json_decode(json_encode($actividades), FALSE);
        $ini = json_decode(json_encode($ini), FALSE);
        $fin = json_decode(json_encode($fin), FALSE);
        
   /*     $grouped = $actividades->mapToGroups(function ($item, $key) {
    return [$item['coordinacion'] => $item['id']];
});*/

//dd($ini);
    // $result = $actividades->merge($ini);
    // dd($actividades[1]->coordinacion);
     //  $grouped = $actividades->groupBy('coordinacion');
     $collection = array();
        foreach($actividades as $a){
            
            $aini = 0;
            $afin = 0;
            
          foreach($ini as $i)
          {
              
            //  dd($i);
              if ($a->coordinacion == $i->coordinacion)
              {
                  $aini = $i->ini;
                  
              }
          }
           foreach($fin as $f)
          {
              
            //  dd($i);
              if ($a->coordinacion == $f->coordinacion)
              {
                  $afin = $f->fin;
                  
              }
          }
          
          
            
             if($aini == 0)
             {
                  if($afin == 0)
             {
                  array_push($collection, [
            'coordinacion' => $a->coordinacion,
            'nombre' => $a->coordinacion_name,
            'actividades' => $a->cantidad,
            'ini' => "0",
            'fin' => "0",
        ]); 
             }
             else{
                  array_push($collection, [
            'coordinacion' => $a->coordinacion,
            'nombre' => $a->coordinacion_name,
            'actividades' => $a->cantidad,
            'ini' => "0",
            'fin' => $afin,
        ]); 
             }
                
                     
                 
                   }
                     
                   
                   
               
              
             
             else{
                 
                 if($afin == 0)
             {
                 array_push($collection, [
            'coordinacion' => $a->coordinacion,
            'nombre' => $a->coordinacion_name,
            'actividades' => $a->cantidad,
            'ini' => $aini,
            'fin' => "0",
             ]);
             
                 
             }
             
             else{
                 array_push($collection, [
            'coordinacion' => $a->coordinacion,
            'nombre' => $a->coordinacion_name,
            'actividades' => $a->cantidad,
            'ini' => $aini,
            'fin' => $afin,
             ]);
                 
             }
                       
                  
                   
                  
                     
                   
                   
               }
                 //dd("chao");
               
             
        }
        //dd($collection);
        $collection = json_decode(json_encode($collection), FALSE);
       /* $depositos=\App\Deposito::selectRaw('SUM(deposito_depositado) as depositado, proyectos.nombre')
        ->leftJoin('actividades','actividades.id','=','depositos.actividad_id')
        ->leftJoin('proyectos','proyectos.id','=','actividades.proyecto_id')
        ->where('depositos.estado','DESPOSITADO')
        ->whereBetween('fecha_para_deposito', [$request->fechaini, $request->fechafin])
        ->groupBy('proyectos.nombre')
        ->get();*/
        return view('reportes.control_coordinacion',compact('collection'), [$request->flash()]);
    }
    
     public function centro_costo(){
        return view('reportes.centro_costo');
    }

    public function centro_costoPost(Request $request){
        $centro=\App\Deposito::selectRaw('deposito_depositado as depositado, proyectos.nombre,centro_costos.descripcion as costo,actividades.nombre as actividad, actividades.descripcion as nota, depositos.coordinacion_name as coordinador, CONCAT(users.name , " " , users.apaterno , " " , users.amaterno) as tecnico, date_format(depositos.fecha_para_deposito, "%d-%m-%Y") as fdeposito ')
        ->leftJoin('actividades','actividades.id','=','depositos.actividad_id')
        ->leftJoin('proyectos','proyectos.id','=','actividades.proyecto_id')
        ->leftJoin('centro_costos','centro_costos.id','=','depositos.centro_costo_id')
        ->leftJoin('users','users.id','=','depositos.user_id')
        ->where('depositos.estado','DESPOSITADO')
        ->whereBetween('fecha_para_deposito', [$request->fechaini, $request->fechafin])
       // ->groupBy('proyectos.nombre')
        ->get();
        return view('reportes.centro_costo',compact('centro'), [$request->flash()]);
    }
    
}
