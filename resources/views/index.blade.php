<!DOCTYPE HTML>
<html ng-app="app">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="{{asset('css/QQM.css')}}" type="text/css" />

	<title>QUIEN QUIERE SER MillONARIO</title>
</head>

<body ng-controller="juegoController" ng-init="anio='{{$anio}}'; grado='{{$grado}}'; raiz='{{Request::root()}}'">

	<div class="game-wrapper">

	    <div id="game">
	    
	        <div id="header">
	        
	            <div class="logo"></div><!-- /.logo -->
	            
	            <div class="comodines">
	                            
	                <ul>
	                    <li id="comd_cincuenta"><a href="#" ng-click="cincuenta()"></a></li>    
	                    <li id="comd_publico"><a href="#" ng-click="publico()"></a></li>    
	                    <li id="comd_llamada"><a href="#" ng-click="llamada()"></a></li>
	                    <li id="retirarse"><a href="#" ng-click="retirada()"></a></li>      
	                </ul>
	                
	            </div><!-- /.comodines -->
	            
	        </div><!-- /#header -->
	        <div style="color: white; margin-top: 10px;">
	        	<span style="font-weight: 600;">Usuario: </span> @{{nombre}}
	        </div>
	        
	        <div class="playground">
	        
	            <p id="question">
	            <span id="textoPregunta">@{{preguntaActual.pregunta}}</span>
	            </p><!-- /.question -->
	            
	            <ul id="answers">
	        
	                <li ng-class="{light: (reveal && respuestasActuales[0].respuesta_correcta)}">
	                    <a ng-click="seleccionarRespuesta(respuestasActuales[0], $event)" href="#">
	                    <span class="bullet">A:</span> 
	                    <span id="A" class="answer-text">@{{respuestasActuales[0].respuesta}}</span>
	                    </a>
	              </li>
	                
	                <li ng-class="{light: (reveal && respuestasActuales[1].respuesta_correcta)}">
	                    <a ng-click="seleccionarRespuesta(respuestasActuales[1], $event)" href="#">
	                    <span class="bullet">B:</span> 
	                    <span id="B" class="answer-text">@{{respuestasActuales[1].respuesta}}</span>
	                    </a>
	              </li>
	                
	                <li ng-class="{light: (reveal && respuestasActuales[2].respuesta_correcta)}">
	                    <a ng-click="seleccionarRespuesta(respuestasActuales[2], $event)" href="#">
	                    <span class="bullet">C:</span> 
	                    <span id="C" class="answer-text">@{{respuestasActuales[2].respuesta}}</span>
	                    </a>
	              </li>
	                
	                <li ng-class="{light: (reveal && respuestasActuales[3].respuesta_correcta)}">
	                    <a ng-click="seleccionarRespuesta(respuestasActuales[3], $event)" href="#">
	                    <span class="bullet">D:</span> 
	                    <span id="D" class="answer-text">@{{respuestasActuales[3].respuesta}}</span>
	                    </a>
	                </li>   
	            
	            </ul><!-- /.answers -->
	            
	            <div id="action" ng-click="revelar()">
	                <input id="Revelar" type="button" value="Revelar respuesta">
	                </input>
	            </div>
	        
	        </div><!-- /#playground -->
	                
	    </div><!-- /#game -->
	    
	    <div id="aside">
	        <ul id="premio">
	            <li data-value="300000000"><em>300.000.000</em></li>
	            <li data-value="100000000">100.000.000</li>
	            <li data-value="50000000">50.000.000</li>
	            <li data-value="20000000">20.000.000</li>
	            <li data-value="15000000">15.000.000</li>
	            <li data-value="10000000"><em>10.000.000</em></li>
	            <li data-value="7000000">7.000.000</li>
	            <li data-value="5000000">5.000.000</li>
	            <li data-value="3000000">3.000.000</li>
	            <li data-value="2000000">2.000.000</li>
	            <li data-value="1000000"><em>1.000.000</em></li>
	            <li data-value="5000000">500.000</li>
	            <li data-value="300000">300.000</li>
	            <li data-value="200000">200.000</li>
	            <li data-value="100000">100.000</li>
	        </ul>
	        
	        
	        
	    </div><!-- /#aside -->

	</div><!-- /.game-wrapper -->

	<!-- Error -->
	<div id="dialog_error" class="window">
	    <h2>Error</h2>    
	    <p>No hay suficientes preguntas.</p>
	    <p>Hay @{{preguntas.length}} y se necesitan al menos 15.</p>
	</div>
	
	<!-- Inicio -->
	<div id="dialog_inicio" class="window">
	    <h2>Bienvenido</h2>    
	    <p>Ingrese su nombre</p>
	    <input type="text" ng-model="nombre">
	    <a href="#"class="close" onclick="cerrar(event)">Cerrar ventana</a>
	</div>

	<!-- Llamada -->
	<div id="dialog_comd_llamada" class="window">
	    <h2>Comodín Bíblico</h2>    
	    <p>Dispone de <strong>@{{segundos}}</strong> segundos para buscar en Internet.</p>
	</div>
	
	<!-- Publico -->
	<div id="dialog_comd_publico" class="window">
	    <h2>Comodín del Público</h2>
	    <p>Pida a los participantes que levanten la mano votando una de las cuatro posibles respuestas a la pregunta.</p>
	    <a href="#"class="close" onclick="cerrar(event)">Cerrar ventana</a>
	</div>
	
	<!-- Ganador -->
	<div id="dialog_winner" class="window">
	    <h2>Felicidades</h2>
	    <p>El jugador ha contestado correctamente todas las <strong>15</strong> pregutnas y ha obtenido los <strong>300.000.000</strong> pesos, ha ganado el juego:<br><br>
	    </p>    
	    <a href="#"class="close">Cerrar ventana</a>
	</div>
	
	<!-- Incorrecta -->
	<div id="dialog_loose" class="window">
	    <h2>Respuesta Incorrecta</h2>
	    <p>Contestaste incorrectamente!<br><br></p>    
	    <p><strong>Puntaje total: <span class="total_answers">@{{puntaje}}</span></strong></p>
	    <p><strong>Preguntas acertadas: <span class="total_answers">@{{preguntasAcertadas}}</span></strong></p>
	    <a style="cursor: pointer;" class="close" ng-click="proximaPregunta()">Próxima pregunta</a>
	</div>

	<!-- Correcta -->
	<div id="dialog_correct" class="window">
	    <h2>Respuesta Correcta</h2>
	    <p>Contestaste correctamente!<br><br></p>    
	    <p><strong>Puntaje total: <span class="total_answers">@{{puntaje}}</span></strong></p>
	    <p><strong>Preguntas acertadas: <span class="total_answers">@{{preguntasAcertadas}}</span></strong></p>
	    <a style="cursor: pointer;" class="close" ng-click="proximaPregunta()">Próxima pregunta</a>
	</div>
	
	<!-- Retirada -->
	<div id="dialog_retirarse" class="window">
	    <h2>Retirada</h2>
	    <p>El jugador ha decidido retirarse del juego con el siguiente puntaje:</p>
	    <p><strong>Puntaje: <span class="total_answers">@{{puntaje}}</span></strong></p>
	    <p><strong>Preguntas acertadas: <span class="total_answers">@{{preguntasAcertadas}}</span></strong></p>
	    <div ng-if="preguntasEscogidas.length > 1">
	    	<p>PREGUNTAS: </p>
		    <table>
				<thead>
					<th>Pregunta</th>
					<th>Respuesta seleccionada</th>
					<th>Respuesta correcta</th>
				</thead>
				<tbody ng-repeat="pregunta in preguntasEscogidas" ng-if="preguntaActual != pregunta">
					<td style="text-align: center;">
						@{{pregunta.pregunta}}
					</td>
					<td style="text-align: center;">
						a
					</td>
					<td style="text-align: center;">
						b
					</td>
				</tbody>
			</table>
	    </div>
	</div>

	<!-- Mask to cover the whole screen -->
	<div id="mask" class="open"></div>

	<script type="text/javascript" language="JavaScript" src="{{asset('js/jquery-1.4.4.min.js')}}"></script>
	<script type="text/javascript" language="JavaScript" src="{{asset('js/pubsub.js')}}"></script>
	<script type="text/javascript" language="JavaScript" src="{{asset('js/json2.js')}}"></script>
	<script type="text/javascript" language="JavaScript" src="{{asset('js/jquery.store.js')}}"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.4/angular.min.js"></script>
	<script type="text/javascript" src="{{asset('js/juego.js')}}"></script>
	<!-- <script type="text/javascript" language="JavaScript" src="{{asset('js/qqss.js')}}"></script> -->
	</script>

</body>
</html>
