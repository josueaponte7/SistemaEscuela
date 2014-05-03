<?php
$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class GrupoUsuario extends Seguridad {
    
    public function __construct() {       
        
    }
    
    public function add($datos){
        
        $nombre_grupo = $datos['nombre_grupo'];
        $id_grupo = $datos['id_grupo'];
        
        $sql = "INSERT INTO grupo_usuario(id_grupo, nombre_grupo)VALUES ($id_grupo, '$nombre_grupo');";
     
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function update($datos){
        $nombre_grupo = $datos['nombre_grupo'];
        $id_grupo = $datos['id_grupo'];
        
         $sql = "UPDATE grupo_usuario SET  nombre_grupo = '$nombre_grupo' WHERE id_grupo = '$id_grupo';";
       
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function delete($datos){
        $id_grupo = $datos['id_grupo'];
        
        $sql = "DELETE FROM grupo_usuario WHERE id_grupo = '$id_grupo';";
       
        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function getGrupo($opciones=array()) {

        $default = array('campos'=> '*','condicion' => '1','ordenar'   => '1','limite'    => 200);
        $opciones = array_merge($default, $opciones);
        $sql = "SELECT {$opciones['campos']} FROM grupo_usuario gu WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
}
