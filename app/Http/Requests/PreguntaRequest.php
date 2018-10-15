<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PreguntaRequest extends Request
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
            'pregunta'=>'required',
            'anio'=>'required',
            'grado'=>'required',
            'respuestas'=>'required|array|min:4'
        ];
    }

    public function messages() {
        return [
            'respuestas.required'=>'Completa todos los campos',
            'respuestas.min'=>'Completa todos los campos',
            'pregunta.required'=>'Requerido',
            'anio.required'=>'Requerido',
            'grado.required'=>'Requerido',
        ];
    }
}
