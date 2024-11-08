<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CargosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $cargos=\App\Cargo::all();
        return view('cargos.index',compact('cargos'));
    }

    public function create(){
        $roles=\App\Role::orderby('global_group')->get();
        $notifications=\App\Notifyrole::orderby('global_group')->get();
        return view('cargos.create',compact('roles','notifications'));
    }

    public function store(Request $request){
        $cargo=new \App\Cargo;
        $cargo->nombre=$request->nombre;
        $cargo->save();
        $cargo->roles()->attach($request->roles);
        $cargo->notifyroles()->attach($request->notifications);
        return  redirect()->route('cargos.index')->with(['info'=>'Cargo Creado Correctamente','color'=>'bg-green','status'=>'OK']);
    }

    public function edit($id){
        $cargo=\App\Cargo::findorfail($id);
        $roles=\App\Role::orderby('global_group')->get();
        $notifications=\App\Notifyrole::orderby('global_group')->get();
        return view('cargos.edit',compact('roles','cargo','notifications'));
    }


    public function update($id,Request $request){
        $cargo=\App\Cargo::findorfail($id);
        $cargo->nombre=$request->nombre;
        $cargo->save();
        $cargo->roles()->sync($request->roles);
        $cargo->notifyroles()->sync($request->notifications);
        $users=\App\User::where('cargo_id',$id)->get();
        foreach ($users as $user) {
           $user->roles()->sync($request->roles);
           $user->notifyroles()->sync($request->notifications);
        }
        return  redirect()->route('cargos.index')->with(['info'=>'Cargo Modificado Correctamente','color'=>'bg-green','status'=>'OK']);
    }

    public function RolesGroup($id){
        $grupo= \App\Cargo::find($id);
        return response()->json(['roles'=>$grupo->roles,'notifyroles'=>$grupo->notifyroles] );

    }
}
