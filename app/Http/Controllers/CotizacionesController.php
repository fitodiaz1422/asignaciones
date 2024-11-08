<?php

namespace App\Http\Controllers;

use App\Cotizacion;
use App\Http\Requests\CotizacionCreateRequest;
use App\Http\Requests\CotizacionEditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use DateTime;
use Carbon\Carbon;


class CotizacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        if(auth()->user()->usuario_cliente == "SI")
        {
            $cotizaciones = collect();
            $adjudicadas = collect();
            $facturadas = collect();
            $mtc = 0;
            $mta = 0;
            $mtf = 0;
            $users_clientes =\App\Users_Clientes::where('user_id',auth()->user()->id)->get();

            foreach($users_clientes as $uc)
            {
            $pcotizaciones=\App\Cotizacion::where('estado_respuesta',0)->where('cliente_id',$uc->clientes_id)->with(['cliente','jp'])->get();
            $cotizaciones->push($pcotizaciones);



            $monto_cotizaciones = \App\Cotizacion::where('estado_respuesta',0)->where('cliente_id',$uc->clientes_id)->get();
            
            foreach($monto_cotizaciones as $mc)
            {
                $mtc += $mc->monto;
    
            }
    
          
    
            $padjudicadas=\App\Cotizacion::where('estado_respuesta',1)->where('estado_factura',0)->where('cliente_id',$uc->clientes_id)->with(['cliente','jp'])->get();
            $adjudicadas->push($padjudicadas);
    
            $monto_Adjudicadas = \App\Cotizacion::where('estado_respuesta',1)->where('estado_factura',0)->where('cliente_id',$uc->clientes_id)->get();
            
            foreach($monto_Adjudicadas as $ma)
            {
                $mta += $ma->monto;
    
            }
    
    
    
            $pfacturadas=\App\Cotizacion::where('estado_respuesta',1)->where('estado_factura',1)->where('cliente_id',$uc->clientes_id)->with(['cliente','jp'])->get();

            $facturadas->push($pfacturadas);
    
    
            $monto_Facturadas = \App\Cotizacion::where('estado_respuesta',1)->where('estado_factura',1)->where('cliente_id',$uc->clientes_id)->get();
           
            foreach($monto_Facturadas as $mf)
            {
                $mtf += $mf->monto;
    
            }

        }
        $cotizaciones = $cotizaciones->collapse();
        $adjudicadas = $adjudicadas->collapse();
        $facturadas = $facturadas->collapse();
        

        //dd($cotizaciones);

        }
        else{
        $cotizaciones=\App\Cotizacion::where('estado_respuesta',0)->with(['cliente','jp'])->get();

        $monto_cotizaciones = \App\Cotizacion::where('estado_respuesta',0)->get();
        $mtc = 0;
        foreach($monto_cotizaciones as $mc)
        {
            $mtc += $mc->monto;

        }

      

        $adjudicadas=\App\Cotizacion::where('estado_respuesta',1)->where('estado_factura',0)->with(['cliente','jp'])->get();

        $monto_Adjudicadas = \App\Cotizacion::where('estado_respuesta',1)->where('estado_factura',0)->get();
        $mta = 0;
        foreach($monto_Adjudicadas as $ma)
        {
            $mta += $ma->monto;

        }



        $facturadas=\App\Cotizacion::where('estado_respuesta',1)->where('estado_factura',1)->with(['cliente','jp'])->get();


        $monto_Facturadas = \App\Cotizacion::where('estado_respuesta',1)->where('estado_factura',1)->get();
        $mtf = 0;
        foreach($monto_Facturadas as $mf)
        {
            $mtf += $mf->monto;

        }

    }
        //dd($cotizaciones);
        $users=\App\User::all();
        $clientes=\App\Cliente::all();
        return view('cotizaciones.index',compact('cotizaciones','clientes','users','adjudicadas','facturadas','mtc','mta','mtf'));
    }

    public function store(CotizacionCreateRequest $request){
        DB::beginTransaction();
        try {
            $cotizacion=new \App\Cotizacion;
            $cotizacion->cliente_id=$request->cliente_id;
            $cotizacion->nombre_solicitante=$request->nombre_solicitante;
            $cotizacion->fecha=date('Y-m-d');
            $cotizacion->fecha_entrega=$request->fecha_entrega;
            $cotizacion->proyecto=$request->proyecto;
            $cotizacion->tipo_actividad=$request->tipo_actividad;
            $cotizacion->monto=$request->monto;
            $cotizacion->estado_respuesta=$request->estado_respuesta;
            $cotizacion->estado_proyecto=$request->estado_proyecto;
            $cotizacion->tipo_facturacion=$request->tipo_facturacion;
            $cotizacion->pagado=0;
            //$cotizacion->jp_id=$request->usuario_id;
            if($request->pdf_cotizacion){
                $ext=$request->pdf_cotizacion->extension();
                $name=uniqid(date('h-i-s')."_");
                $ruta=$request->pdf_cotizacion->storeAs('public/archivos', $name.".".$ext);
                $cotizacion->pdf_cotizacion=str_replace('public','storage',$ruta);
            }
            $cotizacion->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Creo la Cotizacion",'color'=>"bg-green"]);
    }

    public function update(CotizacionEditRequest $request){
        $cotizacion =\App\Cotizacion::findorfail($request->cotizacion_id);
        DB::beginTransaction();
        try {
            $cotizacion->estado=$request->estado;
            $cotizacion->cliente_id=$request->cliente_id;
            $cotizacion->nombre_solicitante=$request->nombre_solicitante;
            $cotizacion->fecha_entrega=$request->fecha_entrega;
            $cotizacion->proyecto=$request->proyecto;
            $cotizacion->tipo_actividad=$request->tipo_actividad;
            $cotizacion->monto=$request->edit_monto;
            $cotizacion->estado_respuesta=$request->estado_respuesta;
            $cotizacion->estado_proyecto=$request->estado_proyecto;
            $cotizacion->tipo_facturacion=$request->tipo_facturacion;
            $cotizacion->pagado=$request->pagado;
            $cotizacion->jp_id=$request->usuario_id;
            $cotizacion->estado_factura= $request->estado_factura;
            $cotizacion->numero_po = $request->npo2;
            $cotizacion->numero_factura = $request->nfactura2;

            if($request->pdf_cotizacion){
                $ext=$request->pdf_cotizacion->extension();
                $name=uniqid(date('h-i-s')."_");
                $ruta=$request->pdf_cotizacion->storeAs('public/archivos', $name.".".$ext);
                $cotizacion->pdf_cotizacion=str_replace('public','storage',$ruta);
            }
            if($request->pdf_po){
                //$ext=$request->pdf_cotizacion->extension();
                //$name=uniqid(date('h-i-s')."_");
                $file=$request->pdf_po;
                $path=$file->store('public/cotizacion');

        $cotizacion->pdf_po=str_replace('public','storage',$path);
       

                
            }
            if($request->pdf_factura){
                $file=$request->pdf_factura;
                $path=$file->store('public/cotizacion');

        $cotizacion->pdf_factura=str_replace('public','storage',$path);
                
            }
            if($request->pdf_archivo1){
                $file=$request->pdf_archivo1;
                $path=$file->store('public/cotizacion');

        $cotizacion->pdf_1=str_replace('public','storage',$path);
                
            }
            if($request->pdf_archivo2){
                $file=$request->pdf_archivo2;
                $path=$file->store('public/cotizacion');

        $cotizacion->pdf_2=str_replace('public','storage',$path);
                
            }
            $cotizacion->save();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error: ".$e->getMessage());
            return back()->with(['info'=>"Error : ".$e->getCode(),'color'=>"bg-red",'status'=>'Error']);
        }
        DB::commit();
        return back()->with(['info'=>"Se Edito la Cotizacion",'color'=>"bg-green"]);
    }

    public function AjaxShow($id){
        $cotizacion =\App\Cotizacion::find($id);
        if(!$cotizacion)
            return response()->json(['status' => 'error','message' => 'No se ha Encontrado la Cotizacion!'], 400 );
        return response()->json($cotizacion);
    }

    public function importCotiPDF(Request $request){
        $date = Carbon::now();
        $file=$request->file('archivo');
        $cotizaciones=\App\Cotizacion::findOrFail($request->solicitud);

        $path=$file->store('public/cotizacion');

       /* if($request->tipo=="original"){
             $solicitud->guia_original=$path;
        }*/
        if($request->tipo=="factura"){
            $cotizaciones->pdf_factura=str_replace('public','storage',$path);
        }
        if($request->tipo=="archivo1"){
            $cotizaciones->pdf_1=str_replace('public','storage',$path);
        }
        if($request->tipo=="archivo2"){
            $cotizaciones->pdf_2=str_replace('public','storage',$path);
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

        $cotizaciones->save();

        /*return redirect()->route('carta_amonestacion.index')->with(['info'=>"Se subio Carta de Amonestacion de forma correcta",'color'=>"bg-green"]);*/



       return response()->json([
            "status" => "OK"
        ]);
       // $files1 = "../storage/app/".$path;
    }

    public function subirPO(Request $request)
    {
        $file=$request->pdf_po;
        $cotizaciones=\App\Cotizacion::findOrFail($request->cotiId);
        $path=$file->store('public/cotizacion');

        $cotizaciones->pdf_po=str_replace('public','storage',$path);
        $cotizaciones->numero_po = $request->npo;

        $cotizaciones->save();

        return redirect()->route('cotizaciones.index')->with(['info'=>"Se subio PO de forma correcta",'color'=>"bg-green"]);


    }

    public function subirFactura(Request $request)
    {
        $file=$request->pdf_factura2;
        $cotizaciones=\App\Cotizacion::findOrFail($request->cotiId2);
        $path=$file->store('public/cotizacion');

        $cotizaciones->pdf_factura=str_replace('public','storage',$path);
        $cotizaciones->numero_factura = $request->nfactura;

        $cotizaciones->save();

        return redirect()->route('cotizaciones.index')->with(['info'=>"Se subio Factura de forma correcta",'color'=>"bg-green"]);


    }

}
