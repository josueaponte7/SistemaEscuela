<?php

require_once '../modelo/Actividad.php';
$obj = new Actividad();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['actividad'])) {
        $datos['actividad'] = $_POST['actividad'];
    }
    if (isset($_POST['descripcion'])) {
        $datos['descripcion'] = $_POST['descripcion'];
    }
     if (isset($_POST['id_actividad'])) {
        $datos['id_actividad'] = $_POST['id_actividad'];
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