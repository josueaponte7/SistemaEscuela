<?php

require_once '../modelo/Choferes.php';
$obj = new Choferes();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['nacionalidad'])) {
        $datos['nacionalidad'] = $_POST['nacionalidad'];
    }
    if (isset($_POST['cedula'])) {
        $datos['cedula'] = $_POST['cedula'];
    }
    if (isset($_POST['nombre'])) {
        $datos['nombre'] = $_POST['nombre'];
    }
    if (isset($_POST['apellido'])) {
        $datos['apellido'] = $_POST['apellido'];
    }
    if (isset($_POST['email'])) {
        $datos['email'] = $_POST['email'];
    }
    if (isset($_POST['cod_telefono'])) {
        $datos['cod_telefono'] = $_POST['cod_telefono'];
    }
    if (isset($_POST['telefono'])) {
        $datos['telefono'] = $_POST['telefono'];
    }
    if (isset($_POST['cod_celular'])) {
        $datos['cod_celular'] = $_POST['cod_celular'];
    }
    if (isset($_POST['celular'])) {
        $datos['celular'] = $_POST['celular'];
    }
    if (isset($_POST['placa'])) {
        $datos['placa'] = $_POST['placa'];
    }
    if (isset($_POST['modelo'])) {
        $datos['modelo'] = $_POST['modelo'];
    }
    if (isset($_POST['color'])) {
        $datos['color'] = $_POST['color'];
    }

    switch ($accion) {
        case 'Guardar':
            $resultado = $obj->add($datos);
            if ($resultado == 13) {
                echo 13;
            } else if ($resultado == TRUE) {
                echo 1;
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

            $cedula = $datos['cedula'];

            $opciones['sql'] = "SELECT 
                                    ch.nacionalidad,
                                    ch.nombre,
                                    ch.apellido,
                                    ch.email,
                                    au.placa,
                                    au.modelo,
                                    au.color, 
                                    ch.cod_telefono,
                                    ch.telefono,
                                    ch.cod_celular, 
                                    ch.celular
                                 FROM chofer AS ch 
                                 INNER JOIN automovil AS au ON ch.cedula=au.cedula_chofer
                                 WHERE ch.cedula= $cedula";
            $resultado       = $obj->getChofer($opciones);
            echo $resultado[0]['nacionalidad'] . ';' .
                 $resultado[0]['nombre'] . ';' .
                 $resultado[0]['apellido'] . ';' .
                 $resultado[0]['email'] . ';' .
                 $resultado[0]['cod_telefono'] . ';' .
                 $resultado[0]['telefono'] . ';' .
                 $resultado[0]['cod_celular'] . ';' .
                 $resultado[0]['celular'] . ';' .
                 $resultado[0]['placa'] . ';' .
                 $resultado[0]['modelo'] . ';' .
                 $resultado[0]['color'];

            break;

    }
}

