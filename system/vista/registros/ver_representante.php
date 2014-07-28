<?php
$cedula    = substr($_GET['cedula'],2);
require_once '../../modelo/Representante.php';
require_once '../../modelo/Estudiante.php';
$obj_repre = new Representante();
$obj_estu  = new Estudiante();

$datos_es['campos']    = "CONCAT_WS(' ',nombre,apellido) AS nombres";
$datos_es['condicion'] = "cedula=$cedula";
$nombres               = $obj_estu->datos($datos_es);
$nombre                = $nombres[0]['nombres'];
$datos_re['sql'] = "SELECT 
                    r.cedula, 
                    CONCAT_WS(' ',r.nombre,r.apellido) AS nombres,
                    IF(cod_telefono='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_telefono),telefono)) AS telefono, 
                    IF(cod_celular='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_celular),celular)) AS celular,
                    e_r.parentesco,
                    e_r.representante
                 FROM estudiante_representante AS e_r
                 INNER JOIN representante AS r ON(e_r.cedula_representante=r.cedula)
                 WHERE e_r.cedula_estudiante=$cedula
                 ORDER BY e_r.representante DESC";

$resultado = $obj_repre->getRepresentantes($datos_re);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>jQuery Modal Contact Demo</title>
        <meta name="author" content="Jake Rocheleau">
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/jquery-ui.css" rel="stylesheet" media="screen"/>
        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/jquery-ui.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/jquery-ui.js"></script>
        <style type="text/css">
            .repre:hover{
                cursor: move;
            }
        </style>
        <script type="text/javascript" >
            $(document).ready(function() {
                var TReporterepre = $('#tbl_representantes').dataTable({
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bInfo": false,
                    "bFilter": false,
                    "bSearchable": false,
                    "bSort": false,
                    "bStateSave": true,
                    "bAutoWidth": false,
                    "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
                    "aoColumns": [
                        {"sClass": "center"},
                        {"sClass": "center"},
                        {"sClass": "center"},
                        {"sClass": "center"},
                        {"sClass": "center"}
                    ]
                });

                $(".repre").draggable({
                    axis: "y",
                    cursor: "move",
                    containment: $(this).closest("tr").children('td:eq(4)')
                });

                $("#tbl_representantes tbody tr td").droppable({
                    drop: function(event, ui) {
                        var fila = $(this).closest("tr").index();
                        $('#fila').remove();
                        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                        $($fila).prependTo($(this));
                    }

                });

                $('#actu_repres').on('click', function() {
                    var cedula_old = $('#representane_l').val();
                    var fila = $('#fila').val();
                    var cedula_new = $("#tbl_representantes tbody tr:eq(" + fila + ")").find("td:eq(0)").text();
                    var cedula_alum = $('#ced_alum').val();
                    if (cedula_new != "") {
                        if (cedula_old != cedula_new) {
                            $.post("../../controlador/Estudiante.php", {cedula: cedula_alum,cedula_representante: cedula_new, accion: 'UpRepre'}, function(respuesta) {
                                if (respuesta == 1) {
                                    var nombre = $("#tbl_representantes tbody tr:eq(" + fila + ")").find("td:eq(1)").text();
                                    var $iframe = window.parent.frames[0].$('body');
                                    var fil_old = $iframe.find('table#tabla_estudiante tbody tr input#fil').val();
                                    $iframe.find('table#tabla_estudiante tbody tr:eq(' + fil_old + ')').find("td:eq(4)").find('span').text(nombre);
                                    $iframe.find('table#tabla_estudiante tbody tr:eq(' + fil_old + ')').find("td:eq(4)").find('span').attr('id',cedula_new);
                                    
                                    window.parent.$.fancybox.close();
                                    window.parent.bootbox.alert("Modificación con Exito", function() {});
                                    
                                }

                            });
                        }
                    }
                    
                });
            });

        </script>
    </head>
    <body>
        <div style="width: 800px !important;">
            <table border="0" align="center">
                <tr>
                    <td width="340">
                        <fieldset>
                            <legend>Estudiante:
                                <input type="hidden" name="ced_alum" value="<?php echo $cedula; ?>" id="ced_alum"/>
                                <span style="color: #FF0000"><?php echo ucwords($nombre) ?></span>
                            </legend>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <table style="width: 700px !important" class="dataTable" border="0" align="center" id="tbl_representantes">
                            <thead>
                                <tr>
                                    <th>Cedula</th>
                                    <th>Nombre</th>
                                    <th>T&eacute;lefono</th>
                                    <th>Parentesco</th>
                                    <th style="width: 30% important">Representante</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < count($resultado); $i++) {
                                        $telefono = $resultado[$i]['telefono'];
                                        $celular  = $resultado[$i]['celular'];

                                        if($telefono != 0 && $celular == 0){
                                            $telefonos =$telefono;
                                        }else if($celular != 0 && $telefono == 0){
                                            $telefonos = $celular;
                                        }else if($telefono != 0 && $celular != 0){
                                            $telefonos = $telefono.','.$celular;
                                        }
                                        
                                        switch ($resultado[$i]['parentesco']) {
                                            case 1:
                                                $parentesco = 'Madre';
                                                break;
                                            case 2:
                                                $parentesco = 'Padre';
                                                break;
                                            case 3:
                                                $parentesco = 'Abuela';
                                                break;
                                            case 4:
                                                $parentesco = 'Abuelo';
                                                break;
                                            case 5:
                                                $parentesco = 'Tia';
                                                break;
                                            case 6:
                                                $parentesco = 'Tio';
                                                break;
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo $resultado[$i]['cedula'] ?></td>
                                        <td><?php echo $resultado[$i]['nombres'] ?></td>
                                        <td><?php echo $telefonos ?></td>
                                        <td><?php echo $parentesco; ?></td>
                                        <td id="<?php echo $resultado[$i]['cedula'] ?>">
                                            <?php
                                            if ($resultado[$i]['representante'] == 1) {
                                                ?>
                                                <input type="hidden" name="representane_l" id="representane_l" value="<?php echo $resultado[$i]['cedula'] ?>" />
                                                <div class="repre">
                                                    <img src="../../imagenes/tablas/check.png" width="16" height="13" alt="check"/>
                                                </div>
                                            <?php } else {
                                                ?>
                                                <div class="repre">

                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <div class="form-group" >
                            <button type="button" id="actu_repres" class="btn btn-success">Actualizar el Representante</button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>