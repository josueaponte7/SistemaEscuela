<?php
$cedula       = $_GET['cedula'];

require_once '../../modelo/Estudiante.php';

$obj_estu  = new Estudiante();

$datos_es['sql'] = "SELECT
                        CONCAT_WS('-', (SELECT nombre FROM nacionalidad WHERE id_nacionalidad= e.nacionalidad),e.cedula) AS cedula,
                        CONCAT_WS(' ',e.nombre,e.apellido) AS nombres,
                        CONCAT_WS(' / ',
                        CONCAT_WS('-',(SELECT codigo FROM codigo_telefono  WHERE id=e.cod_telefono),e.telefono),
                        CONCAT_WS('-',(SELECT codigo FROM codigo_telefono  WHERE id=e.cod_celular),e.celular)) AS telefonos,
                        DATE_FORMAT(e.fech_naci,'%d-%m-%Y') AS fecha,
                        CURDATE(), (YEAR(CURDATE())-YEAR(e.fech_naci)) - (RIGHT(CURDATE(),5)<RIGHT(e.fech_naci,5)) AS edad,
                        e.email,
                        e.lugar_naci,
                        CONCAT_WS(' ',CONCAT('Calle ',e.calle),CONCAT('Nº ',e.casa),
                        IF(e.edificio = 'no','',e.edificio),
                        e.barrio) AS direccion,
                        p.nombre_parroquia,
                        m.nombre_municipio,
                        es.nombre_estado
                    FROM estudiante AS e
                    INNER JOIN parroquia AS p ON(e.id_parroquia=p.id_parroquia)
                    INNER JOIN municipio AS m ON(p.id_municipio=m.id_municipio)
                    INNER JOIN estado AS es ON(m.id_estado=es.id_estado)
                    WHERE e.cedula = $cedula";

$alumno = $obj_estu->datos($datos_es);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>jQuery Modal Contact Demo</title>
        <meta name="author" content="Jake Rocheleau">
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
  
        <script type="text/javascript" >
            $(document).ready(function() {
                
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
                            <?php echo $alumno[0]['cedula']?>
                            &nbsp;&nbsp;
                            <?php echo ucwords($alumno[0]['nombres'])?>
                        </legend>
                    </fieldset>
                </td>
            </tr>
            <tr>
              <td height="30" align="center">
              <table width="97%" border="0" align="center" style="width:100%">
                <tr>
                  <th width="137" height="37"> Telefonos:</th>
                  <td width="336"><?php echo $alumno[0]['telefonos']?></td>
                  <th width="58" height="41">Correo:</th>
                  <td width="223"><?php echo $alumno[0]['email']?></td>
                </tr>
                <tr>
                  <th height="41">F.Nacimiento:</th>
                  <td><?php echo $alumno[0]['fecha']?></td>
                  <th height="41">Edad:</th>
                  <td><?php echo $alumno[0]['edad']?></td>
                </tr>
                <tr>
                  <th height="41">Lugar Nac:</th>
                  <td height="41" colspan="3"><?php echo $alumno[0]['lugar_naci']?></td>
                </tr>
                <tr>
                  <th height="41">Direcci&oacute;n: </th>
                  <td height="41" colspan="3"><?php echo $alumno[0]['direccion']?></td>
                </tr>
                <tr>
                  <th height="41">Estado:</th>
                  <td height="41" colspan="3"><?php echo $alumno[0]['nombre_estado']?></td>
                </tr>
                <tr>
                  <th height="41">Municipio:</th>
                  <td height="41" colspan="3"><?php echo $alumno[0]['nombre_municipio']?></td>
                </tr>
                <tr>
                  <th height="41">Parroquia:</th>
                  <td height="41" colspan="3"><?php echo $alumno[0]['nombre_parroquia']?></td>
                </tr>
                </table>
              </td>
          </tr>
            <tr>
                <td height="24" align="center">&nbsp;</td>
            </tr>
        </table>
    </body>
</html>