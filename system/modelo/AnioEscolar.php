<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class AnioEscolar extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {
        $anio_escolar = $datos['anio_escolar'];
        $id_anio      = $datos['id_anio'];

        $sql = "INSERT INTO anio_escolar(id_anio,anio_escolar) VALUES ($id_anio,'$anio_escolar');";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function update($datos) {

        $anio_escolar = $datos['anio_escolar'];
        $id_anio      = $datos['id_anio'];

        $sql = "UPDATE anio_escolar SET anio_escolar = '$anio_escolar' WHERE id_anio = '$id_anio';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function delete($datos) {

        $id_anio = $datos['id_anio'];
        $sql     = "DELETE FROM anio_escolar WHERE id_anio = '$id_anio';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function getAnio($opciones = array()) {

        $default  = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
        $opciones = array_merge($default, $opciones);
        $sql      = "SELECT {$opciones['campos']} FROM anio_escolar WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
