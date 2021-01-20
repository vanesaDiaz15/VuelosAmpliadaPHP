<?php
function verDatos($_DATA, $coleccion){
    $arrayMensaje = array(); //Asociativo
    $arrayVuelos = array(); //Numérico
    $contador = 0;

    if(isset($_GET["origen"]) || isset($_GET["destino"]) || isset($_GET["fecha"])){
        $query = array();
        $origen = "";
        $fecha = "";
        $destino = "";
        if (isset($_GET["origen"])){
            $origen = $_GET["origen"];
            $origen = strtoupper($origen);
            $query = array('origen'=>$origen);
        }

        if (isset($_GET["fecha"])){
            $fecha = $_GET["fecha"];
            $query = array('fecha'=>$fecha);
        }

        if (isset($_GET["destino"])){
            $destino = $_GET["destino"];
            $destino = strtoupper($destino);
            $query = array('destino'=>$destino);
        }

        $resultado = $coleccion->find($query);
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

        $arrayMensaje = array(
            "estado" => true,
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
                "estado" => true,
                "encontrados"=> $contador,
                "vuelos" => $arrayVuelos
            );
        }
    }

    $mensajeJSON = json_encode($arrayMensaje, JSON_PRETTY_PRINT);
    echo $mensajeJSON;
}

?>