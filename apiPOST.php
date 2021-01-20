<?php
function insertarUNO($_DATA, $coleccion)
{
    $arrayMensaje = array(); //Asociativo
    $vendido = array(
        "dni" => $_DATA['dni'],
        "apellido" => $_DATA['apellido'],
        "nombre" => $_DATA['nombre'],
        "dniPagador" => $_DATA['dniPagador'],
        "tarjeta" => $_DATA['tarjeta']
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

?>