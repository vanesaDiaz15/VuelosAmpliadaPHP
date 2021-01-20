<?php

require 'conexion.php';

$method = $_SERVER['REQUEST_METHOD'];

$recibido = file_get_contents('php://input');

$primerCaracter = substr($recibido, 0, 1);
// echo $primerCaracter;

if ($primerCaracter == '{') { // Me han enviado los datos con un json
    $_DATA = json_decode($recibido, true);
    // echo "Nos han enviado un json";
} else {
    // echo "Nos han enviado un formulario 'normal'";
    parse_str($recibido, $_DATA);
}

if (datosCorrectos($method, $_DATA)) {
    switch ($method) {
        case 'GET':
            require 'apiGET.php';
            $arrayMensaje = verDatos($_DATA, $coleccion);
            break;
        case 'POST':
            require 'apiPOST.php';
            $arrayMensaje = insertarUNO($_DATA, $coleccion);
            break;
        case 'PUT':
            require 'apiPUT.php';
            $arrayMensaje = modificarUNO($_DATA, $coleccion);
            break;
        case 'DELETE':
            require 'apiDELETE.php';
            $arrayMensaje = borrarUNO($_DATA, $coleccion);
            break;
        default:
            $arrayMensaje = array(
                "estado" => "KO",
                "mensaje" => "Método $method no implementado"
            );
            break;
    }


} else {  // Los datos que nos han enviado no son correctos o están incompletos
    $arrayMensaje = array(
        "estado" => "KO",
        "mensaje" => "No se puede completar la acción con los datos recibidos"
    );
}



function datosCorrectos($metodo, $_DATA)
{
    $todoOK = true;

    switch ($metodo) {
        case 'GET':

            break;
        case 'POST':
            if (count($_DATA) <> 6) {
                $todoOK = false;
            } else {
                if (!isset($_DATA['codigo']) || !isset($_DATA['dni']) ||
                    !isset($_DATA['dniPagador']) || !isset($_DATA['nombre']) ||
                    !isset($_DATA['apellido']) || !isset($_DATA['tarjeta'])) {
                    $todoOK = false;
                }
            }
            break;
        case 'PUT':
            if (count($_DATA) <> 6) {
                $todoOK = false;
            } else {
                if (!isset($_DATA['codigo']) || !isset($_DATA['dni']) ||
                    !isset($_DATA['codigoVenta']) || !isset($_DATA['dniPagador']) ||
                    !isset($_DATA['nombre']) || !isset($_DATA['apellido'])) {
                    $todoOK = false;
                }
            }
            break;
        case 'DELETE':
            if (count($_DATA) <> 3) {
                $todoOK = false;
            } else {
                if (!isset($_DATA['codigo']) || !isset($_DATA['dni']) || !isset($_DATA['codigoVenta'])) {
                    $todoOK = false;
                }
            }
            break;
        default:
            $todoOK = false;
            break;
    }
    return $todoOK;
}

?>