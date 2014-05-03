<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class ServicioSalud extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {
        
        $id_servicio     = $datos['id_servicio'];
        $servicio     = $datos['servicio'];
        $cod_telefono = $datos['cod_telefono'];
        $telefono     = $datos['telefono'];
        $tiposervicio = $datos['tiposervicio'];
        $id_parroquia = $datos['parroquia'];

    $sql = "INSERT INTO servicio_publico (id_servicio, servicio,cod_telefono,telefono,id_parroquia,id_tiposervicio)
                                    VALUES ($id_servicio, '$servicio','$cod_telefono','$telefono','$id_parroquia','$tiposervicio');";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function getServicio($opciones) {
        if (empty($opciones['sql'])) {
        $default = array('campos'=> '*','condicion' => '1','ordenar'   => '1','limite'    => 200);
        $opciones = array_merge($default, $opciones);
        $sql = "SELECT {$opciones['campos']} FROM servicio_publico sp  WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        }else {
           $sql = $opciones['sql'];   
           
        }
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
