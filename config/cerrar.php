<?php
session_start();
require_once './Salir.php';

$cerrar = new Salir();
$cerrar->exitSesion();