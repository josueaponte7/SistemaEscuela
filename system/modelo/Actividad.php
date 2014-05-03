<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Actividad extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {

        $actividad   = $datos['actividad'];
        $descripcion = $datos['descripcion'];
        $id_actividad     = $datos['id_actividad'];

        $sql = "INSERT INTO actividad(id_actividad, actividad, descripcion)VALUES ($id_actividad, '$actividad','$descripcion');";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function update($datos) {

        $id_actividad = $datos['id_actividad'];
        $actividad    = $datos['actividad'];
        $descripcion  = $datos['descripcion'];

        $sql = "UPDATE actividad SET actividad = '$actividad',  descripcion = '$descripcion' WHERE id_actividad = '$id_actividad';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function delete($datos) {

        $id_actividad = $datos['id_actividad'];

        $sql = "DELETE FROM actividad WHERE id_actividad = '$id_actividad';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function getActividad($opciones = array()) {

        $default   = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
        $opciones  = array_merge($default, $opciones);
        $sql       = "SELECT {$opciones['campos']} FROM actividad ac WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
