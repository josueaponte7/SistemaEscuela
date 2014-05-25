<?php

require_once '../modelo/Representante.php';

$obj = new Representante();
//
//print_r($_POST);
//exit;

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
    if (isset($_POST['antecedente'])) {
        $datos['antecedente'] = $_POST['antecedente'];
    }
    if (isset($_POST['fuente_ingreso'])) {
        $datos['fuente_ingreso'] = $_POST['fuente_ingreso'];
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
    if (isset($_POST['parroquia'])) {
        $datos['id_parroquia'] = $_POST['parroquia'];
    }
    if (isset($_POST['estatus'])) {
        $datos['id_estatus'] = $_POST['estatus'];
    }
    if (isset($_POST['nivel_inst'])) {
        $datos['id_nivel'] = $_POST['nivel_inst'];
    }
    if (isset($_POST['profesion'])) {
        $datos['id_profesion'] = $_POST['profesion'];
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
            $cedula    = $datos['cedula'];        

            $opciones['sql']    = "SELECT 
                                        nacionalidad,
                                        nombre,
                                        apellido,
                                        sexo,
                                        DATE_FORMAT(fech_naci,'%d/%m/%Y') AS fech_naci,
                                        (YEAR(CURDATE())-YEAR(fech_naci)) - (RIGHT(CURDATE(),5)<RIGHT(fech_naci,5)) AS edad, 
                                        email, 
                                        cod_telefono,
                                        telefono,
                                        cod_celular, 
                                        celular, 
                                        lugar_naci, 
                                        p.id_parroquia, 
                                        m.id_municipio,
                                        es.id_estado,
                                        calle,
                                        casa,
                                        edificio,
                                        barrio,
                                        id_estatus,
                                        antecedente,
                                        id_nivel,
                                        id_profesion,
                                        fuente_ingreso,
                                        email
                                    FROM representante AS re
                                    INNER JOIN parroquia  AS p ON re.id_parroquia=p.id_parroquia
                                    INNER JOIN municipio AS m ON p.id_municipio=m.id_municipio
                                    INNER JOIN estado AS es ON m.id_estado=es.id_estado WHERE cedula = $cedula";
            $resultado             = $obj->getRepresentantes($opciones);
            echo $resultado[0]['nacionalidad'] . ';' .
                 $resultado[0]['nombre'] . ';' .
                 $resultado[0]['apellido'].';'.
                 $resultado[0]['sexo'].';'.
                 $resultado[0]['fech_naci'].';'.
                 $resultado[0]['edad'].';'.
                 $resultado[0]['cod_telefono'] . ';' .
                 $resultado[0]['telefono'] . ';' .
                 $resultado[0]['cod_celular'] . ';' .
                 $resultado[0]['celular'] . ';' .
                 $resultado[0]['lugar_naci'].';'.
                 $resultado[0]['id_estado'] . ';' .
                 $resultado[0]['id_municipio'].';'.           
                 $resultado[0]['id_parroquia'].';'.
                 $resultado[0]['calle'].';'.
                 $resultado[0]['casa'].';'.
                 $resultado[0]['edificio'].';'.
                 $resultado[0]['barrio'].';'.
                 $resultado[0]['id_estatus'].';'.
                 $resultado[0]['antecedente'].';'.
                 $resultado[0]['id_nivel'].';'.
                 $resultado[0]['id_profesion'].';'.
                 $resultado[0]['fuente_ingreso'].';'.
                 $resultado[0]['email'];

            break;
            
    }
}
