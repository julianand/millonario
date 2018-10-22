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

    public function postGuardarPregunt(Request $request) {
        foreach ($request->all() as $key => $value) {
            if($key != 'file_pregunta') $res[$key] = json_decode($value);
            else $res[$key] = $value;
        }
        return $request->all();
    }

    public function postGuardarPregunta(PreguntaRequest $request) {
        return $request->all();
        // return $request->file('file_pregunta')->getClientOriginalName();
        if($request->id) {
            if (!$request->anio) {
                $anio = Anio::create(['anio'=>$request->anioNew]);
            }
            else {
                $anio = Anio::find($request->anio['id']);
                $anio->fill($request->anio);
                $anio->save();
            }

            RelacionPregunta::where('pregunta_id',$request->id)->delete();
            $p = Pregunta::find($request->id);
            $p->fill($request->all());
            $p->save();

            foreach ($request->respuestas as $key => $value) {
                $r = Respuesta::find($value['id']);
                $r->fill($value);
                $r->save();
            }

            $rp['anio_id'] = $anio['id'];
            $rp['grado_id'] = $request->grado['id'];
            $rp['pregunta_id'] = $p->id;
            RelacionPregunta::create($rp);

            $alert = ['title'=>'Exito',
                      'text'=>'La pregunta ha sido actualizada con exito',
                      'icon'=>'success'];

            return $alert;
        }
        else {
            if (!$request->anio) {
                $anio = Anio::create(['anio'=>$request->anioNew]);
            }
            else $anio = $request->anio;

            $p = Pregunta::create($request->all());
            $respuestas = $request->respuestas;
            foreach ($respuestas as $key => $value) {
                if($key == 0) $value['respuesta_correcta'] = 1;
                else $value['respuesta_correcta'] = 0;

                $value['pregunta_id'] = $p->id;
                Respuesta::create($value);
            }

            $rp['anio_id'] = $anio['id'];
            $rp['grado_id'] = $request->grado['id'];
            $rp['pregunta_id'] = $p->id;
            RelacionPregunta::create($rp);

            $alert = ['title'=>'Exito','text'=>'La pregunta ha sido creada con exito','icon'=>'success'];

            return $alert;
        } 
    }

    public function deleteEliminarPregunta($id) {
        Pregunta::destroy($id);

        return ['title'=>'Exito',
                'text'=>'La pregunta ha sido eliminada con exito',
                'icon'=>'success'];
    }
}
