<?php

require_once '../modelo/ProgramaSocial.php';
$obj = new ProgramaSocial();


if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['nombre_programa'])) {
        $datos['nombre_programa'] = $_POST['nombre_programa'];
    }
    if(isset($_POST['id_programa'])){
        $datos['id_programa'] = $_POST['id_programa'];
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
