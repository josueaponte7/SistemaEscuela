<?php

require_once '../modelo/Menu.php';

$obj = new Menu();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['nombre_menu'])) {
        $datos['nombre_menu'] = $_POST['nombre_menu'];
    }
    if (isset($_POST['estatus'])) {
         $datos['id_estatus'] = $_POST['estatus'];
         $id_estado = $_POST['estatus'];
    }else if(isset($_POST['id_estatus'])){
        $datos['id_estatus'] = $_POST['id_estatus'];
        $id_estado = $_POST['id_estatus'];
    }
    
    if (isset($_POST['id_menu'])) {
         $datos['id_menu']= $_POST['id_menu'];
    }
    

    switch ($accion) {
        case 'Guardar':
            $resultado = $obj->add($datos);
        
            if ($resultado == 1 ) {
                echo 1;
            } else if ($resultado == 13) {
                echo 13;
            } else {
                echo 15;
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


        case 'BuscarDatos':
            $id_menu   = $datos['id_menu'];        

            $opciones['sql']    = "SELECT  nombre_menu,  activo FROM menu WHERE id_menu = $id_menu";
            $resultado             = $obj->getMenu($opciones);
            echo $resultado[0]['nombre_menu'] . ';' .
                 $resultado[0]['activo'];

            break;
    }
}