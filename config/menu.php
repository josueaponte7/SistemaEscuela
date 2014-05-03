<?php
session_start();
date_default_timezone_set('America/Caracas');
require_once './salir.php';
$valida = new Salir();
if(isset($_SESSION['date_session'])){
   $valida->valSession($_SESSION['date_session']); 
}else{
    $valida->exitSesion();
}

$hoy  = date("d/m/Y");
$hora = date("g:i A");
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon"   href="imagenes/sistema/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="librerias/css/maquetacion.css"  />
        <script type="text/javascript" src="librerias/js/jquery.1.10.2.js"></script>
        <script type="text/javascript" src="librerias/js/ddsmoothmenu.js"></script>
        <script type="text/javascript">

            ddsmoothmenu.init({
                mainmenuid: "menu", //menu DIV id
                orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
                //classname: 'ddsmoothmenu', //class added to menu's outer DIV
                customtheme: ["#96248D", "#D640C7"],
                contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {

                $("div#menu > ul > li > ul > li > span").click(function() {
                    var directorio = $(this).parents('ul').siblings('span').attr('id');
                    var archivo = $(this).attr('id');
                    var cargar = 'vista/' + directorio + '/' + archivo + '.php';
                    $('#cuerpo').load(cargar);
                });

                $("#salir").click(function() {
                    alert('Cerrar la Sesión');
                    location.replace('cerrar.php');
                });
            });
        </script>
    </head>
    <body>  
        <div id="contenedor"> 
            <div id="cabecera">
                <img src="imagenes/sistema/header.png" width="960" height="150" alt="header"/>
                <div style="font-size:12px; position: relative;top:-45px;left: 15px;">Usuario:</div>
                <div style="font-size:12px;position: relative;top:-43px;left: 15px;">Fecha:</div>
            </div>

            <div id="menu" class="ddsmoothmenu" style="margin-top: 3px;">
                <ul> 
                    <li>
                        <span id="seguridad">Seguridad</span>
                        <ul>
                            <li><span id="modulo">Modulos</span></li>
                            <li><span id="privilegio">Privilegios Usuario</span></li>
                            <li><span id="perfiles">Perfiles Usuario</span></li>
                            <li><span id="usuario">Administración Usuario</span></li>
                        </ul>
                    </li>
                    <li>
                        <span>Bitacora</span>
                        <ul>
                            <li><span>Bitacora Usuario</span></li>
                            <li><span>Bitacora del Sistema</span></li>
                        </ul>
                    </li>
                    <li>
                        <span id="salir" style="width:38px;  float: right;position: relative;left:740px;border-right: none;border-left: 1px solid #778;">Salir</span>
                    </li>
                </ul>
            </div> 
            <div id="cuerpo" ></div> 
            <div id="pie">
                <img src="imagenes/sistema/pie.png" width="962" height="70" alt="pie"/>
            </div>
        </div>
    </body>
</html>
