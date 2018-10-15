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
        $p = Pregunta::create($request->all());
        $respuestas = $request->respuestas;
        foreach ($respuestas as $key => $value) {
            if($key == 0) $value['respuesta_correcta'] = 1;
            else $value['respuesta_correcta'] = 0;

            $value['pregunta_id'] = $p->id;
            Respuesta::create($value);
        }

        $rp['anio_id'] = $request->anio['id'];
        $rp['grado_id'] = $request->grado['id'];
        $rp['pregunta_id'] = $p->id;
        $rp = RelacionPregunta::create($rp);

        return $rp->with('pregunta.respuestas')
                    ->with('anio')
                    ->with('grado')
                    ->where('pregunta_id', $rp->pregunta_id)
                    ->first();
    }

    public function deleteEliminarPregunta($id) {
        Pregunta::destroy($id);

        return ['title'=>'Exito',
                'text'=>'La pregunta ha sido eliminada con exito',
                'icon'=>'success'];
    }
}
