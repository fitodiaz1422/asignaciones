<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetAtrasoRequest extends FormRequest
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
            'user_id'=>'required|exists:users,id',
            'fechaatraso'=>'required|date_format:Y-m-d',
            'nota'=>'nullable|max:255',
            'hora_inicio'=>'required|date_format:H:i',
            'hora_llegada'=>'required|date_format:H:i',
        ];
    }
}
