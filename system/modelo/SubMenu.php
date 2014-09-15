<?php

$path = dirname(__FILE__);
require_once "$path/Menu.php";

class SubMenu extends Menu{
    
    public function __construct(){
        
    }
    
   public function add($datos){
        
        $nombre_submenu = $datos['nombre_submenu'];
        $id_submenu = $datos['id_submenu'];
        $id_menu = $datos['id_menu'];
        $url  = $datos['url'];
        $estatus = $datos['id_estatus'];
        
        $sql = "INSERT INTO sub_menu(id_submenu, id_menu, nombre_submenu, url, activo) VALUES ('$id_submenu', '$id_menu', '$nombre_submenu', '$url', '$estatus');";
      
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function update($datos){
        $nombre_submenu = $datos['nombre_submenu'];
        $id_submenu = $datos['id_submenu'];
        $id_menu = $datos['id_menu'];
        $url  = $datos['url'];
        $estatus = $datos['id_estatus'];
        
        $sql = "UPDATE sub_menu 
                    SET
                      id_menu = '$id_menu',
                      nombre_submenu = '$nombre_submenu',
                      url = '$url',
                      activo = '$estatus'
                    WHERE id_submenu = '$id_submenu';";
       
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function delete($datos){
        $id_submenu = $datos['id_submenu'];
        
      $sql = "DELETE FROM sub_menu WHERE id_submenu = '$id_submenu';";
       
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
     public function getSubMenu($opciones=array())
    {
        if (!isset($opciones['sql'])) {
            $default  = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
            $opciones = array_merge($default, $opciones);
            $sql      = "SELECT {$opciones['campos']} FROM sub_menu sbm  WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        } else {
            $sql = $opciones['sql'];
        }
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
