<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $depositos=\App\Deposito::where('rendido','>',0)->where('rendido_real',null)->get();
        $pendientes=\App\Deposito::where('rendido_real','>',0)->where('aprobado',0)->get();
        return view('valida.index',compact('depositos','pendientes'));
    }

    public function store(Request $request){
        $deposito=\App\Deposito::where('actividad_id',$request->actividad_id)->first();
        //dd($request->input());
        if($deposito->rendido_real==null){
            $deposito->rendido_real=$request->monto;
        }
        $deposito->aprobado=($request->aprobado=='on') ? 1: 0;
        $deposito->estado='VALIDADO';
        $deposito->notas.=$request->nota.'\n';
        $deposito->save();
        return back()->with(['info'=>"Se valido la Rendicion!",'color'=>"bg-green"]);         
    }

}
