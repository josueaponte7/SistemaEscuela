<?php
$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class StatusRepresentante extends Seguridad {
    
     public function __construct() {
        
    }
   
    public function add($datos){
        $nombre = $datos['nombre'];
        $id_estatus = $datos['id_estatus'];
        
        $sql = "INSERT INTO estatus_representante(id_estatus, nombre)VALUES($id_estatus, '$nombre');";
         
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
     public function update($datos) {

        $id_estatus = $datos['id_estatus'];
        $nombre     = $datos['nombre'];
        $sql        = "UPDATE estatus_representante SET   nombre = '$nombre' WHERE id_estatus = '$id_estatus';";        

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
     public function delete($datos) {

        $id_estatus = $datos['id_estatus'];

        $sql = "DELETE FROM estatus_representante WHERE id_estatus = '$id_estatus';";
       
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function getStrep($opciones=array()) {

        $default = array('campos'=> '*','condicion' => '1','ordenar'   => '1','limite'    => 200);
        $opciones = array_merge($default, $opciones);
        $sql = "SELECT {$opciones['campos']} FROM estatus_representante erep WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        $resultado = $this->consultar_array($sql);
        return $resultado;
    } 
    
}
