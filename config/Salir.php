<?php

require_once './Sesion.php';

class Salir extends Sesion
{
    public function __construct()
    {

    }
    
    public function cerrar()
    {
        $this->cerrarSesion();
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
        header("location:admin.php"); // Fecha en el pasado
    }
    public function exitSesion()
    {
        parent::cerrarSesion();
    }
    
    public function valSession($date)
    {
        parent::valSession($date);
    }
}
