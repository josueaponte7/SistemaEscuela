<?php

require_once '../modelo/SubMenu.php';

$obj = new SubMenu();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['nombre_submenu'])) {
        $datos['nombre_submenu'] = $_POST['nombre_submenu'];
    }
    
    if (isset($_POST['id_submenu'])) {
         $datos['id_submenu']= $_POST['id_submenu'];
    }
    if (isset($_POST['url'])) {
         $datos['url']= $_POST['url'];
    }
    
    if (isset($_POST['menu_comb'])) {
         $datos['id_menu'] = $_POST['menu_comb'];
         $id_menu = $_POST['menu_comb'];
    }else if(isset($_POST['id_menu'])){
        $datos['id_menu'] = $_POST['id_menu'];
        $id_menu = $_POST['id_menu'];
    }   
    
    if (isset($_POST['estatus'])) {
         $datos['id_estatus'] = $_POST['estatus'];
         $id_estado = $_POST['estatus'];
    }else if(isset($_POST['id_estatus'])){
        $datos['id_estatus'] = $_POST['id_estatus'];
        $id_estado = $_POST['id_estatus'];
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
            $id_submenu   = $datos['id_submenu'];        

            $opciones['sql']    = "SELECT id_menu,  nombre_submenu,  url,  activo FROM sub_menu WHERE id_submenu = $id_submenu;";
            $resultado             = $obj->getSubMenu($opciones);
            echo $resultado[0]['id_menu'] . ';' .
                 $resultado[0]['nombre_submenu'] . ';' .
                 $resultado[0]['url'] . ';' .
                 $resultado[0]['activo'];

        break;
        
         case 'buscarSubMenu':
            $opciones    = array("campos"=>'id_submenu AS codigo,nombre_submenu AS descripcion',"condicion"=>"id_menu=$id_menu");
            $resultado = $obj->getSubMenu($opciones);
            $es_array = is_array($resultado) ? TRUE : FALSE;
            if($es_array === TRUE){
            for ($i = 0; $i < count($resultado); $i++) {
                $data[] = array(
                    'codigo'      => $resultado[$i]['codigo'],
                    'descripcion' => $resultado[$i]['descripcion']
                );
            }
            echo json_encode($data);
            }  else {
                echo 0;
            }
            break;
    }
}