<?php
date_default_timezone_set('America/Caracas');
session_start();
require_once '../../modelo/Inscripcion.php';
require_once '../../modelo/DatosGenerales.php';
require_once '../../modelo/AnioEscolar.php';
require_once '../../modelo/Representante.php';
$obj_inscrip = new Inscripcion();
$obj_misi    = new DatosGenerales();
$obj_anioes  = new AnioEscolar();
$obj_datos   = new Representante();

$_SESSION['menu']        = 'reportes_constanciainscripcion';
$_SESSION['dir_sys']     = 'reportes';
$_SESSION['archivo_sys'] = 'constanciainscripcion';
$_SESSION['abrir']       = 'reportes';

if (isset($_GET['id']) && $_GET['id'] == 1) {
    $_SESSION['v_registro'] = 'none';
    $_SESSION['v_table']    = 'block';
    $v_registro = 'none';
    $v_table    = 'block';
}else if (isset($_SESSION['v_registro']) && isset($_SESSION['v_table'])) {
    $v_registro = $_SESSION['v_registro'];
    $v_table    = $_SESSION['v_table'];
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Inscripcion</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>
        <link href="../../../librerias/css/jquery.toastmessage.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/select2.css" rel="stylesheet" type="text/css"/>
        <link href="../../librerias/css/select2-bootstrap.css" rel="stylesheet" type="text/css"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.tooltip.js"></script>
        <script type="text/javascript" src="../../librerias/js/formToWizard.js"></script>
        <script type="text/javascript" src="../../../librerias/js/jquery.toastmessage.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/js/tab.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/script/reporte_inscripcion.js"></script>
        
    </head>
    <body>  
        <div id="reporte_inscripcion" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Estudiante
                </legend>
            </fieldset>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_inscripcion" align="center" name="tabla_inscripcion">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">C&eacute;dula</th>
                            <th width="150">Estudiante</th>
                            <th width="150">Tipo</th>
                            <th width="150">A&ntilde;o</th>
                            <th width="150">Actividad</th>
                            <th width="150">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resul_insc              = $obj_inscrip->getInscritos();
                        $es_array                = is_array($resul_insc) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resul_insc); $i++) {
                                ?>
                                <tr class="letras">
                                    <td>
                                        <input type="checkbox" id="<?php echo $resul_insc[$i]['cedula']; ?>" name="cedula[]" value="<?php echo $resul_insc[$i]['cedula']; ?>" />
                                    </td>
                                    <td><?php echo $resul_insc[$i]['cedula'] ?></td>                         
                                    <td><?php echo $resul_insc[$i]['nombre']; ?></td>
                                    <td><?php echo $resul_insc[$i]['tipo'] ?></td>
                                    <td><?php echo $resul_insc[$i]['anio'] ?></td>
                                    <td><?php echo $resul_insc[$i]['actividad'] ?></td>
                                    <td><?php echo $resul_insc[$i]['fecha_inscripcion'] ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <button type="button" id="imprimir" class="btn btn-default btn-sm" style="margin-top:5%;margin-left: 25%;display: none;color:#2781D5" >Generar Constancia</button>
        </div>
    </body>
</html>

