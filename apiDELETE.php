<?php
function borrarUNO($_DATA, $coleccion)
{
    $arrayMensaje = array();
    $dni = $_DATA['dni'];
    $codvuelo = $_DATA['codigo'];
    $codventa = $_DATA['codigoVenta'];

    $filterOption = array('codigo' => $codvuelo);
    $datos = array('vendidos' => array('codigoVenta' => $codventa, 'dni' => $dni));

    try {
        $coleccion->updateMany(
            $filterOption,
            ['$pull' => $datos, '$inc' => array("plazas_disponibles" => 1)]

        );

        $arrayMensaje = array(
            "estado" => true,
            "dni" => $_DATA['dni'],
            "codigoVenta" => $_DATA['codigoVenta'],
            "mensaje" => "Eliminado correctamente"
        );
    }catch (Exception $e){
        $arrayMensaje = array(
            "estado" => false,
            "mensaje" => "No se ha podido eliminar el billete por $e"
        );
    }

    $mensajeJSON = json_encode($arrayMensaje, JSON_PRETTY_PRINT);
    echo $mensajeJSON;

}
?>