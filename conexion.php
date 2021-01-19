<?php
require 'vendor/autoload.php'; // include Composer goodies
$cliente = new MongoDB\Client("mongodb://localhost:27017");
$coleccion = $cliente->vuelos2_0->vuelos;
?>