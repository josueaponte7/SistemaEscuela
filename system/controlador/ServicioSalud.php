<?php

require_once '../modelo/ServicioSalud.php';
$obj = new ServicioSalud();

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['id_servicio'])) {
        $datos['id_servicio'] = $_POST['id_servicio'];
    }
    if (isset($_POST['servicio'])) {
        $datos['servicio'] = $_POST['servicio'];
    }    
     if (isset($_POST['cod_telefono'])) {
        $datos['cod_telefono'] = $_POST['cod_telefono'];
    }
    if (isset($_POST['telefono'])) {
        $datos['telefono'] = $_POST['telefono'];
    }   
    if (isset($_POST['tiposervicio'])) {
        $datos['tiposervicio'] = $_POST['tiposervicio'];
    }
    if (isset($_POST['parroquia'])) {
        $datos['parroquia'] = $_POST['parroquia'];
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
            
            
            case 'BuscarDatos':    ;
                
            $id_servicio    = $datos['id_servicio'];      
                
            $opciones['sql']    = "SELECT
                                    servicio,
                                    cod_telefono,
                                    telefono,
                                    p.id_parroquia, 
                                    m.id_municipio,
                                    es.id_estado,
                                    id_tiposervicio
                                    FROM servicio_publico sp
                                    INNER JOIN parroquia  AS p ON sp.id_parroquia=p.id_parroquia
                                    INNER JOIN municipio AS m ON p.id_municipio=m.id_municipio
                                    INNER JOIN estado AS es ON m.id_estado=es.id_estado 
                                    WHERE id_servicio = $id_servicio";
            $resultado             = $obj->getServicio($opciones);
            echo $resultado[0]['servicio'] . ';' .
                 $resultado[0]['cod_telefono'] . ';' .
                 $resultado[0]['telefono'].';'.
                 $resultado[0]['id_estado'] . ';' .
                 $resultado[0]['id_municipio'].';'.           
                 $resultado[0]['id_parroquia'].';'.
                 $resultado[0]['id_tiposervicio'];

            break;
            
    }
}

