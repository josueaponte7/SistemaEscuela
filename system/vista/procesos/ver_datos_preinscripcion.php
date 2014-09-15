<?php
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/Seguridad.php';
require_once '../../modelo/Preinscripcion.php';


//$obj_parro = new Parroquia();
//$obj_repre = new Seguridad();
$obj_pre   = new Preinscripcion();

$campos['condicion'] = 1;
$cedula_condicion    = 'e.cedula';

if (!isset($_GET['cedula'])) {
    
}
$cedula        = $_GET['cedula'];
$campos['sql'] = "SELECT 
                    LPAD(pr.num_registro, 8, '0') AS num_registro,
                    CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = pr.nacionalidad),pr.cedula) AS cedula,
                    CONCAT_WS(' ',e.nombre,e.apellido) AS nombres,
                    se.sexo,
                    IF(cod_telefono='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_telefono),telefono)) AS telefono, 
                    IF(cod_celular='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_celular),celular)) AS celular,
                    DATE_FORMAT(CURRENT_DATE,'%d/%m/%Y' ) AS fecha_actual
                FROM pre_inscripcion pr
                INNER JOIN estudiante AS e ON(pr.cedula = e.cedula)
                INNER JOIN sexo se ON (e.sexo = se.id_sexo)
                WHERE id_estatus < 3";

/* $fp=fopen("archivo.txt","w+");
  fwrite($fp,$campos['sql']);
  fclose($fp) ; */

$resultado = $obj_pre->getPreinscricion($campos);

$telefono = $resultado[0]['telefono'];
$celular  = $resultado[0]['celular'];
$telefono = "";
if ($telefono != 0 && $celular == 0) {
    $telefonos = $telefono;
} else if ($celular != 0 && $telefono == 0) {
    $telefonos = $celular;
} else if ($telefono != 0 && $celular != 0) {
    $telefonos = $telefono . ',' . $celular;
}
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

<!--        <script type="text/javascript" >
            $(document).ready(function() {
                $('#imprimir').click(function() {
                    var url = '../reportes/planilla_representante.php?cedula=' + $('#cedula').val();
                    window.open(url);
                });
            });
        </script>-->
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
                            Numero Registro:
                            <?php echo $resultado[0]['num_registro'] ?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            C&eacute;dula:
                            <?php echo ucwords($resultado[0]['cedula']) ?>
                            &nbsp;&nbsp;
                            Nombres:
                            <?php echo ucwords($resultado[0]['nombres']) ?>
                        </legend>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td height="30" align="center">
                    <table width="97%" border="0" align="center" style="width:100%">
                        <tr>
                            <th width="58" height="41">Sexo:</th>
                            <td width="223"><?php echo $resultado[0]['sexo'] ?></td>
                            <th width="137" height="37"> Telefonos:</th>
                            <td width="336"><?php echo $telefono ?></td>                            
                        </tr>
                        <tr>
                            <th width="137" height="41">Fecha Actual:</th>
                            <td><?php echo $resultado[0]['fecha_actual'] ?></td>
<!--                            <th height="41">Edad:</th>
                            <td><?php echo $resultado[0]['edad'] ?></td>-->
                        </tr>
<!--                        <tr>
                            <th height="41">Lugar Nac:</th>
                            <td height="41" colspan="3"><?php echo $resultado[0]['lugar_naci'] ?></td>
                        </tr>
                        <tr>
                            <th height="41">Direcci&oacute;n: </th>
                            <td height="41" colspan="3"><?php echo $resultado[0]['direccion'] ?></td>
                        </tr>
                        <tr>
                            <th height="41">Estado:</th>
                            <td height="41" colspan="3"><?php echo $resultado[0]['nombre_estado'] ?></td>
                        </tr>
                        <tr>
                            <th height="41">Municipio:</th>
                            <td height="41" colspan="3"><?php echo $resultado[0]['nombre_municipio'] ?></td>
                        </tr>
                        <tr>
                            <th height="41">Parroquia:</th>
                            <td height="41" colspan="3"><?php echo $resultado[0]['nombre_parroquia'] ?></td>
                        </tr>-->
                    </table>
                </td>
            </tr>
            <tr>
                <td height="24" align="center">
                    <input type="hidden" name="cedula" id="cedula" value="<?php echo $cedula ?>" />
<!--                    <button type="button" id="imprimir" class="btn btn-default btn-sm" style="color:#2781D5" >Imprimir Planilla</button>-->
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