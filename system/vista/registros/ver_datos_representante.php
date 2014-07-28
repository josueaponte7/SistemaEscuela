<?php
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/Seguridad.php';
require_once '../../modelo/Representante.php';


$obj_parro = new Parroquia();
$obj_repre = new Seguridad();
$obj_rep   = new Representante();

$campos['condicion'] = 1;
$cedula_condicion    = 're.cedula';

if (!isset($_GET['cedula'])) {
    
}
$cedula        = $_GET['cedula'];
$campos['sql'] = "SELECT 
                    CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = re.nacionalidad),re.cedula) AS cedula,
                    CONCAT_WS(' ',re.nombre,re.apellido) AS nombres,
                    re.email,
                    DATE_FORMAT(re.fech_naci,'%d-%m-%Y') AS fech_naci,
                    (YEAR(CURDATE())-YEAR(re.fech_naci))-(RIGHT(CURDATE(),5)<RIGHT(re.fech_naci,5)) AS edad,
                    re.lugar_naci,
                    IF(cod_telefono='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_telefono),telefono)) AS telefono, 
                    IF(cod_celular='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_celular),celular)) AS celular,
                    e.nombre_estado,
                    m.nombre_municipio,
                    p.nombre_parroquia,
                    CONCAT_WS(' ',CONCAT('Calle ',re.calle),CONCAT('Casa o Apto n&deg;' ,re.casa),IF(re.edificio!=NULL,CONCAT('Edificio',re.edificio),''),CONCAT('Barrio ',re.barrio)) AS direccion
                   FROM representante re
                   INNER JOIN parroquia AS p ON re.id_parroquia=p.id_parroquia
                   INNER JOIN municipio AS m ON p.id_municipio=m.id_municipio
                   INNER JOIN estado AS e ON m.id_estado=e.id_estado
                   WHERE re.cedula=" . $cedula;



/* $fp=fopen("archivo.txt","w+");
  fwrite($fp,$campos['sql']);
  fclose($fp) ; */

$resultado = $obj_rep->getRepresentantes($campos);

$telefono = $resultado[0]['telefono'];
$celular  = $resultado[0]['celular'];

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

        <script type="text/javascript" >
            $(document).ready(function() {
                $('#imprimir').click(function() {
                    var url = '../reportes/planilla_representante.php?cedula=' + $('#cedula').val();
                    window.open(url);
                });
            });
        </script>
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
                            <?php echo ucwords($resultado[0]['nombres']) ?>
                        </legend>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td height="30" align="center">
                    <table width="97%" border="0" align="center" style="width:100%">
                        <tr>
                            <th width="137" height="37"> Telefonos:</th>
                            <td width="336"><?php echo $telefonos ?></td>
                            <th width="58" height="41">Correo:</th>
                            <td width="223"><?php echo $resultado[0]['email'] ?></td>
                        </tr>
                        <tr>
                            <th height="41">F.Nacimiento:</th>
                            <td><?php echo $resultado[0]['fech_naci'] ?></td>
                            <th height="41">Edad:</th>
                            <td><?php echo $resultado[0]['edad'] ?></td>
                        </tr>
                        <tr>
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
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="24" align="center">
                    <input type="hidden" name="cedula" id="cedula" value="<?php echo $cedula ?>" />
                    <button type="button" id="imprimir" class="btn btn-default btn-sm" style="color:#2781D5" >Imprimir Planilla</button>
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