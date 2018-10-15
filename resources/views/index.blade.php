@extends('layouts.master')
@section('title', 'Quien quiere ser millonario')
@section('controller', 'ng-controller="indexController"')
@section('content')

<div class="container-fluid bg-light p-3">
	<h1 class="ml-3">QUIEN QUIERE SER MILLONARIO</h1>
</div>
<section class="container pt-2">
	<p class="font-weight-bold">
		Ingrese año y grado para empezar a jugar:
	</p>
	<form>
		<div class="form-row">
			<div class="col-sm-2">
				<select class="form-control custom-select" ng-model="input.anio"
						ng-options="anio.anio for anio in anios track by anio.id">
					<option value="" hidden>Año</option>
				</select>
				<span class="text-danger">@{{errors.anio[0]}}</span>
			</div>
			<div class="col-sm-2">
				<select class="form-control custom-select" ng-model="input.grado"
						ng-options="grado.grado for grado in grados track by grado.id">
					<option value="" hidden>Grado</option>
				</select>
				<span class="text-danger">@{{errors.grado[0]}}</span>
			</div>
			<div class="col-sm-2 align-self-center">
				<button class="btn btn-light btn-block" ng-click="juego()">Ir al juego</button>
			</div>
		</div>
	</form>
</section>

@stop