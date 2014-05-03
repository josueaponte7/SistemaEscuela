<?php

require_once '../modelo/Estado.php';

$obj = new Estado();
if (!isset($_POST['accion'])) {
    
} else { 
    if(isset($_POST['nombre_estado'])){
        $datos['nombre_estado'] = $_POST['nombre_estado'];
    }
    if(isset($_POST['id_estado'])){
        $datos['id_estado'] = $_POST['id_estado'];
    }
    
    switch ($_POST['accion']) {
        case 'Guardar':
            $resultado = $obj->add($datos);
            if ($resultado) {
                echo 1;
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
