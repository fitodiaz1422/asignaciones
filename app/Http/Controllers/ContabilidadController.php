<?php

namespace App\Http\Controllers;

use App\Http\Excel\ContabilidadExporta;
use Illuminate\Http\Request;

class ContabilidadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function exporta(){
        return view('contabilidad.exporta');
    }

    public function exportaPost(Request $request){
        $tipos = [
            'bonos' => $request->has('tipos.bonos'),
            'depositos' => $request->has('tipos.depositos')
        ];
        // Crear la instancia de exportación y descargar el archivo
        $exporta = new ContabilidadExporta($request->fecha, $tipos);

        return $exporta->download();
    }
}
