<?php
function modificarUNO($_DATA, $coleccion)
{
    $arrayMensaje = array();
    try {
        $vendido = array(
            "vendidos.$.dni" => $_DATA['dniNuevo'],
            "vendidos.$.apellido" => $_DATA['apellido'],
            "vendidos.$.nombre" => $_DATA['nombre'],
            "vendidos.$.dniPagador" => $_DATA['dniPagador'],
            "vendidos.$.tarjeta" => $_DATA['tarjeta'],
            "vendidos.$.codigoVenta" => $_DATA['codigoVenta']
        );
        $query = array( "codigo" => $_DATA["codigo"], "vendidos.dni" => $_DATA['dni'], "vendidos.codigoVenta" => $_DATA['codigoVenta']);
        $updateResult = $coleccion->updateMany(
            $query,
            ['$set' => $vendido]);

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
            "codigoVenta" =>$_DATA['codigoVenta'],
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