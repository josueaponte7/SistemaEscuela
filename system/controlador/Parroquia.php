<?php

require_once '../modelo/Parroquia.php';

$obj = new Parroquia();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['nombre_parroquia'])) {
        $datos['nombre_parroquia'] = $_POST['nombre_parroquia'];
    }
    if (isset($_POST['municipio'])) {
        $datos['id_municipio'] = $_POST['municipio'];
    }else if(isset ($_POST['id_municipio'])){
        $id_municipio  = $_POST['id_municipio'];
    }

    if (isset($_POST['id_parroquia'])) {
        $datos['id_parroquia'] = $_POST['id_parroquia'];
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
        case 'buscarParr':
            $opciones    = array("campos"=>'id_parroquia,nombre_parroquia',"condicion"=>"id_municipio=$id_municipio");
            $resultado = $obj->getParroquia($opciones);

            for ($i = 0; $i < count($resultado); $i++) {
                $data[] = array(
                    'codigo'      => $resultado[$i]['id_parroquia'],
                    'descripcion' => $resultado[$i]['nombre_parroquia']
                );
            }
            echo json_encode($data);
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