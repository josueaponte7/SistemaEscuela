<?php

require_once '../modelo/TipoEnfermedad.php';
$obj = new TipoEnfermedad();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['enfermedad'])) {
        $datos['enfermedad'] = $_POST['enfermedad'];
    }
    if (isset($_POST['id_enfermedad'])) {
        $datos['id_enfermedad'] = $_POST['id_enfermedad'];
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