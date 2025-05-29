<?php

namespace App\Http\Controllers;

use App\Motivos;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DepositosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $date=$request->fecha ? $request->fecha : date('Y-m');
        $depositos=\App\Deposito::where('deposito_depositado',null)->where('deposito_solicitado','>',0)->orderBy('fecha_para_deposito')
        ->with(['usuario','anticipo'])->orderBy('fecha_para_deposito')->whereRaw('MONTH(fecha_para_deposito) = '.intval(substr($date,5)).' and YEAR(fecha_para_deposito) =  '.substr($date,0,4) )->get();
        $depositados=\App\Deposito::where('deposito_depositado','>',0)->where('deposito_solicitado','>',0)->whereRaw('month(fecha_para_deposito) = month(now())')->whereRaw('year(fecha_para_deposito) = year(now())')->orderBy('fecha_para_deposito')
        ->with(['usuario','anticipo'])->orderBy('user_id')->get();
        $max=$depositos->max('cant');
        $motivos=Motivos::where('tipo','ELIMINAR')->get();
    	return view('depositos.index',compact('depositos','max','depositados','date','motivos'));
    }

    public function store(Request $request){
        $deposito=\App\Deposito::where('actividad_id',$request->actividad_id)->first();
        $deposito->deposito_depositado=$request->monto;
        $deposito->estado="DESPOSITADO";
        $deposito->save();
        $file=$request->file('archivo');
        if($file){
            $archivos=new \App\Deposito_Archivo;
            $extension = $file->getClientOriginalExtension();
            $name = time() . str_pad(random_int(1, 1000),4,"0",STR_PAD_LEFT) . "." . $extension;
            $path=$file->storeAs('public/archivos',$name);
            $archivos->deposito_id=$deposito->id;
            $archivos->archivo='storage/archivos/'.$name;
            $archivos->tipo="DEPOSITO";
            $archivos->save();
        }

        DB::commit();
        return back()->with(['info'=>"Se Guardo Correctamente el Deposito!",'color'=>"bg-green"]);

    }

    public function destroy(Request $request){
        $deposito=\App\Deposito::findorfail($request->delete_id);
        $motivo=Motivos::findorfail($request->motivo);

        try{
            DB::beginTransaction();
            $deposito->delete();
            $path=null;
            if($request->file('archivo_respaldo')){
                $file=$request->file('archivo_respaldo');
                $extension = $file->getClientOriginalExtension();
                $name = time() . str_pad(random_int(1, 1000),4,"0",STR_PAD_LEFT) . "." . $extension;
                $path=$file->storeAs('public/archivos',$name);
            }
            $deposito->motivo_eliminacion_id=$motivo->id;
            $deposito->user_eliminacion_id=auth()->user()->id;
            $deposito->adjunto_eliminacion=$path;
            $deposito->save();

            if($deposito->anticipo){
                $anticipo=$deposito->anticipo;
                $anticipo->delete();
                $anticipo->motivo_eliminacion_id=$motivo->id;
                $anticipo->user_eliminacion_id=auth()->user()->id;
                $anticipo->adjunto_eliminacion=$path;
                $anticipo->save();
            }
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with(['info'=>"Error al eliminar el deposito: ".$e->getMessage(),'color'=>"bg-red"]);
        }

        DB::commit();
        return back()->with(['info'=>"Se elimino correctamente el deposito!",'color'=>"bg-green"]);
    }

}
