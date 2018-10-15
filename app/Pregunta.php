<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    public $timestamps = false;
    protected $table = 'preguntas';
    protected $fillable = ['pregunta'];

    public function respuestas() {
    	return $this->hasMany('App\Respuesta')->orderBy('respuesta_correcta', 'desc');
    }
}
