<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PreguntaRequest;
use App\Http\Controllers\Controller;

use App\Anio;
use App\Grado;
use App\Pregunta;
use App\Respuesta;
use App\RelacionPregunta;

class AdminController extends Controller
{
    public function getIndex() {
        return view('admin.index');
    }

    public function getDatosFecha() {
        $res['anios'] = Anio::all();
        $res['grados'] = Grado::all();

        return $res;
    }

    public function getPreguntas() {
        $rp = RelacionPregunta::with('pregunta.respuestas')
                              ->with('anio')
                              ->with('grado')
                              ->get();

        return $rp;
    }

    public function postGuardarPregunta(PreguntaRequest $request) {
        //obteniendo datos
        foreach ($request->all() as $key => $value) {
            $res[$key] = json_decode($value);
        }

        //validando
        if(count($res['respuestas']) != 4) {
            return ['icon'=>'error', 'respuestas'=>['Completa todos los campos']];
        }

        foreach ($res['respuestas'] as $key => $value) {
            if(!isset($value->respuesta)) {
                return ['icon'=>'error', 'respuestas'=>['Completa todos los campos']];
            }
        }

        //algoritmo
        if(isset($res['id'])) {
            $pregunta = Pregunta::find($res['id']);
            foreach ($res['respuestas'] as $key => $value) {
                $respuestas[$key] = Respuesta::find($value->id);
            }

            RelacionPregunta::where('pregunta_id', $res['id'])->delete();

            $alert = [
                'title'=>'exito',
                'text'=>'Pregunta actualizada con exito',
                'icon'=>'success'
            ];
        }
        else {
            $pregunta = new Pregunta();
            foreach ($res['respuestas'] as $key => $value) {
                $respuestas[$key] = new Respuesta();
            }

            $alert = [
                'title'=>'exito',
                'text'=>'Pregunta creada con exito',
                'icon'=>'success'
            ];
        }
        if(!$res['anio']) {
            $anio = Anio::create(['anio' => $res['anioNew']]);
        }
        else $anio = $res['anio'];

        $pregunta->fill($res);
        if($file = $request->file('file_pregunta')) return $file->getClientOriginalName();
        $pregunta->save();

        foreach ($res['respuestas'] as $key => $value) {
            $respuestas[$key]->respuesta = $value->respuesta;
            $respuestas[$key]->pregunta_id = $pregunta->id;
            if($key == 0) $respuestas[$key]->respuesta_correcta = 1;
            else $respuestas[$key]->respuesta_correcta = 0;

            $respuestas[$key]->save();
        }

        RelacionPregunta::create([
            'anio_id'=>$anio->id,
            'grado_id'=>$res['grado']->id,
            'pregunta_id'=>$pregunta->id
        ]);

        return $alert;
    }

    public function deleteEliminarPregunta($id) {
        Pregunta::destroy($id);

        return ['title'=>'Exito',
                'text'=>'La pregunta ha sido eliminada con exito',
                'icon'=>'success'];
    }
}
