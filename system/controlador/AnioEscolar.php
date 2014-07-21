<?php

require_once '../modelo/AnioEscolar.php';

$obj = new AnioEscolar();
if (!isset($_POST['accion'])) {
    
} else { 
    if(isset($_POST['anio_escolar'])){
        $datos['anio_escolar'] = $_POST['anio_escolar'];
    }
    if(isset($_POST['id_anio'])){
        $datos['id_anio'] = $_POST['id_anio'];
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
