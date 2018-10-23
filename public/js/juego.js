var app = angular.module('app', []);
function cerrar(e) {
	e.path[1].classList.remove('open');
	$('#mask').removeClass('open');
}

// function toFormData(data) {
// 	var formData = new FormData();
// 	formData.append('asd', 'aaa');

// 	console.log(formData);
// }

app.controller('adminController', ['$scope', '$http', '$timeout',  function($scope, $http, $timeout) {

	$scope.filtro = new Object();
	function getPreguntas() {
		$http.get($scope.raiz+'/admin/preguntas').then(function(response) {
			$scope.preguntas = response.data;
		});
	}

	$timeout(function() {
		$http.get($scope.raiz+'/admin/datos-fecha').then(function(response) {
			$scope.anios = response.data.anios;
			$scope.grados = response.data.grados;
		});

		getPreguntas();
	}, 10);

	$scope.filtrar = function() {
		if($scope.filtro.anio == null) $scope.filtro.anio = undefined;
		if($scope.filtro.grado == null) $scope.filtro.grado = undefined;
	}

	$scope.abrirCrearPreguntaModal = function() {
		$scope.preguntaInput = new Object();
		$scope.preguntaInput.respuestas = [];
		$('#crearPreguntaModal').modal('show');
	}

	$scope.guardarPregunta = function() {
		var data = new FormData();
		angular.forEach($scope.preguntaInput, function(value, key) {
			if(value) {
				if(key != 'file_pregunta') data.append(key, JSON.stringify(value));
				else data.append(key, value);
			}
		});
		var config = {
			headers: {
				'Content-Type': undefined
			}
		};
		$http.post($scope.raiz+'/admin/guardar-pregunta', data, config).then(function(response) {
			$scope.errors = null;
			if(response.data.icon != 'error') {
				$('#crearPreguntaModal').modal('hide');
				swal(response.data).then((value) => {
					window.location.href = $scope.raiz+'/admin';
				});
			}
			else {
				$scope.errors = response.data;
			}	
		}, function(response) {
			$scope.errors = response.data;
		});
	}

	$scope.eliminarPregunta = function(pregunta) {
		swal({
			title: 'Advertencia',
			text: '¿Seguro que deseas eliminar esta pregunta?',
			icon: 'warning',
			buttons: true,
			dangerMode: true
		}).then((value) => {
			if(value) {
				$http.delete($scope.raiz+'/admin/eliminar-pregunta/'+pregunta.pregunta.id).then(function(response) {
					swal(response.data).then((value) => {
						window.location.href = $scope.raiz+'/admin';
					});
				});
			}
		});
	}

	$scope.editarPregunta = function(pregunta) {
		$scope.preguntaInput = pregunta.pregunta;
		$scope.preguntaInput.file_pregunta.name = pregunta.file_pregunta;
		$scope.preguntaInput.anio = pregunta.anio;
		$scope.preguntaInput.grado = pregunta.grado;
		$('#crearPreguntaModal').modal('show');
	}

	$scope.elegirArchivo = function() {
		$("#archivo").click();
	}

	//event change
	$scope.mostrarArchivo = function() {
		$timeout(function() {
			var archivo = $("#archivo")[0].files[0];
			if(archivo) {
				$scope.preguntaInput.file_pregunta = archivo;
				$("#pre").attr('placeholder', 'Comentario de pregunta');
			}
		}, 20);
	}

	//event click
	$scope.cancelarArchivo = function() {
		$timeout(function() {
			$("#pre").attr('placeholder', 'Pregunta');
			$scope.preguntaInput.file_pregunta = null;
		}, 10);
	}
}]);

app.controller('indexController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {
	
	$timeout(function() {
		$http.get($scope.raiz+'/juego/datos-juego').then(function(response) {
			$scope.anios = response.data.anios;
			$scope.grados = response.data.grados;
		});
	}, 10);

	$scope.juego = function() {
		$http.post($scope.raiz+'/juego/validar-datos', $scope.input).then(function(response) {
			window.location.href = $scope.raiz+response.data;
		}, function(response) {
			$scope.errors = response.data;
		});
	}
}]);

