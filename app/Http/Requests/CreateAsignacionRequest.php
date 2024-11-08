<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAsignacionRequest extends FormRequest
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
            'proyecto_id'=>'required|exists:proyectos,id',
            'comuna_id'=>'required|exists:comunas,id',
            'fechadatos'=>'required|date_format:Y-m-d',
            'actividad'=>'required|max:100',
            'direccion'=>'required|max:255',
            'usuario'=>'required|max:255',
            'detalle'=>'required|max:255',
            'nota'=>'nullable|max:255',
            'deposito'=>'required|numeric|min:0|max:10000000',
            'user_id'=>'required|exists:users,id',
            'horas'=>'required|array',
            'horas.*'=>'required|numeric|min:7|max:19',
            'fecha_para_deposito'=>'required|date_format:d/m/Y H:i'
        ];
    }
}
