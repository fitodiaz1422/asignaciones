<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getDiasHabiles($fechainicio, $fechafin) {
        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);

        // Incremento en 1 dia
        $diainc = 24*60*60;

        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
        $findesemana=0;
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil

                                array_push($diashabiles, date('Y-m-d', $midia));

                }else{
                    $findesemana++;
                }
        }

        return $findesemana;
}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $fecha=date('Y-m-d');
        $fecha2=date('Y-m-d');
        if($request->fecha)
            $fecha=$request->fecha;

        if($request->fecha2)
            $fecha2=$request->fecha2;

            /// TO DO //
            //CORREGIR INFORME//
        $firstDay = Carbon::createFromFormat('Y-m-d', $fecha2)->firstOfMonth()->format('Y-m-d');
        $lastDay = Carbon::createFromFormat('Y-m-d', $fecha2)->lastOfMonth()->format('Y-m-d');
        $dias=$this->getDiasHabiles($firstDay,$lastDay);
        $act=\App\User_Actividad::selectRaw('actividad_id, fecha')
        ->whereRaw('left(users_actividades.fecha,6) = '.substr(str_replace('-','',$fecha2),0,6))
        ->groupByRaw('fecha,actividad_id');

        $usr=\App\User::where('proyecto_id',15);

        $total2=DB::table('actividades')
        ->selectRaw('actividades.tipo_asistencia_id, count(actividades.tipo_asistencia_id) as cantidad,ta.nombre')
        ->rightjoinSub($act, 'ua', function ($join) {
            $join->on('ua.actividad_id', '=', 'actividades.id');
        })
        ->rightjoinSub($usr, 'usr', function ($join) {
            $join->on('usr.id', '=', 'actividades.user_id');
        })
        ->join('tipo_asistencias AS ta','ta.tipo','=','actividades.tipo_asistencia_id')
        ->groupby('actividades.tipo_asistencia_id','ta.nombre')
        ->get();
        $total2[]=(Object)[
            'tipo_asistencia_id'=>-10,
            'nombre'=>'SIN ASIGNAR',
        'cantidad'=>($usr->count()*(31-$dias)-$total2->sum('cantidad')) ];
        //dd($total2);



        $proyectos=\App\Proyecto::orderby('nombre')->get();
        $totales=array();
        $vacios=array();
        foreach ($proyectos as $proyecto) {
            $total=new \stdClass();
            $arr=array();
            $roles=\App\Role::where('name','permisos.tecnico')->first();
            $roles2=\App\Role::where('name','ver.grafico')->first();
            if($roles){
                $dato=DB::table('users')->selectRaw('DISTINCT users.id')
                ->leftJoin('users_actividades','users.id','=','users_actividades.user_id')
                ->where('proyecto_id',$proyecto->id)
                ->whereNull('users.deleted_at')
                ->where('fecha',str_replace("-", "", $fecha));

                if(!$proyecto->by_area)
                    $dato=$dato->join('roles_users', function ($join) use ($roles, $roles2) {
                        $join->on('users.id', '=', 'roles_users.user_id')
                             ->whereIn('roles_users.role_id',[$roles->id, $roles2->id]);
                    });
                $dato=$dato->get();

                foreach ($dato as $value) {
                    $arr[]=$value->id;
                }

                $total->proyecto=$proyecto;
                $total->usados=$dato->count();
                if($proyecto->by_area){
                    $total->users=DB::table('users')->selectRaw('areas.id, areas.nombre, count(IFNULL(areas.id,1)) as count')
                    ->leftjoin('areas','areas.id','=','users.area_id')
                    ->where('proyecto_id',$proyecto->id)
                    ->whereNotIn('users.id',$arr)
                    ->whereNull('users.deleted_at')
                    ->groupby('areas.nombre','areas.id')
                    ->get();
                }else{
                    $total->users=DB::table('users')->selectRaw('regiones.id, regiones.nombre, count(regiones.id) as count')
                    ->leftJoin('comunas','users.comuna_id','=','comunas.id')
                    ->leftJoin('regiones','comunas.region_id','=','regiones.id')
                    ->rightjoin('roles_users', function ($join) use ($roles, $roles2) {
                        $join->on('users.id', '=', 'roles_users.user_id')
                             ->whereIn('roles_users.role_id',[$roles->id,$roles2->id]);
                    })
                    ->where('proyecto_id',$proyecto->id)
                    ->whereNotIn('users.id',$arr)
                    ->whereNull('users.deleted_at')
                    ->groupby('regiones.id','regiones.nombre','regiones.id')
                    ->get();
                }
                $total->total=$total->users->sum('count');
                if(!(($total->total==0)&&($total->usados==0)))
                    $totales[]=$total;

            }








            



        }

        $tab_active=($request->tab_active)??'custom-tabs-two-home-tab';
        //dd(tab_active);
        return view('home.index',compact('totales','fecha','fecha2','total2','vacios','tab_active'));
    }
}
