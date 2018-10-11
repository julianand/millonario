<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelacionPregunta extends Model
{
    public $timestamps = false;
    protected $table = 'relaciones_preguntas';
    protected $fillable = ['anio_id','grado_id','pregunta_id'];

    public function anio() {
    	return $this->belongsTo('App\Anio');
    }

    public function grado() {
    	return $this->belongsTo('App\Grado');
    }

    public function pregunta() {
    	return $this->belongsTo('App\Pregunta');
    }
}
