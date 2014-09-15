<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Profesion extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {
        
        $nombre_profesion = $datos['nombre_profesion'];
        $id_profesion = $datos['id_profesion'];
        
         $sql = "INSERT INTO profesion(id_profesion, nombre_profesion)VALUES ($id_profesion, '$nombre_profesion');";
       
        $resultado       = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function update($datos){
        $nombre_profesion = $datos['nombre_profesion'];
        $id_profesion = $datos['id_profesion'];
        
       $sql = "UPDATE profesion SET nombre_profesion = '$nombre_profesion' WHERE id_profesion = '$id_profesion';";
       
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    
     public function delete($datos){
        $id_profesion = $datos['id_profesion'];
        
        $sql = "DELETE FROM profesion WHERE id_profesion = '$id_profesion';";
      
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function getProfesion($opciones=array()) {

        $default = array('campos'=> '*','condicion' => '1','ordenar'   => '1','limite'    => 200);
        $opciones = array_merge($default, $opciones);
        $sql = "SELECT {$opciones['campos']} FROM profesion pf WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
