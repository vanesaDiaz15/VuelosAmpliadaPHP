<?php


function insertarUNO($_DATA, $coleccion)
{
    $permitted_chars = 'ABCEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    $arrayMensaje = array(); //Asociativo
    $vendido = array(
        "asiento" => asignarAsiento($_DATA['codigo'], $coleccion),
        "dni" => $_DATA['dni'],
        "apellido" => $_DATA['apellido'],
        "nombre" => $_DATA['nombre'],
        "dniPagador" => $_DATA['dniPagador'],
        "tarjeta" => $_DATA['tarjeta'],
        "codigoVenta" => generate_string($permitted_chars, 9)
    );
    try {
        $filterOption = array("codigo" => $_DATA['codigo']);
        $datos = array("vendidos" => $vendido);

        $coleccion->updateMany(
            $filterOption,
            ['$push' => $datos, '$inc' => array("plazas_disponibles" => -1)]
        );


        $vuelo = $coleccion->find(array("codigo" => $_DATA['codigo']));
        $fecha = "";
        $destino = "";
        $origen = "";
        $hora = "";
        $precio = "";

        foreach ($vuelo as $entry) {
            $origen = $entry['origen'];
            $destino = $entry['destino'];
            $fecha = $entry['fecha'];
            $hora = $entry['hora'];
            $precio = $entry['precio'];
        }


        $arrayMensaje = array(
            "estado" => true,
            "codigo" => $_DATA['codigo'],
            "origen" => $origen,
            "destino" => $destino,
            "fecha" => $fecha,
            "hora" => $hora,
            "asiento" => 3,
            "dni" => $_DATA['dni'],
            "apellido" => $_DATA['apellido'],
            "nombre" => $_DATA['nombre'],
            "dniPagador" => $_DATA['dniPagador'],
            "tarjeta" => $_DATA['tarjeta'],
            "codigoVenta" => "GHJ7766GG",
            "precio" => $precio,
        );

    } catch (Exception $e) {
        $arrayMensaje = array(
            "estado" => false,
            "mensaje" => "No se ha podido realizar la compra por $e"
        );
    }

    $mensajeJSON = json_encode($arrayMensaje, JSON_PRETTY_PRINT);
    echo $mensajeJSON;
}


function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

function asignarAsiento($codigo,$coleccion){
    $resultado = $coleccion->find(array("codigo" => $codigo));

    $ptotales = "";
    foreach ($resultado as $entry) {
        $ptotales = $entry['plazas_totales'];
    }
    $resultado = $coleccion->find(array("codigo" => $codigo));
    $random = mt_rand(1, $ptotales);
    foreach ($resultado as $entry) {
        if (isset($entry['vendidos'])){
            $a =  $entry['vendidos'];
            $asiento = $a[0]['asiento'];
            if ($asiento == $random) {
                $random = mt_rand(1, $ptotales);
            }
        }else{

        }

    }
    return $random;
}
?>