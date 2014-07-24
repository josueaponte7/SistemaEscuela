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
     if (isset($_POST['tipo_estudiante'])) {
        $datos['tipo_estudiante'] = $_POST['tipo_estudiante'];
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
   
    if (isset($_POST['paso1']) && $_POST['paso1'] == 1) {
     
        $datos['paso1'] = $_POST['paso1'];
        
        if (isset($_POST['dt_padres'])) {
            $datos['dt_padres'] = $_POST['dt_padres'];
            if (isset($_POST['cedula'])) {
                $datos['dt_padres']['cedula_estudiante'] = $_POST['cedula'];
            }
        }
        if (isset($_POST['id_ingreso'])) {
            $datos['id_ingreso'] = $_POST['id_ingreso'];
            if (isset($_POST['cedula'])) {
                $datos['id_ingreso']['cedula_estudiante'] = $_POST['cedula'];
            }
        }
    }
    
    if (isset($_POST['paso2']) && $_POST['paso2'] == 1) {
        $datos['paso2'] = $_POST['paso2'];
        if (isset($_POST['mision'])) {
            $datos['dt_mision'] = '';
            $datos['mision']    = $_POST['mision'];
        }
    }

    if (isset($_POST['paso3']) && $_POST['paso3'] == 1) {
        $datos['paso3'] = $_POST['paso3'];
        if (isset($_POST['ubicacion_vivienda']) && isset($_POST['tipo_vivienda'])) {
            $datos['dt_vivienda']['cedula_estudiante']  = $_POST['cedula'];
            $datos['dt_vivienda']['ubicacion_vivienda'] = $_POST['ubicacion_vivienda'];
            $datos['dt_vivienda']['tipo_vivienda']      = $_POST['tipo_vivienda'];
            $datos['dt_vivienda']['estado_vivienda']    = $_POST['estado_vivienda'];
            $datos['dt_vivienda']['cama']               = $_POST['cama'];
            $datos['dt_vivienda']['cant_habitacion']    = $_POST['cant_habitacion'];
            if (isset($_POST['tecnologia'])) {
                $datos['dt_vivienda']['tecnologia'] = $_POST['tecnologia'];
            }
        }
    }

    if (isset($_POST['paso4']) && $_POST['paso4'] == 1) {
        $datos['paso4'] = $_POST['paso4'];

        // Datos Diversidad Funcional
        if (isset($_POST['alimentacion']) && isset($_POST['alimentacion_regular'])) {

            $datos['dt_diversidad']['cedula_estudiante']    = $_POST['cedula'];
            $datos['dt_diversidad']['alimentacion']         = $_POST['alimentacion'];
            $datos['dt_diversidad']['alimentacion_regular'] = $_POST['alimentacion_regular'];

            if (isset($_POST['diversidad'])) {
                $datos['dt_diversidad']['diversidad'] = $_POST['diversidad'];
            }
            if (isset($_POST['enfermedad'])) {
                $datos['dt_diversidad']['enfermedad'] = $_POST['enfermedad'];
            }
            if (isset($_POST['servicio'])) {
                $datos['dt_diversidad']['servicio'] = $_POST['servicio'];
            }
            if (isset($_POST['destreza'])) {
                $datos['dt_diversidad']['destreza'] = $_POST['destreza'];
            }
            if (isset($_POST['ayuda'])) {
                $datos['dt_diversidad']['ayuda'] = $_POST['ayuda'];
            }
        }
    }



    switch ($accion) {
        case 'GuardarDT':
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
        case 'BuscarDG':
            $resultado = $obj->searchDG($datos);
            echo $resultado;
        break;
    }
}

