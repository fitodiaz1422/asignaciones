<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MaestrosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $empresas=\App\Empresa::all();
        $clientes=\App\Cliente::all();
        $proyectos=\App\Proyecto::all();
        $tipo_asistencias=\App\TipoAsistencia::all();
        $skills=\App\Skill::all();
        $afps=\App\Afp::all();
        $previsiones=\App\Prevision::all();
        $bancos=\App\Banco::all();
        $herramientas=\App\Herramienta::all();
        $costo = DB::table('centro_costos')->get();
        $motivos = DB::table('motivos')->get();
        return view('maestros.index',compact('afps','bancos','clientes','empresas','previsiones','proyectos','skills','tipo_asistencias','herramientas','costo','motivos'));
    }

    public function storeEmpresa(Request $request){
        $file=$request->file('imagen');
        $rutaimg=null;
        if($file){
            $ext=$file->extension();
            $name = time() . str_pad(random_int(1, 1000),4,"0",STR_PAD_LEFT) . "." . $ext;
            $file->storeAs('public/avatars', $name);
            $rutaimg='public/avatars/'.$name;
        }
        DB::beginTransaction();
		try {
            $empresa= new \App\Empresa;
            $empresa->nombre=$request->nombre;
            $empresa->logo=$rutaimg;
            $empresa->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo la Empresa",'color'=>"bg-green"]);
    }

    public function storeCliente(Request $request){
        DB::beginTransaction();
		try {
            $cliente= new \App\Cliente;
            $cliente->razon_social=$request->razon_social;
            $cliente->nombre=$request->nombre;
            $cliente->rut=$request->rut;
            $cliente->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo el Cliente",'color'=>"bg-green"]);
    }

    public function storeProyecto(Request $request){
        DB::beginTransaction();
		try {
            $proyecto= new \App\Proyecto;
            $proyecto->nombre=$request->nombre;
            $proyecto->cliente_id=$request->cliente_id;
            $proyecto->estado="ACTIVO";
            $proyecto->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo el Proyecto",'color'=>"bg-green"]);
    }

    public function storeAsistencia(Request $request){
        DB::beginTransaction();
		try {
            $tipo=\App\TipoAsistencia::max('tipo');
            $asistencia= new \App\TipoAsistencia;
            $asistencia->tipo=$tipo+1;
            $asistencia->nombre=$request->nombre;
            $asistencia->color=substr($request->color,-6);
            $asistencia->estado="ACTIVO";
            $asistencia->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo el Tipo de Asistencia",'color'=>"bg-green"]);
    }

    public function storeSkill(Request $request){
        DB::beginTransaction();
		try {
            $skill= new \App\Skill;
            $skill->nombre=$request->nombre;
            $skill->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo la Skill",'color'=>"bg-green"]);
    }

    public function storeAfp(Request $request){
        DB::beginTransaction();
		try {
            $afp= new \App\Afp;
            $afp->nombre=$request->nombre;
            $afp->valor=$request->valor;
            $afp->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo la Afp",'color'=>"bg-green"]);
    }
    
     public function storeCosto(Request $request){
        DB::beginTransaction();
		try {
            $costo= new \App\Centro_costo;
            $costo->codigo=$request->codigo;
            $costo->descripcion=$request->descripcion;
            $costo->estado=$request->estado;
            $costo->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo el Centro de Costo",'color'=>"bg-green"]);
    }

    public function storeMotivo(Request $request){
        DB::beginTransaction();
		try {
            $motivo= new \App\Motivos;
            $motivo->name=$request->nombre_crear_motivo;
            $motivo->tipo=$request->tipo_crear_motivo;
            $motivo->estado=$request->estado_crear_motivo;
            $motivo->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo el Motivo de Actividad",'color'=>"bg-green"]);
    }

    public function storeBanco(Request $request){
        DB::beginTransaction();
		try {
            $banco= new \App\Banco;
            $banco->nombre=$request->nombre;
            $banco->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo el Banco",'color'=>"bg-green"]);
    }

    public function storePrevision(Request $request){
        DB::beginTransaction();
		try {
            $prevision= new \App\Prevision;
            $prevision->nombre=$request->nombre;
            $prevision->valor=$request->valor;
            $prevision->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo la Prevision de Salud",'color'=>"bg-green"]);
    }

    public function storeHerramienta(Request $request){
        DB::beginTransaction();
		try {
            $herramienta= new \App\Herramienta;
            $herramienta->nombre=$request->nombre;
            $herramienta->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo la Herramienta",'color'=>"bg-green"]);
    }


   public function updateEmpresa(Request $request){
        $empresa= \App\Empresa::findorfail($request->id);
        $file=$request->file('imagen');
        $rutaimg=$empresa->logo;
        if($file){
            $ext=$file->extension();
            $name = time() . str_pad(random_int(1, 1000),4,"0",STR_PAD_LEFT) . "." . $ext;
            $file->storeAs('public/avatars', $name);
            $rutaimg='public/avatars/'.$name;
        }
        DB::beginTransaction();
		try {
            $empresa->nombre=$request->nombre;
            $empresa->logo=$rutaimg;
            $empresa->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito la Empresa",'color'=>"bg-green"]);
    }

    public function updateCliente(Request $request){
        $cliente= \App\Cliente::findorfail($request->id);
        DB::beginTransaction();
		try {
            $cliente->razon_social=$request->razon_social;
            $cliente->nombre=$request->nombre;
            $cliente->rut=$request->rut;
            $cliente->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito el Cliente",'color'=>"bg-green"]);
    }

    public function updateProyecto(Request $request){
        $proyecto=\App\Proyecto::findorfail($request->id);
        DB::beginTransaction();
		try {
            $proyecto->nombre=$request->nombre;
            $proyecto->cliente_id=$request->cliente_id;
            $proyecto->estado=$request->estado;
            $proyecto->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito el Proyecto",'color'=>"bg-green"]);
    }

    public function updateAsistencia(Request $request){
        $asistencia=\App\TipoAsistencia::where('tipo',$request->tipo)->firstorfail();
        DB::beginTransaction();
		try {
            $asistencia->nombre=$request->nombre;
            $asistencia->color=substr($request->color,-6);
            $asistencia->estado=$request->estado;
            $asistencia->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito el Tipo de Asistencia",'color'=>"bg-green"]);
    }

    public function updateSkill(Request $request){
        $skill=\App\Skill::findorfail($request->id);
        DB::beginTransaction();
		try {
            $skill->nombre=$request->nombre;
            $skill->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito la Skill",'color'=>"bg-green"]);
    }

    public function updateAfp(Request $request){
        $afp=\App\Afp::findorfail($request->id);
        DB::beginTransaction();
		try {
            $afp->nombre=$request->nombre;
            $afp->valor=$request->valor;
            $afp->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito la Afp",'color'=>"bg-green"]);
    }
    
     public function updateCosto(Request $request){
          //$costo = DB::table('centro_costo')->where('id','=',$request->id)->get();
        $costo=\App\Centro_costo::find($request->id);
        DB::beginTransaction();
		try {
            $costo->codigo=$request->codigo;
            $costo->descripcion=$request->descripcion;
            $costo->estado=$request->estado;
            $costo->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito el Centro de Costo",'color'=>"bg-green"]);
    }

    public function updateMotivo(Request $request){
        //$costo = DB::table('centro_costo')->where('id','=',$request->id)->get();
      $motivo=\App\Motivos::find($request->motivo_id);
      DB::beginTransaction();
      try {
          $motivo->name=$request->motivo_nombre;
          $motivo->tipo=$request->motivo_tipo;
          $motivo->estado=$request->motivo_estado;
          $motivo->save();
      } catch (\Exception $e) {
          DB::rollback();
          Log::error("Error: ".$e->getMessage());
          return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
      }
      DB::commit();
      return back()->with(['info'=>"Se Edito el Motivo",'color'=>"bg-green"]);
  }

    public function updateBanco(Request $request){
        $banco= \App\Banco::findorfail($request->id);
        DB::beginTransaction();
		try {
            $banco->nombre=$request->nombre;
            $banco->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito el Banco",'color'=>"bg-green"]);
    }

    public function updatePrevision(Request $request){
        $prevision=\App\Prevision::findorfail($request->id);
        DB::beginTransaction();
		try {
            $prevision->nombre=$request->nombre;
            $prevision->valor=$request->valor;
            $prevision->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito la Prevision de Salud",'color'=>"bg-green"]);
    }

    public function updateHerramienta(Request $request){
        $herramienta=\App\Herramienta::findorfail($request->id);
        DB::beginTransaction();
		try {
            $herramienta->nombre=$request->nombre;
            $herramienta->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito la Herramienta",'color'=>"bg-green"]);
    }


}
