<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\RelacionPregunta;
use App\Anio;
use App\Grado;

class JuegoController extends Controller
{
	public function getPreguntas($anio, $grado) {
		$rp = RelacionPregunta::
		 	  where('anio_id',Anio::where('anio',$anio)->first()->id)
		 	->where('grado_id',Grado::where('grado',$grado)->first()->id)
		 	->with('pregunta.respuestas')
		 	->get();

		return $rp;
    }
}
