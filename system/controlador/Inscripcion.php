<?php
require_once '../modelo/Inscripcion.php';

$obj = new Inscripcion();
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['cedula'])) {
        $datos['cedula_estudiante'] = $_POST['cedula'];
    }
    if (isset($_POST['fecha'])) {
        $datos['fecha'] = $_POST['fecha'];
    }    
     if (isset($_POST['tipo_estudainte'])) {
        $datos['tipo_estudainte'] = $_POST['tipo_estudainte'];
    }
    if (isset($_POST['id_anio'])) {
        $datos['id_anio'] = $_POST['id_anio'];
    }   
    if (isset($_POST['actividad'])) {
        $datos['id_actividad'] = $_POST['actividad'];
    }
    if (isset($_POST['area'])) {
        $datos['area'] = $_POST['area'];
    }
    if (isset($_POST['cedula_r'])) {
        $datos['cedula_representante'] = $_POST['cedula_r'];
    }
    if (isset($_POST['cedula_cho'])) {
        $datos['cedula_chofer'] = $_POST['cedula_cho'];
    }
    if (isset($_POST['medio'])) {
        $datos['id_medio'] = $_POST['medio'];
    }
    if (isset($_POST['id_tipo'])) {
        $datos['id_tipo'] = $_POST['id_tipo'];
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
        case 'BuscarDatos':
            $resultado = $obj->getDatos($datos);
            echo $resultado;
        break;
    }
}

