<?php
require 'conexion.php';

$arrayMensaje = array(); //Asociativo
$arrayVuelos = array(); //Numérico
$contador = 0;

$destino = $_GET["destino"];
$origen = $_GET["origen"];
$fecha = $_GET["fecha"];
if(isset($origen) || isset($fecha) || isset($destino)){
    $resultado = $coleccion->find(['origen' => $origen, 'destino' => $destino, 'fecha' => $fecha]);
    foreach ($resultado as $entry){
        $arrayVuelos = array(
            "codigo" => $entry['codigo'],
			"origen" => $entry['origen'],
			"destino" => $entry['destino'],
			"fecha" => $entry['fecha'],
			"hora" => $entry['hora'],
			"plazas_totales" => $entry['plazas_totales'],
			"plazas_disponibles" => $entry['plazas_disponibles']
        );
        $contador++;
    }

    $arrayMensaje = array(
        "estado" => 'OK',
        "encontrados"=> $contador,
	    "busqueda" => array(
            "fecha" => $fecha,
            "origen" => $origen,
		    "destino" => $destino
        ),
        "vuelos" => $arrayVuelos
    );
}else{

    $resultado = $coleccion->find();

    foreach ($resultado as $entry){
         $arrayVuelo = array(
        "codigo" => $entry['codigo'],
        "origen" => $entry['origen'],
        "destino" => $entry['destino'],
        "fecha" => $entry['fecha'],
        "hora" => $entry['hora'],
        "plazas_totales" => $entry['plazas_totales'],
        "plazas_disponibles" => $entry['plazas_disponibles']
        );
         $arrayVuelos[] = $arrayVuelo;
         $contador++;
    }

    if ($contador > 0){
        $arrayMensaje = array(
            "estado" => 'OK',
            "encontrados"=> $contador,
            "vuelos" => $arrayVuelos
        );
    }
    }



$mensajeJSON = json_encode($arrayMensaje, JSON_PRETTY_PRINT);
echo $mensajeJSON
?>