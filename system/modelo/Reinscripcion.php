<?php
$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Reinscripcion extends Seguridad {
    
    public function __construct() {
    }
    
    public function add($datos){
        
        $nacionalidad = $datos['nacionalidad'];
        $cedula       = $datos['cedula'];
        $nombre       = $datos['nombre'];
        $apellido     = $datos['apellido'];
        $email        = $datos['email'];
        $fech_naci    = $datos['fech_naci'];
        $lugar_naci   = $datos['lugar_naci'];
        $calle        = $datos['calle'];
        $casa         = $datos['casa'];
        $edificio     = $datos['edificio'];
        $barrio       = $datos['barrio'];
        $cod_telefono = $datos['cod_telefono'];
        $telefono     = $datos['telefono'];
        $cod_celular  = $datos['cod_celular'];
        $celular      = $datos['celular'];
        $id_parroquia = $datos['id_parroquia'];


        $fech_naci = $this->formateaBD($fech_naci);
        
//         $sql = "INSERT INTO estudiante(nacionalidad,cedula, nombre, apellido, email, fech_naci, lugar_naci,  id_parroquia, calle, casa, edificio, barrio, cod_telefono, telefono, cod_celular, celular)"
//                . "                        VALUES ('$nacionalidad','$cedula', '$nombre', '$apellido', '$email', '$fech_naci', '$lugar_naci', '$id_parroquia', '$calle', '$casa', '$edificio', '$barrio', "
//                . "                                  '$cod_telefono', '$telefono', '$cod_celular', '$celular');";
//
//        $resultado = $this->ejecutar($sql);
//        if ($resultado === TRUE) {
//            $representantes = explode(",", $datos['representantes']);
//            for ($i = 0; $i < count($representantes); $i++) {
//                $datos_repre = explode(";", $representantes[$i]);
//                
//                $sql = "INSERT INTO estudiante_representante(cedula_estudiante,cedula_representante,parentesco,representante)
//                        VALUES ($cedula,$datos_repre[0],$datos_repre[1],$datos_repre[2]);";
//                $this->ejecutar($sql);
//            }
//        }
//        return $resultado;
        
    }
}
