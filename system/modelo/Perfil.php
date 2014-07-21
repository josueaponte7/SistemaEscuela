<?php
$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Perfil extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {
        $nombre_usuario       = $datos['nombre_usuario'];
        $nombre               = $datos['nombre'];
        $apellido             = $datos['apellido'];
        $email                = $datos['email'];
        $grupo_usuario        = $datos['grupo_usuario'];
        $contrasena           = $datos['contrasena'];
        $confirmar_contrasena = $datos['confirmar_contrasena'];

       echo  $sql             = "INSERT INTO perfil(nombre_usuario, nombre, apellido, email, grupo_usuario, contrasena, confirmar_contrasena)VALUES ('$nombre_usuario','$nombre', '$apellido', '$email', '$grupo_usuario', MD5('$contrasena'), '$confirmar_contrasena');";
       exit;
       $resultado       = $this->ejecutar($sql);
        return $resultado;
    }

}
