@extends('layouts.master')
@section('title', 'Quien quiere ser millonario')
@section('controller', 'ng-controller="indexController"')
@section('content')

<div class="container mt-2">
	<form class="form-inline">
		<div class="form-group mr-3">
			<label class="mr-2">Año</label>
			<select class="form-control"></select>
		</div>
		<div class="form-group mr-3">
			<label class="mr-2">Grado</label>
			<select class="form-control"></select>
		</div>
	</form>
</div>
	

@stop