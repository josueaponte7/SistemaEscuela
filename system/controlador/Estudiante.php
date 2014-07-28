<?php
ini_set('max_execution_time', 1);
require_once '../modelo/Estudiante.php';
$obj = new Estudiante();

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
    if (isset($_POST['estatus'])) {
        $datos['id_estatus'] = $_POST['estatus'];
    }
    if (isset($_POST['fech_naci'])) {
        $datos['fech_naci'] = $_POST['fech_naci'];
    }
    if (isset($_POST['lugar_naci'])) {
        $datos['lugar_naci'] = $_POST['lugar_naci'];
    }
    if (isset($_POST['sexo'])) {
        $datos['sexo'] = $_POST['sexo'];
    }
    if (isset($_POST['calle'])) {
        $datos['calle'] = $_POST['calle'];
    }
    if (isset($_POST['casa'])) {
        $datos['casa'] = $_POST['casa'];
    }
    if (isset($_POST['edificio'])) {
        $datos['edificio'] = $_POST['edificio'];
    }
    if (isset($_POST['barrio'])) {
        $datos['barrio'] = $_POST['barrio'];
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
    if (isset($_POST['id_parroquia'])) {
        $datos['id_parroquia'] = $_POST['id_parroquia'];
    }
    if (isset($_POST['representantes'])) {
        $datos['representantes'] = $_POST['representantes'];
    }
    if (isset($_POST['cedula_representante'])) {
        $datos['cedula_representante'] = $_POST['cedula_representante'];
    }
    switch ($accion) {
        case 'Guardar':
            $resultado = $obj->add($datos);
            if ($resultado == 1) {
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
        case 'UpRepre':
            $resultado = $obj->UpRepre($datos);
            if ($resultado) {
                echo 1;
            }
        break;
        case 'Buscar':
            $resultado = $obj->getEstudiante($datos);
            echo $resultado;
        break;
        case 'BuscarRep':
            $resultado = $obj->getRepresentante($datos);
            echo $resultado;
        break;
    }
}
