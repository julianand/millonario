@extends('layouts.master')
@section('title', 'Modulo Administrador - QQSM')
@section('controller', 'ng-controller="adminController"')
@section('content')

<div class="container-fluid bg-light p-3">
	<h2 class="ml-3">MODULO ADMINISTRADOR - QUIEN QUIERE SER MILLONARIO</h2>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12 my-3">
			<button class="btn btn-light" data-toggle="modal" ng-click="abrirCrearPreguntaModal()">Crear pregunta</button>
		</div>
		<div class="col-sm-12 mb-3">
			<form>
				<div class="form-row">
					<div class="col-sm-2 align-self-center">
						Filtrar por:
					</div>
					<div class="col-sm-3">
						<select class="custom-select form-control" ng-model="filtro.anio"
								ng-options="x.anio for x in anios track by x.id";
								ng-change="filtrar()">
							<option value="">Seleccione año</option>
						</select>
					</div>
					<div class="col-sm-3">
						<select class="custom-select form-control" ng-model="filtro.grado"
								ng-options="grado.grado for grado in grados track by grado.id"
								ng-change="filtrar()">
							<option value="">Seleccione grado</option>
						</select>
					</div>
				</div>
			</form>
		</div>
		<table class="table">
			<thead class="thead-light">
				<th>Pregunta</th>
				<th>Respuesta 1</th>
				<th>Respuesta 2</th>
				<th>Respuesta 3</th>
				<th>Respuesta 4</th>
				<th></th>
			</thead>
			<tbody ng-repeat="pregunta in preguntas | filter:filtro:strict">
				<td>@{{pregunta.pregunta.pregunta}}</td>
				<td ng-repeat="respuesta in pregunta.pregunta.respuestas" ng-class="{'text-success':respuesta.respuesta_correcta,'font-weight-bold':respuesta.respuesta_correcta}">
					@{{respuesta.respuesta}}
				</td>
				<td>
					<button class="btn btn-light">Editar</button>
					<button class="btn btn-link text-danger" ng-click="eliminarPregunta(pregunta)">Eliminar</button>
				</td>
			</tbody>
		</table>
		<br>
		<div>
			<div class="rounded-circle bg-success info-correct"></div>
			<p class="text-success ml-3">Respuesta correcta</p>
		</div>
	</div>
</div>

<div class="modal fade" id="crearPreguntaModal" tabindex="-1" role="dialog" aria-labelledby="crearPreguntaModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-light">
				<h5 class="modal-title" id="crearPreguntaModalLabel">Crear Pregunta</h5>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group row">
						<div class="col-sm-7">
							<input type="text" ng-model="preguntaInput.pregunta" class="form-control" placeholder="Pregunta">
							<label class="text-danger">@{{errors.pregunta[0]}}</label>
						</div>
						<div class="col-sm-3">
							<select ng-model="preguntaInput.anio" class="form-control custom-select" 
									ng-options="x.anio for x in anios track by x.id">
								<option value="">Seleccione el año</option>
							</select>
							<div class="mt-4" style="position: absolute; z-index: 1;" ng-if="!preguntaInput.anio">	
								<label class="mb-1">O especifiquelo:</label>
								<input type="text" ng-model="preguntaInput.anioNew" class="form-control">
								<label class="text-danger text-nowrap">@{{errors.anioNew[0]}}</label>
							</div>
							<label class="text-danger">@{{errors.anio[0]}}</label>
						</div>
						<div class="col-sm-2">
							<select ng-model="preguntaInput.grado" class="form-control custom-select" 
									ng-options="x.grado for x in grados track by x.id">
								<option value="" hidden>Grado</option>
							</select>
							<label class="text-danger">@{{errors.grado[0]}}</label>
						</div>
					</div>
					<div class="form-group">
						<label class="font-weight-bold col-sm-12">Respuestas:</label>
						<label class="text-danger">@{{errors.respuestas[0]}}</label>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<input type="text" ng-model="preguntaInput.respuestas[0].respuesta" class="form-control is-valid text-success" placeholder="Respuesta correcta" required>
						</div>
						<div class="col-sm-6">
							<input type="text" ng-model="preguntaInput.respuestas[1].respuesta" class="form-control" placeholder="Respuesta 2" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<input type="text" ng-model="preguntaInput.respuestas[2].respuesta" class="form-control" placeholder="Respuesta 3" required>
						</div>
						<div class="col-sm-6">
							<input type="text" ng-model="preguntaInput.respuestas[3].respuesta" class="form-control" placeholder="Respuesta 4" required>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link text-dark" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-light" ng-click="guardarPregunta()">Guardar</button>
			</div>
		</div>
	</div>
</div>
@stop