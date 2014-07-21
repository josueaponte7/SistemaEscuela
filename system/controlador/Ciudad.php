<?php

require_once '../modelo/Ciudad.php';

$obj = new Ciudad();

$nombre_ciudad = $_POST['nombre_ciudad'];

$datos = array('nombre_ciudad'=>"$nombre_ciudad");

$resultado = $obj->add($datos);
if ($resultado) {
    echo 1;
}



