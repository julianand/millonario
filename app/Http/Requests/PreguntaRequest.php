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
            'anio'=>'required_without:anioNew',
            'anioNew'=>'required_without:anio|numeric|unique:anios,anio|min:2000',
            'grado'=>'required',
            'respuestas'=>'required|array|min:4'
        ];
    }

    public function messages() {
        return [
            'respuestas.required'=>'Completa todos los campos',
            'respuestas.min'=>'Completa todos los campos',
            'pregunta.required'=>'Requerido',
            'anio.required_without'=>'Requerido',
            'anioNew.required_without'=>' ',
            'anioNew.numeric'=>'El año debe ser un numero',
            'anioNew.unique'=>'El año ya esta registrado',
            'anioNew.new'=>'El año debe ser mayor o igual a 2000',
            'grado.required'=>'Requerido',
        ];
    }
}
