<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Repositories\Users\CreateUsersRepository;
use App\Http\Requests\UpdateSelfRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    private $user_repo;

    public function __construct(CreateUsersRepository $repo)
    {
        $this->middleware('auth');
        $this->user_repo=$repo;
    }

    public function index(){
        $users=\App\User::withTrashed()->orderBy('deleted_at','asc')->orderBy('id','asc')->get();
        return view('users.index',compact('users'));
    }

    public function create(){
        $comunas=\App\Comuna::all();
        $clientes =\App\Cliente::all();
        $proyectos=\App\Proyecto::where('estado','ACTIVO')->get();
        $cargos=\App\Cargo::all();
        $roles=\App\Role::orderby('global_group')->get();
        $empresas=\App\Empresa::all();
        $bancos=\App\Banco::all();
        $afps=\App\Afp::all();
        $previsiones=\App\Prevision::all();
        $tipocuentas=\App\TipoCuenta::all();
        $tipocontratos=\App\TipoContrato::all();
        $skills=\App\Skill::all();
        $herramientas=\App\Herramienta::all();
        $notifications=\App\Notifyrole::orderby('global_group')->get();
        $areas=\App\Area::all();
        return view('users.create',compact('comunas','proyectos','cargos','herramientas','roles','afps','bancos','empresas','previsiones','tipocuentas','tipocontratos','skills','notifications','clientes','areas'));
    }

    public function store(Request $request){
        if($request->password!=$request->reppassword){
            return back()->with(['info'=>"Las Contraseñas no son iguales!",'color'=>"bg-red", $request->flash()]);
        }
        DB::beginTransaction();
        try {
            $this->user_repo->store($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al crear usuario: '.$e->getMessage());
            return back()->with(['info'=>"Error: ".$e->getCode()." mensaje: " .$e->getMessage(),'color'=>"bg-red", $request->flash()]);
        }
       return back()->with(['info'=>"Usuario Creado Correctamente!",'color'=>"bg-green"]);
    }

    public function edit($id){
        $user=\App\User::findorFail($id);
        $comunas=\App\Comuna::all();
        $proyectos=\App\Proyecto::where('estado','ACTIVO')->get();
        $cargos=\App\Cargo::all();
        $roles=\App\Role::orderby('global_group')->get();
        $empresas=\App\Empresa::all();
        $bancos=\App\Banco::all();
        $afps=\App\Afp::all();
        $previsiones=\App\Prevision::all();
        $tipocuentas=\App\TipoCuenta::all();
        $tipocontratos=\App\TipoContrato::all();
        $skills=\App\Skill::all();
        $herramientas=\App\Herramienta::all();
        $notifications=\App\Notifyrole::orderby('global_group')->get();
        $users_clientes=\App\Users_Clientes::where('user_id',$id)->get();
        $areas=\App\Area::all();
       // $users_clientes = $users_clientes->collapse();
        //$users_clientes = $users_clientes->all();
        //dd($users_clientes);
        $users_clientes_count=\App\Users_Clientes::where('user_id',$id)->count();
        $clientes =\App\Cliente::all();
        return view('users.edit',compact('comunas','proyectos','cargos','user','roles','afps','bancos','empresas','herramientas','previsiones','tipocuentas','tipocontratos','skills','notifications','users_clientes','users_clientes_count','clientes','areas'));
    }


    public function show($id){
        $user=\App\User::withTrashed()->findorFail($id);
        return view('users.show',compact('user'));
    }

    public function UpdatePassword(Request $request,$id){
        $user=\App\User::findorFail($id);
        if($request->password!=$request->reppassword){
            return back()->with(['info'=>"Las Contraseñas no son iguales!",'color'=>"bg-red"]);
        }
        try{
            $this->user_repo->updatePassword($user,$request->password);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with(['info'=>$e->getMessage(),'color'=>"bg-red"]);
        }
        DB::commit();
        return back()->with(['info'=>"Contraseña cambiada Correctamente!",'color'=>"bg-green"]);
    }

    public function update(Request $request,$id){
        $user=\App\User::findorFail($id);
        DB::beginTransaction();
        try {
            $this->user_repo->update($user,$request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al editar usuario: '.$e->getMessage());
            return back()->with(['info'=>"Error: ".$e->getCode(),'color'=>"bg-red", $request->flash()]);
        }
       return back()->with(['info'=>"Usuario Editado Correctamente!",'color'=>"bg-green"]);
    }

    public function destroy($id){
        $user=\App\User::findorFail($id);
        $user->delete();
        return redirect()->route('users.index')->with(['info'=>"Usuario Eliminado Correctamente!",'color'=>"bg-green"]);
    }

    public function reactive($id){
        $user=\App\User::withTrashed()->findorFail($id);
        $user->restore();
        return back()->with(['info'=>"Usuario Activado Correctamente!",'color'=>"bg-green"]);
    }

    public function getDisponibles($proyecto_id, $region_id,$fecha){
        $roles=\App\Role::where('name','permisos.tecnico')->first();
        $roles2=\App\Role::where('name','ver.grafico')->first();



        $dato=DB::table('users')->selectRaw('DISTINCT users.id')
        ->leftJoin('users_actividades','users.id','=','users_actividades.user_id')
        ->join('roles_users', function ($join) use ($roles,$fecha,$roles2) {
            $join->on('users.id', '=', 'roles_users.user_id')
                 ->whereIn('roles_users.role_id',[$roles->id,$roles2->id])->where('fecha',$fecha);
        })
        ->where('proyecto_id',$proyecto_id)
        ->whereNull('users.deleted_at')
        ->get()->pluck('id');

    $users=\App\User::select('users.rut','users.name','users.apaterno','users.amaterno','comunas.nombre as comuna')
        ->rightjoin('comunas', function ($join) use ($region_id) {
            $join->on('comunas.id', '=', 'users.comuna_id')
                    ->where('comunas.region_id',$region_id);
        })
        ->rightjoin('roles_users', function ($join) use ($roles,$roles2) {
            $join->on('users.id', '=', 'roles_users.user_id')
                    ->whereIn('roles_users.role_id',[$roles->id, $roles2->id]);
        })
        ->where('proyecto_id',$proyecto_id)
        ->whereNotIn('users.id',$dato)
        ->get();
        return $users;
    }

    public function getByArea($proyecto_id, $fecha, $area_id=null){
        if($area_id!=null){
            $area=\App\Area::findorFail($area_id);
            if(!$area)
               return response()->json(['status' => 'error','message' => 'El Area no Existe!'], 400 );
        }
        $proyecto=\App\Proyecto::findorFail($proyecto_id);
        if(!$proyecto)
            return response()->json(['status' => 'error','message' => 'El Proyecto no Existe!'], 400 );

        $dato=DB::table('users')->selectRaw('DISTINCT users.id')
        ->leftJoin('users_actividades','users.id','=','users_actividades.user_id')
        ->where('proyecto_id',$proyecto->id)
        ->whereNull('users.deleted_at')
        ->where('fecha',str_replace("-", "", $fecha))
        ->get()->pluck('id');


        if($area_id){
            $users=\App\User::select('users.rut','users.name','users.apaterno','users.amaterno','areas.nombre as area')
            ->rightjoin('areas','areas.id','=','users.area_id')
            ->where('areas.id',$area->id);
        }else{
            $users=\App\User::select('users.rut','users.name','users.apaterno','users.amaterno')->whereNull('users.area_id');
        }


        $users=$users->whereNotIn('users.id',$dato)->where('proyecto_id',$proyecto_id)->get();

        return $users;

    }

    public function validaRut($rut){
        $rut=str_replace(".", "", $rut);
        $user=\App\User::where('rut',$rut)->first();
        if($user){
            return response()->json(['status' => 'error','message' => 'El Rut ya se encuentra Creado!'], 400 );
        }
        return 0;
    }

    public function perfil(){
        $user=auth()->user();
        $comunas=\App\Comuna::all();
        $bancos=\App\Banco::all();
        $tipocuentas=\App\TipoCuenta::all();
        $herramientas=\App\Herramienta::all();
        return view('users.perfil',compact('user','comunas','bancos','tipocuentas','herramientas'));
    }

    public function SelfUpdate(UpdateSelfRequest $request){
        //dd($request->all());
        $user=\App\User::findorFail(auth()->user()->id);
        DB::beginTransaction();
        try {
            $this->user_repo->self_update($user,$request->validated());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al editar usuario: '.$e->getMessage());
            return back()->with(['info'=>"Error: ".$e->getCode(),'color'=>"bg-red", $request->flash()]);
        }
       return back()->with(['info'=>"Usuario Editado Correctamente!",'color'=>"bg-green"]);
    }


    public function UpdateSelfPassword(Request $request){
        $user=\App\User::findorFail(auth()->user()->id);
        if(!Hash::check($request->old_password,$user->password))
            return back()->with(['info'=>"La contraseña anterior no coincide!",'color'=>"bg-red"]);

        if($request->password!=$request->reppassword)
            return back()->with(['info'=>"Las Contraseñas no son iguales!",'color'=>"bg-red"]);

        try{
            $this->user_repo->updatePassword($user,$request->password);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with(['info'=>$e->getMessage(),'color'=>"bg-red"]);
        }
        DB::commit();
        return back()->with(['info'=>"Contraseña cambiada Correctamente!",'color'=>"bg-green"]);
    }


}
