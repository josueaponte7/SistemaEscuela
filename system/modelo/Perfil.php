<?php
$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Perfil extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {

       $id_perfil = $datos['id_perfil'];
       $id_grupo  = $datos['grupo_usuario'];
       $menu_comb = $datos['menu_comb'];
       $sub_menu  = $datos['sub_menu'];
       $registrar = $datos['registrar'];
       $modificar = $datos['modificar'];
       $eliminar  = $datos['eliminar'];
       $consultar = $datos['consultar'];
       $imprimir  = $datos['imprimir'];
       
       echo  $sql             = "INSERT INTO perfil(id_perfil,id_grupo,id_submenu,registrar,modificar,eliminar,consultar,imprimir)
               VALUES($id_perfil,$id_grupo,$sub_menu,$registrar,$modificar,$eliminar,$consultar,$imprimir);";
       exit;
       $resultado       = $this->ejecutar($sql);
        return $resultado;
    }
    
    public function getPerfil($opciones=array()) {

        $default = array('campos'=> '*','condicion' => '1','ordenar'   => '1','limite'    => 200);
        $opciones = array_merge($default, $opciones);
        $sql = "SELECT {$opciones['campos']} FROM perfil  WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        $resultado = $this->consultar_array($sql);
        return $resultado;
    } 

}