app.controller('juegoController', ['$scope','$http', '$timeout', function($scope, $http, $timeout) {
	var tablaPremios = $('#premio li');
	var preguntasEscogidas = [];
	var premioActual = 1;
	
	$scope.puntaje = 0;
	$scope.preguntasAcertadas = 0;
	$scope.preguntas = [];
	$scope.reveal = false;

	function actualizarPremio() {
		tablaPremios.removeClass('up');
		tablaPremios[15-premioActual].classList.add('up');
	}

	actualizarPremio();

	function elegirPregunta() {
		var len = $scope.preguntas.length;
		var rand = Math.round(Math.random()*(len-1));
		var p = $scope.preguntas[rand];
		var c = 1;

		while(preguntasEscogidas.indexOf(p) != -1) {
			p = $scope.preguntas[(rand+c)%len];
			c++;
		}

		preguntasEscogidas.push(p);
		$scope.preguntaActual = p;
		$scope.respuestasActuales = [];
		for (var i = 0; i < 4; i++) {
			rand = Math.round(Math.random()*3);
			while($scope.respuestasActuales.indexOf($scope.preguntaActual.respuestas[rand]) != -1) {
				rand = (rand+1)%4;
			}

			$scope.respuestasActuales.push($scope.preguntaActual.respuestas[rand]);
		}
	}

	$timeout(function() {
		$http.get($scope.raiz+'/juego/preguntas/'+$scope.anio+'/'+$scope.grado).then(function(response) {
			angular.forEach(response.data, function(value, key) {
				$scope.preguntas.push(value.pregunta);
			});

			if($scope.preguntas.length < 15) $('#dialog_error').addClass('open');
			else {
				$('#dialog_inicio').addClass('open');
				elegirPregunta();
			}
		});
	}, 10);

	$scope.seleccionarRespuesta = function(respuesta, event) {
		if(!$scope.reveal) {
			$('#answers li').removeClass('selected');
			event.path[2].classList.add('selected');
			preguntasEscogidas[preguntasEscogidas.length-1].respuestaSeleccionada = respuesta;
		}
	};

	$scope.revelar = function() {
		$scope.reveal = true;
		angular.forEach($scope.preguntaActual.respuestas, function(value, key) {
			if(value.respuesta_correcta)
				preguntasEscogidas[preguntasEscogidas.length-1].respuestaCorrecta = value;
		});

		$timeout(function() {
			$('#mask').addClass('open');
			if(premioActual < 15) {
				if($('li.light')[0] == $('li.selected')[0]) {
					$scope.puntaje += parseInt($('#premio li.up')[0].getAttribute('data-value'));
					$scope.preguntasAcertadas++;
					$('#dialog_correct').addClass('open');
				}
				else {
					$('#dialog_loose').addClass('open');
				}
			}
			else {
				$('#dialog_winner').addClass('open');
				$scope.preguntasEscogidas = preguntasEscogidas;
			}	
		}, 500);
	}

	$scope.proximaPregunta = function() {
		premioActual++;

		if(premioActual <= 15) {
			$('#mask').removeClass('open');
			$('.window').removeClass('open');

			$('#answers li').removeClass('selected');

			$scope.reveal = false;
			
			elegirPregunta();
			actualizarPremio();
		}
	}

	function restarSegundos() {
		if($scope.segundos > 0) {
			$timeout(function() {
				$scope.segundos--;
				restarSegundos();
			}, 1000);
		}
		else {
			$("#dialog_comd_llamada").removeClass('open');
			$("#mask").removeClass('open');
		}
	}

	$scope.llamada = function() {
		if($("#comd_llamada a.used").length == 0) {
			$("#comd_llamada a").addClass('used');
			$("#dialog_comd_llamada").addClass('open');
			$("#mask").addClass('open');
			$scope.segundos = 30;
			restarSegundos();
		}
	}

	$scope.publico = function() {
		if($("#comd_publico a.used").length == 0) {
			$("#comd_publico a").addClass('used');
			$("#dialog_comd_publico").addClass('open');
			$("#mask").addClass('open');
		}
	}

	$scope.retirada = function() {
		if($("#retirarse a.used").length == 0) {
			$("#retirarse a").addClass('used');
			$("#dialog_retirarse").addClass('open');
			$("#mask").addClass('open');
			$scope.preguntasEscogidas = preguntasEscogidas;
		}
	}

	$scope.cincuenta = function() {
		if($("#comd_cincuenta a.used").length == 0) {
			$("#comd_cincuenta a").addClass('used');
			for (var i = 0; i < 2; i++) {
				var rand = Math.round(Math.random()*3);
				while($scope.respuestasActuales[rand] == null || $scope.respuestasActuales[rand].respuesta_correcta) {
					rand = (rand+1)%4;
				}
				$scope.respuestasActuales[rand] = null;
			}
		}
	}
}]);