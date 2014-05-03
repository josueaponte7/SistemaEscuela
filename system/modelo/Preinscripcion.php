<?php

$path = dirname(__FILE__);
require_once "$path/Estudiante.php";

class Preinscripcion extends Estudiante {

    public function __construct() {
        
    }

    public function add($datos) {

        $dat = explode('-', $datos['cedula']);
        $nacionalidad = 1;
        if($dat[0] == 'E'){
            $nacionalidad = 2;
        }else if($dat[0] == 'P'){
            $nacionalidad = 3;
        }
        $cedula       = $dat[1];
        $num_registro = $datos['num_registro'];
       
        $sql = "INSERT INTO pre_inscripcion(nacionalidad,cedula,num_registro,fecha_actual)
                     VALUES ($nacionalidad,$cedula,$num_registro,CURRENT_DATE);";

        $resultado = $this->ejecutar($sql);
        if($resultado == 1){
            $sql_up = "UPDATE estudiante SET id_estatus = 2 WHERE CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = nacionalidad),cedula)='".$datos['cedula']."'";
            $resultado = $this->ejecutar($sql_up);
        }
        return $resultado;
    }

}
