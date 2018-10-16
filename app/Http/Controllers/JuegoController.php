<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ValidarRequest;
use App\Http\Controllers\Controller;

use App\RelacionPregunta;
use App\Anio;
use App\Grado;

class JuegoController extends Controller
{
	public function getDatosJuego() {
		$res['anios'] = Anio::orderBy('anio', 'desc')->get();
		$res['grados'] = Grado::orderBy('grado', 'desc')->get();

		return $res;
	}

	public function postValidarDatos(ValidarRequest $request) {
		$this->validate($request, [
			'anio' => 'required',
			'grado' => 'required'
		]);

		return '/'.$request->anio['anio'].'/'.$request->grado['grado'];
	}

	public function getPreguntas($anio, $grado) {
		$rp = RelacionPregunta::
		 	  where('anio_id',Anio::where('anio',$anio)->first()->id)
		 	->where('grado_id',Grado::where('grado',$grado)->first()->id)
		 	->with('pregunta.respuestas')
		 	->get();

		return $rp;	
    }
}
