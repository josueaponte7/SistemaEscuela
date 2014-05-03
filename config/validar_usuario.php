<?php
session_start();
date_default_timezone_set('America/Caracas');
require_once './librerias/php/SecurLoginHashing.php';
$salt     = 'Matern1daD';
//$password = new SecurLoginHashing('josue123@#~',4,array('sha256','ripemd160','whirlpool'));
$password = new SecurLoginHashing(4);


$usuario      = $_POST['usuario'];
$clave        = $_POST['clave'];
$hash_usuario = $password->hash($usuario, $salt);
$hash_clave   = $password->hash($clave, $salt);

$ar    = fopen("a.txt", "r");
feof($ar);
$linea = fgets($ar);
$a     = explode(':', $linea);
fclose($ar);

if ($hash_usuario === $a[0] && $hash_clave === trim($a[1])) {
    $date_session = date("Y-m-d H:i");
    $archivo      = "session.txt";
    $session_id   = uniqid(hash("ripemd160", rand()));
    $session      = $date_session . "\n" . $session_id;
    if (file_exists($archivo)) {
        unlink($archivo);
    }
    $fp         = fopen($archivo, "x");
    fwrite($fp, $session);
    fclose($fp);
    $_SESSION['id_session']   = $session_id;
    $_SESSION['date_session'] = $date_session;
    $_SESSION['id_usuario']   = 999;
    echo 1;
} else {
    echo 'error';
}