<?php
require_once '../modelo/Perfil.php';
$obj = new Perfil();

$datos['grupo_usuario'] = $_POST['grupo_usuario'];
$datos['menu_comb']     = $_POST['menu_comb'];
$datos['sub_menu']      = $_POST['sub_menu'];

$accion_modu = array('registrar'=>0,'modificar'=>0,'eliminar'=>0,'consultar'=>0,'imprimir'=>0);
$accion_mod = array_merge($accion_modu,$_POST['accion_mod']);

$datos['id_perfil'] = 1;
$datos['registrar'] = $accion_mod['registrar'];
$datos['modificar'] = $accion_mod['modificar'];
$datos['eliminar']  = $accion_mod['eliminar'];
$datos['consultar'] = $accion_mod['consultar'];
$datos['imprimir']  = $accion_mod['imprimir'];

$resultado = $obj->add($datos);
if($resultado){
    echo 1;
}

