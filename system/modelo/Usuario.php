<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Usuario extends Seguridad
{

    public function __construct()
    {
        
    }

    public function add($datos)
    {
        $usuario       = $datos['usuario'];
        $nombre        = $datos['nombre'];
        $apellido      = $datos['apellido'];
        $grupo_usuario = $datos['grupo_usuario'];
        $contrasena    = $datos['contrasena'];
        $estatus       = $datos['estatus'];
        $id_usuario    = $datos['id_usuario'];

        $sql = "INSERT INTO usuario(id_usuario, usuario, nombre, apellido, id_grupo, contrasena, activo)VALUES ($id_usuario,'$usuario','$nombre', '$apellido', '$grupo_usuario', MD5('$contrasena'), '$estatus');";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function delete($datos)
    {
        $id_usuario = $datos['id_usuario'];

        $sql = "DELETE FROM usuario WHERE id_usuario = '$id_usuario';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function Login($datos)
    {
        $resultado = parent::Login($datos);
        echo $resultado;
    }

    public function getUsuario($opciones){
        if (!isset($opciones['sql'])) {
        $default   = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
        $opciones  = array_merge($default, $opciones);
        $sql       = "SELECT {$opciones['campos']} FROM usuario u  WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        }else{
            $sql = $opciones['sql'];
        }
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
