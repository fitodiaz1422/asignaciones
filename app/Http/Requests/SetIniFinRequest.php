<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetIniFinRequest extends FormRequest
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
            'inifin'=>'required|string|min:5|max:15',
            'actividad_id'=>'required|exists:actividades,id',
            'archivo'=>'nullable|file|mimes:jpeg,jpg,pdf'
        ];
    }
}
