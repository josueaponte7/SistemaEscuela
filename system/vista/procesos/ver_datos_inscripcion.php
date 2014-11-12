<?php
require_once '../../modelo/Inscripcion.php';
require_once '../../modelo/DatosGenerales.php';
require_once '../../modelo/AnioEscolar.php';
require_once '../../modelo/Representante.php';
$obj_inscrip = new Inscripcion();
$obj_misi    = new DatosGenerales();
$obj_anioes  = new AnioEscolar();
$obj_datos   = new Representante();

$cedula = $_GET['cedula'];

$obj       = new Inscripcion();
$resultado = $obj->getDatosConst($cedula);
?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>jQuery Modal Contact Demo</title>
        <meta name="author" content="Jake Rocheleau">
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.js"></script>
    </head>
    <body>
        <table width="778" border="0" align="center">
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td width="884">
                    <fieldset>
                        <legend style="color: #FF0000">
                            <?php echo $resultado[0]['cedula'] ?>
                            &nbsp;&nbsp;
                            <?php echo ucwords($resultado[0]['nombre']) ?>
                        </legend>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td height="30" align="center">
                    <table width="97%" border="0" align="center" style="width:100%">
                        <tr>
                            <th width="137" height="37"> Tipo:</th>
                            <td width="336"><?php echo $resultado[0]['tipo'] ?></td>
                            <th width="58" height="41">Año:</th>
                            <td width="223"><?php echo $resultado[0]['anio'] ?></td>
                        </tr>
                        <tr>
                            <th height="41">Actividad:</th>
                            <td><?php echo $resultado[0]['actividad'] ?></td>
                            <th height="41">Fecha:</th>
                            <td><?php echo $resultado[0]['fecha_inscripcion'] ?></td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
            <tr>
                <td height="24" align="center">&nbsp;</td>
            </tr>
            <tr>
                <td height="24" align="center">&nbsp;</td>
            </tr>
        </table>
    </body>
</html>