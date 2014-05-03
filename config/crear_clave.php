<?php
require_once './librerias/php/SecurLoginHashing.php';
$salt     = 'M@t3N1D@d1Nt3Gr@lAra6u@';
$password = new SecurLoginHashing(4);
$clave = 'M@T3rN1d@d';
$hash_clave = $password->hash($clave, $salt);

echo $hash_clave;