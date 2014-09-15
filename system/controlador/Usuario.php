<?php

require_once '../modelo/Usuario.php';
$obj_usu = new Usuario();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['usuario'])) {
        $datos['usuario'] = $_POST['usuario'];
    }
    if (isset($_POST['nombre'])) {
        $datos['nombre'] = $_POST['nombre'];
    }
    if (isset($_POST['apellido'])) {
        $datos['apellido'] = $_POST['apellido'];
    }
    if (isset($_POST['grupo_usuario'])) {
        $datos['grupo_usuario'] = $_POST['grupo_usuario'];
    }
    if (isset($_POST['contrasena'])) {
        $datos['contrasena'] = $_POST['contrasena'];
    }
    
    if (isset($_POST['estatus'])) {
        $datos['estatus'] = $_POST['estatus'];
    }
    if(isset($_POST['id_usuario'])){
        $datos['id_usuario'] = $_POST['id_usuario'];
    }

    switch ($accion) {
        case 'iniciar':
            $obj_usu->Login($datos);
            break;
        
            case 'Guardar':
            $resultado = $obj_usu->add($datos);
            if ($resultado) {
                echo 1;
            } else {
                echo 0;
            }
            break;
            
            case 'Modificar':
            $resultado = $obj_usu->update($datos);
            if ($resultado) {
                echo 1;
            }
            break;

        case 'Eliminar':
            $resultado = $obj_usu->delete($datos);
            if ($resultado) {
                echo 1;
            }
            break;
            
        case 'BuscarDatos':

            $id_usuario = $datos['id_usuario'];

            $opciones['sql'] = "SELECT activo, id_grupo FROM usuario u WHERE id_usuario = $id_usuario ";
            $resultado       = $obj_usu->getUsuario($opciones);
            echo $resultado[0]['activo'] . ';' .
                 $resultado[0]['id_grupo'] ;
            break;    
            
            
            
            
    }
    
}else{
  $obj_usu->Logout();  
}

