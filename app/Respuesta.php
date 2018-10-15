<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    public $timestamps = false;
    protected $table = 'respuestas';
    protected $fillable = ['respuesta', 'respuesta_correcta', 'pregunta_id'];
    protected $casts = [
    	'respuesta_correcta'=>'integer'
    ];

    public function pregunta() {
    	return $this->belongsTo('App\Pregunta');
    }
}
