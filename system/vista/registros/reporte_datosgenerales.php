<?php //
session_start();

$_SESSION['menu']      = 'registros_reporte_datosgenerales';
$_SESSION['dir']       = 'registros';
$_SESSION['archivo']   = 'reporte_datosgenerales';
$_SESSION['height']    = '1800px';
$_SESSION['heightifm'] = '1700px';
$_SESSION['abrir']     = 'registros';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Reporte Datos Generales</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>  
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/datepicker3.css" rel="stylesheet" media="screen"/> 
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2-bootstrap.css"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.es.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <!--<script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>-->
        <script type="text/javascript" src="../../librerias/script/datos_generales.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
           $('#registrar').click(function(){
               window.location = 'datos_generales.php';
           });
           
           $('#registrar').click(function(){
               window.location = 'datos_generales.php';
           });
           
//           $('#salir').click(function(){
//               window.location = '../../../index.php';
//           });
        });
        </script>
        
    </head>
    <body>  
        <div id="botones" style="margin-top: 20px;">
            <button type="button" id="registrar" class="btn btn-primary">Registrar Datos Generales</button>

<!--            <button type="button" id="salir" class="btn btn-primary">Inicio</button>-->
        </div>
        
        
    </body>
</html>