<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Estudiante extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {
        $nacionalidad = $datos['nacionalidad'];
        $cedula       = $datos['cedula'];
        $nombre       = $datos['nombre'];
        $apellido     = $datos['apellido'];
        $email        = $datos['email'];
        $id_estatus   = $datos['id_estatus'];
        $fech_naci    = $datos['fech_naci'];
        $lugar_naci   = $datos['lugar_naci'];
        $sexo         = $datos['sexo'];
        $calle        = $datos['calle'];
        $casa         = $datos['casa'];
        $edificio     = $datos['edificio'];
        $barrio       = $datos['barrio'];
        $cod_telefono = $datos['cod_telefono'];
        $telefono     = $datos['telefono'];
        $cod_celular  = $datos['cod_celular'];
        $celular      = $datos['celular'];
        $id_parroquia = $datos['id_parroquia'];
        $fech_naci    = $this->formateaBD($fech_naci);
        
        
        $condicion = "cedula = '$cedula' AND nacionalidad = $nacionalidad";
        $total     = $this->totalFilas('estudiante', 'cedula', $condicion);
        if ($total > 0) {
            $resultado = 13;
        } else {
            $sql = "INSERT INTO estudiante(nacionalidad,cedula, nombre, apellido, email, fech_naci, lugar_naci, sexo, id_parroquia, calle, casa, edificio,
                                       barrio, cod_telefono, telefono, cod_celular, celular,id_estatus)
                     VALUES ('$nacionalidad','$cedula', '$nombre', '$apellido', '$email', '$fech_naci', '$lugar_naci', '$sexo', '$id_parroquia', '$calle',
                             '$casa', '$edificio', '$barrio', '$cod_telefono', '$telefono', '$cod_celular', '$celular',$id_estatus);";

            $resultado = $this->ejecutar($sql);
            if ($resultado === TRUE) {
                $representantes = explode(",", $datos['representantes']);
                for ($i = 0; $i < count($representantes); $i++) {
                    $datos_repre = explode(";", $representantes[$i]);

                    $sql = "INSERT INTO estudiante_representante(cedula_estudiante,cedula_representante,parentesco,representante)
                              VALUES ($cedula,$datos_repre[0],$datos_repre[1],$datos_repre[2]);";
                    $this->ejecutar($sql);
                }
            }
        }
        return $resultado;
    }

    public function getEstudianterepre($opciones = array()) {

        if (empty($opciones['sql'])) {
            $default  = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
            $opciones = array_merge($default, $opciones);
            $sql      = "SELECT {$opciones['campos']} FROM estudiante_representante AS er WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        } else {
            $sql = $opciones['sql'];
        }

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function UpRepre($datos) {
        $cedula               = $datos['cedula'];
        $cedula_representante = $datos['cedula_representante'];


        $sql       = "UPDATE estudiante_representante SET representante = 0 WHERE cedula_estudiante=$cedula;";
        $resultado = $this->ejecutar($sql);

        if ($resultado) {
            $sql1       = "UPDATE estudiante_representante SET representante = 1 WHERE cedula_estudiante=$cedula AND cedula_representante=$cedula_representante;";
            $resultado1 = $this->ejecutar($sql1);
        }

        return $resultado1;
    }

    /*     * *Para llamar al estudiante y montarlo en el select con los datos completos*** */

    public function datos($opciones = array()) {
       
        if (empty($opciones['sql'])) {
            $default    = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
            $opciones   = array_merge($default, $opciones);
            $this->_sql = "SELECT {$opciones['campos']} FROM estudiante AS es WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']}";
           
        } else {
            $this->_sql = $opciones['sql'];
        }
        $resultado = $this->consultar_array($this->_sql);
        return $resultado;
    }

}
