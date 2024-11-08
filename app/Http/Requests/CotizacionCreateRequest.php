<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cliente_id'=>'required|exists:clientes,id',
            'nombre_solicitante'=>'required|string|max:200',
            'fecha_entrega'=>'required|date_format:Y-m-d',
            'proyecto'=>'nullable|string|max:200',
            'tipo_actividad'=>'nullable|string|max:50',
            'monto'=>'required|numeric|min:0',
            'estado_respuesta'=>'required|numeric|min:0',
            'estado_proyecto'=>'nullable|numeric|min:0',
            'tipo_facturacion'=>'nullable|string|max:100',
            
            'usuario_id'=>'nullable|exists:users,id',
            'pdf_cotizacion'=>'nullable|file|mimes:pdf'
        ];
    }
}
