<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class TipoServicio extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {

        $tiposervicio    = $datos['tiposervicio'];
        $id_tiposervicio = $datos['id_tiposervicio'];
        $sql = "INSERT INTO tiposervicio(id_tiposervicio,tiposervicio)VALUES ($id_tiposervicio,'$tiposervicio');";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function update($datos) {

        $tiposervicio    = $datos['tiposervicio'];
        $id_tiposervicio = $datos['id_tiposervicio'];

        $sql = "UPDATE tiposervicio SET tiposervicio = '$tiposervicio' WHERE id_tiposervicio = '$id_tiposervicio';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function delete($datos) {

        $id_tiposervicio = $datos['id_tiposervicio'];

        $sql = "DELETE FROM  tiposervicio WHERE id_tiposervicio = '$id_tiposervicio';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function getTipo($opciones = array()) {

        $default   = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
        $opciones  = array_merge($default, $opciones);
        $sql       = "SELECT {$opciones['campos']} FROM tiposervicio tp WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
