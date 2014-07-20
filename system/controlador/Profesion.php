<?php

require_once '../modelo/Profesion.php';
$obj = new Profesion();


if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['nombre_profesion'])) {
        $datos['nombre_profesion'] = $_POST['nombre_profesion'];
    }
    if(isset($_POST['id_profesion'])){
        $datos['id_profesion'] = $_POST['id_profesion'];
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
