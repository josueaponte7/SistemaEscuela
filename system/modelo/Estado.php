<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Estado extends Seguridad
{

    public function __construct()
    {
        
    }

    public function add($datos)
    {
                
        $nombre_estado = $datos['nombre_estado'];
        $id_estado     = $datos['id_estado'];
        
        $sql = "INSERT INTO estado(id_estado,nombre_estado)VALUES ($id_estado,'$nombre_estado');";
      
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function update($datos)
    {

        $nombre_estado = $datos['nombre_estado'];
        $id_estado     = $datos['id_estado'];
        
        $sql           = "UPDATE estado SET  nombre_estado = '$nombre_estado' WHERE id_estado = '$id_estado';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function delete($datos)
    {

        $estado = $datos['id_estado'];
        $sql    = "DELETE FROM estado WHERE id_estado = '$estado';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function getEstados($opciones = array())
    {

        $default   = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
        $opciones  = array_merge($default, $opciones);
        $sql       = "SELECT {$opciones['campos']} FROM estado WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
