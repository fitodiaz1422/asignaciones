<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RendicionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $depositos=\App\Deposito::where('deposito_depositado','>',0)->where('user_id',auth()->user()->id)->where('aprobado',0)->get();
        return view('rendiciones.index',compact('depositos'));
    }

    public function store(Request $request){
        $deposito=\App\Deposito::where('actividad_id',$request->actividad_id)->first();
        $deposito->rendido=$request->monto;
        $deposito->estado="RENDIDO";
        $deposito->save();
        $file=$request->file('archivo');
        if($file){
            $archivos=new \App\Deposito_Archivo;
            $extension = $file->getClientOriginalExtension();
            $name = time() . str_pad(random_int(1, 1000),4,"0",STR_PAD_LEFT) . "." . $extension;
            $path=$file->storeAs('public/archivos',$name);
            $archivos->deposito_id=$deposito->id;
            $archivos->archivo='storage/archivos/'.$name;
            $archivos->tipo="RENDICION";
            $archivos->save();
        }

        DB::commit();
        return back()->with(['info'=>"Se Guardo Correctamente la Rendicion!",'color'=>"bg-green"]);

    }
}
