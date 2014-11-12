<?php
date_default_timezone_set('America/Caracas');
session_start();
require_once '../../modelo/Inscripcion.php';
//require_once '../../modelo/DatosGenerales.php';
require_once '../../modelo/AnioEscolar.php';
require_once '../../modelo/Representante.php';

$obj_inscrip = new Inscripcion();
//$obj_misi    = new DatosGenerales();
$obj_anioes  = new AnioEscolar();
$obj_datos   = new Representante();

$_SESSION['menu']        = 'procesos_reinscripcion';
$_SESSION['dir_sys']     = 'procesos';
$_SESSION['archivo_sys'] = 'reinscripcion';
$_SESSION['height']      = '880px';
$_SESSION['heightifm']   = '830px';
$_SESSION['abrir']       = 'procesos';

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
        <title>Re-Inscripcion</title>
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
        <script type="text/javascript" src="../../librerias/script/reinscripcion.js"></script>

    </head>
    <body>  
        <div id="reporte_reinscripcion" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Re-Inscripci&oacute;n del Estudiante
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Re-Inscripci&oacute;n</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_reinscripcion" align="center" name="tabla_reinscripcion">
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
                                    <td><span class="sub-rayar tooltip_ced"><?php echo $resul_insc[$i]['cedula'] ?></span></td>                         
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
                </div>
            </div>

            <div id="registro_reinscripcion" style="display: none;">
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Datos de Re-Inscripci&oacute;n del Estudiante</div>
                    <div class="panel-body">
                        <form id="frmreinscripcion" name="frmreinscripcion">
                            <table width="711" border="0" align="center">

                                <tr>
                                    <td width="79" height="50" class="letras">Estudiante:</td>
                                    <td width="741"> 
                                        <select  name="cedula" class="form-control input-sm select2" id="cedula">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $datos              = array();
                                            $datos['campos']    = "CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = es.nacionalidad),es.cedula) AS cedula,CONCAT_WS(' ',CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = es.nacionalidad),es.cedula),es.nombre, es.apellido) AS datos";
                                            $datos['condicion'] = "id_estatus >= 2";
                                            $resul              = $obj_inscrip->datos($datos);
                                            $es_array           = is_array($resul) ? TRUE : FALSE;
                                            if ($es_array === TRUE) {
                                                for ($i = 0; $i < count($resul); $i++) {
                                                    ?>
                                                    <option value="<?php echo $resul[$i]['cedula']; ?>"><?php echo $resul[$i]['datos']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="59" colspan="2" align="center">
                                        <fieldset>
                                            <legend class="letras_label"> 
                                                Datos del Estudiante 
                                            </legend>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <table style="width:100%" border="0">
                                            <?php
                                            $hoy              = date("d-m-Y");
                                            $datos            = array();
                                            $datos['campos']  = 'id_anio,anio_escolar';
                                            $datos['ordenar'] = 'id_anio DESC';
                                            $datos['limite']  = '1';
                                            $resul            = $obj_anioes->getAnio($datos);
                                            $id_anio          = $resul[0]['id_anio'];
                                            $anio_escolar     = $resul[0]['anio_escolar'];
                                            ?>
                                            <tr>
                                                <td class="letras"> Fech Inscripci&oacute;n: </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input disabled="disabled"  type="text" class="form-control  input-sm" id="fecha" name="fecha" value="<?php echo $hoy; ?>" placeholder="Fecha Inscripci&oacute;n"/>
                                                    </div>
                                                </td>
                                                <td height="49" class="letras"> Tipo Estudiante: </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="hidden" id="id_tipo" name="id_tipo" value="" />
                                                        <input type="hidden" id="inscrito" name="inscrito" value="0" />
                                                        <input disabled="disabled" type="text" class="form-control  input-sm" id="tipo_estudiante" name="tipo_estudiante"  placeholder="Tipo de Estudiante"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="letras"> A&ntilde;o Escolar: </td>
                                                <td>
                                                    <div class="form-group">
                                                        <select name="anio_escolar" class="form-control input-sm select2" id="anio_escolar">
                                                            <option value="0">Seleccione</option>
                                                            <?php
                                                            $resultado        = $obj_inscrip->anioescolar();
                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                ?>
                                                                <option value="<?php echo $resultado[$i]['id_anio']; ?>"><?php echo $resultado[$i]['anio_escolar']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td width="93" class="letras"> Actividad: </td>
                                                <td width="229">
                                                    <div class="form-group">
                                                        <select name="actividad" class="form-control input-sm select2" id="actividad">
                                                            <option value="0">Seleccione</option>
                                                            <?php
                                                            $resultado        = $obj_inscrip->actividad();
                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                ?>
                                                                <option value="<?php echo $resultado[$i]['id_actividad']; ?>"><?php echo $resultado[$i]['actividad']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr height="60">
                                                <td height="68" class="letras">&Aacute;rea:</td>
                                                <td colspan="4">
                                                    <div id="div_actividad" class="form-group">
                                                        <textarea name="area" rows="2"  class="form-control input-sm"  id="area" placeholder="&Aacute;rea"></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>

                                            </tr>
                                        </table>
                                    </td>
                                </tr>                            
                                <tr>
                                    <td colspan="2" align="center">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div id="datos_repre">
                                            <table style="width:100%" border="0" align="center">
                                                <tr>
                                                    <td>
                                                        <fieldset>
                                                            <legend class="letras_label"> Datos de la Madre, Padre o Representante </legend>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table width="706">
                                                            <tr height="60">
                                                                <td width="83" class="letras"> C&eacute;dula: </td>
                                                                <td width="284">
                                                                    <div id="div_cedula_r"  class="form-group">
                                                                        <input type="text" class="form-control  input-sm" id="cedula_r" name="cedula_r" placeholder="Cédula del Representante"/>
                                                                    </div>
                                                                </td>
                                                                <td width="67" class="letras"> Nombres: </td>
                                                                <td width="252">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control input-sm" id="nombre_r" disabled="disabled" name="nombre_r" placeholder="Nombre" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr height="40">
                                                                <td class="letras"> Apellidos:</td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control input-sm" id="apellido_r" disabled="disabled" name="apellido_r" placeholder="Apellido" />
                                                                    </div>
                                                                </td>
                                                                <td class="letras"> Parentesco: </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control input-sm" id="parentesco" disabled="disabled" name="parentesco" placeholder="Parentesco" />
                                                                    </div>
<!--                                                                    <div class="form-group">
                                                                        <select name="parentesco" class="form-control input-sm select2 parentesco" id="parentesco">
                                                                            <option value="0">Seleccione</option>
                                                                            <option value="1">Madre</option>
                                                                            <option value="3">Abuela</option>
                                                                            <option value="5">Tia</option>
                                                                        </select>
                                                                    </div>-->
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <fieldset>
                                                            <legend class="letras_label"> Datos del Medio de Transporte</legend>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table width="706">
                                                            <tr height="60">
                                                                <td width="83" class="letras"> Tipo de Medio: </td>
                                                                <td>
                                                                    <select name="medio" class="form-control input-sm" id="medio">
                                                                        <option value="0">Seleccione</option>
                                                                        <option value="1">Solo</option>
                                                                        <option value="2">Acompa&ntilde;ado</option>
                                                                        <option value="3">Transporte Particular</option>
                                                                    </select>
                                                                </td>
                                                                <td width="67" class="letras"> C&eacute;dula: </td>
                                                                <td width="252">
                                                                    <div id="div_cedula_cho" class="form-group">
                                                                        <input type="text" style="width: 250px !important;" class="form-control input-sm" id="cedula_cho" name="cedula_cho" placeholder="Cédula"/>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr height="40">
                                                                <td class="letras"> Nombres:</td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control input-sm" id="nombre_cho" name="nombre_cho" placeholder="Nombres" />
                                                                    </div>
                                                                </td>
                                                                <td class="letras"> Apellidos: </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control input-sm" id="apellido_cho" name="apellido_cho" placeholder="Apellidos" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr height="40">
                                                                <td class="letras"> Placa: </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control input-sm" id="placa" name="placa" placeholder="Placa" />
                                                                    </div>
                                                                </td>
                                                                <td class="letras"> Tel&eacute;fonos: </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                        <input type="text" style="width: 250px !important;" class="form-control input-sm" id="telefono_cho" name="telefono_cho" placeholder="Teléfonos"/>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center">
                                                        <div id="botones">                                                        
                                                            <input type="hidden" name="accion" value="Re-Inscribir" id="accion"/>
                                                            <input type="hidden" name="dt" id="dt" value=""/>
                                                            <button type="button" id="guardar" class="btn btn-primary btn-sm">Re-Inscribir</button>
                                                            <button type="button" id="limpiar" class="btn btn-primary btn-sm">Limpiar</button>
                                                            <button type="button" id="salir" class="btn btn-primary btn-sm">Salir</button> 
                                                        </div>
                                                    </td>
                                                </tr>
                                                </form>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">&nbsp;</td>
                                </tr>                        
                            </table>
                        </form>
                    </div>
                </div>   
            </div>
    </body>
</html>

