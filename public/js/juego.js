var app = angular.module('app', []);
function cerrar(e) {
	e.path[1].classList.remove('open');
	$('#mask').removeClass('open');
}

app.controller('juegoController', ['$scope','$http', '$timeout', function($scope, $http, $timeout) {
	var tablaPremios = $('#premio li');
	var preguntasEscogidas = [];
	var premioActual = 1;

	$scope.puntaje = 0;
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
		//aaa
		$scope.preguntaActual = $scope.preguntas[0];
		$scope.respuestas = [];
		for (var i = 0; i < 4; i++) {
			rand = Math.round(Math.random()*3);
			while($scope.respuestas.indexOf($scope.preguntaActual.respuestas[rand]) != -1) {
				rand = (rand+1)%4;
			}

			$scope.respuestas.push($scope.preguntaActual.respuestas[rand]);
		}
	}

	$timeout(function() {
		$http.get($scope.raiz+'/juego/preguntas/'+$scope.anio+'/'+$scope.grado).then(function(response) {
			angular.forEach(response.data, function(value, key) {
				$scope.preguntas.push(value.pregunta);
			});

			// if($scope.preguntas.length < 15) $('#dialog_error').addClass('open');
			// else {
				$('#dialog_inicio').addClass('open');
				elegirPregunta();
			// }
		});
	}, 10);

	$scope.seleccionarRespuesta = function(event) {
		if(!$scope.reveal) {
			$('#answers li').removeClass('selected');
			event.path[2].classList.add('selected');
		}
	};

	$scope.revelar = function() {
		$scope.reveal = true;
		$timeout(function() {
			$('#mask').addClass('open');
			if($('li.light')[0] == $('li.selected')[0]) {
				$scope.puntaje += parseInt($('#premio li.up')[0].getAttribute('data-value'));
				$('#dialog_correct').addClass('open');
			}
			else {
				$('#dialog_loose').addClass('open');
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
}]);