<?php

require_once '../modelo/Municipio.php';

$obj = new Municipio();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['nombre_municipio'])) {
        $datos['nombre_municipio'] = $_POST['nombre_municipio'];
    }
    if (isset($_POST['estado'])) {
         $datos['id_estado'] = $_POST['estado'];
         $id_estado = $_POST['estado'];
    }else if(isset($_POST['id_estado'])){
        $datos['id_estado'] = $_POST['id_estado'];
        $id_estado = $_POST['id_estado'];
    }
    
    if (isset($_POST['id_municipio'])) {
         $datos['id_municipio']= $_POST['id_municipio'];
    }
    
    switch ($accion) {
        case 'Guardar':
            $resultado = $obj->add($datos);
            if ($resultado == 13) {
                echo 13;
            } else if ($resultado == 1) {
                echo 1;
            } else {
                echo 15;
            }
            break;
        case 'buscarMun':
            $opciones    = array("campos"=>'id_municipio,nombre_municipio',"condicion"=>"id_estado=$id_estado");
            $resultado = $obj->getMunicipio($opciones);
            $es_array = is_array($resultado) ? TRUE : FALSE;
            if($es_array === TRUE){
            for ($i = 0; $i < count($resultado); $i++) {
                $data[] = array(
                    'codigo'      => $resultado[$i]['id_municipio'],
                    'descripcion' => $resultado[$i]['nombre_municipio']
                );
            }
            echo json_encode($data);
            }  else {
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