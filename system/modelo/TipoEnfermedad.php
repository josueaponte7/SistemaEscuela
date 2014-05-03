<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class TipoEnfermedad extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {
        $enfermedad = $datos['enfermedad'];
        $id_enfermedad = $datos['id_enfermedad'];

        $sql = "INSERT INTO enfermedades(id_enfermedad, enfermedad)VALUES ($id_enfermedad, '$enfermedad');";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function update($datos) {
        $enfermedad    = $datos['enfermedad'];
        $id_enfermedad = $datos['id_enfermedad'];

        $sql = "UPDATE enfermedades SET enfermedad = '$enfermedad' WHERE id_enfermedad = '$id_enfermedad';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function delete($datos) {

        $id_enfermedad = $datos['id_enfermedad'];

        $sql = "DELETE FROM enfermedades WHERE id_enfermedad = '$id_enfermedad';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function getEnfermedad($opciones = array()) {

        $default   = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
        $opciones  = array_merge($default, $opciones);
        $sql       = "SELECT {$opciones['campos']} FROM enfermedades en WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
