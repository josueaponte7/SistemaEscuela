<?php
require_once '../modelo/Perfil.php';
$obj = new Perfil();

$nombre_usuario = $_POST['nombre_usuario'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$grupo_usuario = $_POST['grupo_usuario'];
$contrasena = $_POST['contrasena'];
$confirmar_contrasena = $_POST['confirmar_contrasena'];

$datos = array('nombre'=>$nombre, 
               'apellido'=>$apellido,
               'nombre_usuario'=>$nombre_usuario,
               'email'=>$email,
               'grupo_usuario'=>$grupo_usuario,
               'contrasena'=>$contrasena,
               'confirmar_contrasena'=>$confirmar_contrasena
        
              );
$resultado = $obj->add($datos);
if($resultado){
    echo 1;
}

