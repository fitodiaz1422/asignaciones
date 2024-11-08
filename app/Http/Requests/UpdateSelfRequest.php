<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSelfRequest extends FormRequest
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
            "name" => "required|max:255",
            "apaterno" => "required|max:255",
            "amaterno" => "required|max:255",
            "fechaNacimiento" => "required|max:10|date_format:Y-m-d",
            "sexo" => "required|max:1",
            "estado_civil" => "required|max:50",
            "nacionalidad" => "required|max:100",
            "comuna_id" => "required|exists:comunas,id",
            "direccion" => "required|max:200",
            "fono" => "required|max:30",
            "emailPersonal" => "required|max:255|email",
            "banco_id" => "required|exists:bancos,id",
            "tipo_cuenta_id" => "required|exists:tipo_cuentas,id",
            "nro_cuenta" => "required|max:100",
            "contacto_nombre" => "required|max:255",
            "contacto_fono" => "required|max:30",
            "titulo_profesional" => "required|max:100",
            "institucion_estudio" => "required|max:100",
            "imagen"=>"nullable|file|mimes:png,jpg|max:2000"
        ];
    }
}
