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
    
    
    // Datos Generales
    if (isset($_POST['ingreso'])) {
        $datos['ingreso'] = $_POST['ingreso'];
    }
    if (isset($_POST['madre_nivel'])) {
        $datos['madre_nivel'] = $_POST['madre_nivel'];
    }
    if (isset($_POST['padre_nivel'])) {
        $datos['padre_nivel'] = $_POST['padre_nivel'];
    }
    if (isset($_POST['representante_nivel'])) {
        $datos['representante_nivel'] = $_POST['representante_nivel'];
    }
    if (isset($_POST['representante_a'])) {
        $datos['representante_a'] = $_POST['representante_a'];
    }
    if (isset($_POST['representante_see'])) {
        $datos['representante_see'] = $_POST['representante_see'];
    }
    if (isset($_POST['representante_set'])) {
        $datos['representante_set'] = $_POST['representante_set'];
    }
    if (isset($_POST['dt'])) {
        $datos['dt'] = $_POST['dt'];
    }
    if (isset($_POST['representante_al'])) {
        $datos['representante_al'] = $_POST['representante_al'];
    }
    if (isset($_POST['mision'])) {
        $datos['mision'] = $_POST['mision'];
    }
    
    /*if (isset($_POST['ubicacion_vivienda'])) {
        $datos['ubicacion'] = $_POST['ubicacion_vivienda'];
    }
    if (isset($_POST['tipo_vivienda'])) {
        $datos['tipo'] = $_POST['tipo_vivienda'];
    }
    if (isset($_POST['estado_vivienda'])) {
        $datos['estado_vivienda'] = $_POST['estado_vivienda'];
    }
    if (isset($_POST['cant_habitacion'])) {
        $datos['estado_vivienda'] = $_POST['cant_habitacion'];
    }
    if (isset($_POST['cama'])) {
        $datos['cama'] = $_POST['cama'];
    }*/
    if(isset($_POST['dt']) && $_POST['dt'] == 'dt2'){
        $datos['dtv'] = $_POST;
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
        case 'GuardarDT':
            $resultado = $obj->addDG($datos);
            echo $resultado;
        break;
    }
}

