<?php

require_once '../modelo/DatosGenerales.php';
print_r($_POST);
exit;
$obj = new DatosGenerales();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['servicio'])) {
        $datos['servicio'] = $_POST['servicio'];
    }    
     if (isset($_POST['cod_telefono'])) {
        $datos['cod_telefono'] = $_POST['cod_telefono'];
    }
    if (isset($_POST['telefono'])) {
        $datos['telefono'] = $_POST['telefono'];
    }   
    if (isset($_POST['tiposervicio'])) {
        $datos['tiposervicio'] = $_POST['tiposervicio'];
    }
    if (isset($_POST['parroquia'])) {
        $datos['parroquia'] = $_POST['parroquia'];
    }
 
     switch ($accion) {
        case 'Guardar':
            $resultado = $obj->add($datos);
            if ($resultado) {
                echo 1;
            } else {
                echo 0;
            }
            break;
        case 'Modificar':
            $resultado = $obj->update($datos);
            if ($resultado) {
                echo 1;
            }
            break;

        case 'Eliminar':
            $resultado = $obj->delete($datos);
            if ($resultado) {
                echo 1;
            }
            break;
    }
}