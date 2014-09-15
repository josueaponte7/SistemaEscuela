<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Menu extends Seguridad{
    
    public function __construct(){
        
    }
    
   public function add($datos){
        
        $id_menu = $datos['id_menu'];
        $nombre_menu = $datos['nombre_menu'];   
        $estatus = $datos['id_estatus'];
        
        $sql = "INSERT INTO menu (id_menu, nombre_menu, activo)VALUES ('$id_menu', '$nombre_menu', '$estatus');";
   
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function update($datos){
        $id_menu = $datos['id_menu'];
        $nombre_menu = $datos['nombre_menu'];   
        $estatus = $datos['id_estatus'];
        
        $sql = "UPDATE menu
                    SET 
                      nombre_menu = '$nombre_menu',
                      activo = '$estatus'
                    WHERE id_menu = '$id_menu';";
       
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function delete($datos){
        $id_menu= $datos['id_menu'];
        
        $sql = "DELETE FROM menu WHERE id_menu = '$id_menu';";
       
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
      public function getMenu($opciones=array())
    {
        
        if (!isset($opciones['sql'])) {
            $default  = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
            $opciones = array_merge($default, $opciones);
            $sql = "SELECT {$opciones['campos']} FROM menu  WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        } else {
            $sql = $opciones['sql'];
        }
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
