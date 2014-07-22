<?php

require_once '../modelo/TipoServicio.php';
$obj = new TipoServicio();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['tiposervicio'])) {
        $datos['tiposervicio'] = $_POST['tiposervicio'];
    }
    if (isset($_POST['id_tiposervicio'])) {
        $datos['id_tiposervicio'] = $_POST['id_tiposervicio'];
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

