<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    public $timestamps = false;
    protected $table = 'grados';
    protected $fillable = ['grado'];

    public $casts = [
    	'grado'=>'integer'
    ];
}
