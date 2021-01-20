<?php
function borrarUNO($_DATA, $coleccion)
{
    $dni = $_DATA['dni'];
    $codvuelo = $_DATA['codigo'];
    $codventa = $_DATA['codigoVenta'];
    $result = $coleccion->update(
        array('codigo' => $codvuelo),
        array(
            '$pull' => array('vendidos' => array('codigoVenta' => $codventa, 'dni' => $dni))
        ), array()
    );
}
?>