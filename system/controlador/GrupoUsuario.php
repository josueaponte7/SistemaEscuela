<?php

require_once '../modelo/GrupoUsuario.php';
$obj = new GrupoUsuario();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['nombre_grupo'])) {
        $datos['nombre_grupo'] = $_POST['nombre_grupo'];
    }
    if(isset($_POST['id_grupo'])){
        $datos['id_grupo'] = $_POST['id_grupo'];
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