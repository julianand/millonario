<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function() {
	return view('index', ['asd'=>env('APP_ENV')]);
});

Route::controller('juego','JuegoController');
route::controller('admin','AdminController');

Route::get('/{anio}/{grado}', function ($anio, $grado) {
    return view('juego.index', ['anio'=>$anio, 'grado'=>$grado]);
});