<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class ProgramaSocial extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {
        
        $nombre_programa = $datos['nombre_programa'];
        $id_programa = $datos['id_programa'];
        
         $sql = "INSERT INTO programa_social(id_programa, nombre_programa)VALUES ($id_programa, '$nombre_programa');";
       
        $resultado       = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function update($datos){
        $nombre_programa = $datos['nombre_programa'];
        $id_programa = $datos['id_programa'];
        
       $sql = "UPDATE programa_social SET nombre_programa = '$nombre_programa' WHERE id_programa = '$id_programa';";
       
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    
     public function delete($datos){
        $id_programa = $datos['id_programa'];
        
        $sql = "DELETE FROM programa_social WHERE id_programa = '$id_programa';";
      
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function getPrograma($opciones=array()) {

        $default = array('campos'=> '*','condicion' => '1','ordenar'   => '1','limite'    => 200);
        $opciones = array_merge($default, $opciones);
        $sql = "SELECT {$opciones['campos']} FROM programa_social ps WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
