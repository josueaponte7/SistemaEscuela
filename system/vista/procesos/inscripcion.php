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

$_SESSION['menu']        = 'procesos_inscripcion';
$_SESSION['dir_sys']     = 'procesos';
$_SESSION['archivo_sys'] = 'inscripcion';
$_SESSION['height']      = '1920px';
$_SESSION['heightifm']   = '1820px';
$_SESSION['abrir']       = 'procesos';
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
        <script type="text/javascript" src="../../librerias/js/formToWizard.js"></script>
        <script type="text/javascript" src="../../../librerias/js/jquery.toastmessage.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/js/tab.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/script/inscripcion.js"></script>
        <style>
            #steps { list-style:none; width:100%; overflow:hidden; margin:0px; padding:0px;}
            #steps li {font-size:24px; float:left; padding:10px; color:#b0b1b3;}
            #steps li span {font-size:13px; display:block;font-weight: bold; font-family: Arial,'OpenSans',Tahoma,Geneva,sans-serif}
            #steps li.current {color:#2781D5;}
            fieldset legend span.link:hover{
                color: #3276B1;
                cursor: pointer;
            }
            .activo{
                color: #3276B1;
            }

            .toast-item {
                font-size: 13px;
                width: 300px;
            }
        </style>
    </head>
    <body>  
        <div id="reporte_inscripcion" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Inscripci&oacute;n del Estudiante
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Inscripci&oacute;n</button>
            <br/>
            <br/>
            <br/>
            <br/>
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
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resul_insc = $obj_inscrip->getInscritos();
                        $es_array   = is_array($resul_insc) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resul_insc); $i++) {
                                ?>
                                <tr class="letras">
                                    <td>
                                        <input type="checkbox" id="<?php echo $resul_insc[$i]['cedula']; ?>" name="id_actividad[]" value="<?php echo $resul_insc[$i]['cedula']; ?>" />
                                    </td>
                                    <td><?php echo $resul_insc[$i]['cedula']; ?></td>                            
                                    <td><?php echo $resul_insc[$i]['nombre']; ?></td>
                                    <td><?php echo $resul_insc[$i]['tipo'] ?></td>
                                    <td><?php echo $resul_insc[$i]['anio'] ?></td>
                                    <td><?php echo $resul_insc[$i]['actividad'] ?></td>
                                    <td><?php echo $resul_insc[$i]['fecha_inscripcion'] ?></td>
                                    <td style="text-align: center">
                                        <img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>
                                    </td>
                                    <td style="text-align: center">
                                        <img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div id="registro_inscripcion" style="display: none">
            <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                <div class="panel-heading letras_titulos">Datos de Inscripci&oacute;n del Estudiante</div>
                <div class="panel-body">
                    <form id="frminscripcion" name="frminscripcion">
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
                                                    <input type="hidden" name="id_anio" value="<?php echo $id_anio; ?>" />
                                                    <input disabled="disabled" type="text" readonly class="form-control input-sm" id="anio_escolar" name="anio_escolar" value="<?php echo $anio_escolar ?>" placeholder="A&ntilde;o Escolar">
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
                                                                <div class="form-group">
                                                                    <input disabled="disabled" type="text" class="form-control  input-sm" id="cedula_r" name="cedula_r" placeholder="Cédula del Representante"/>
                                                                </div>
                                                            </td>
                                                            <td width="67" class="letras"> Nombres: </td>
                                                            <td width="252">
                                                                <div class="form-group">
                                                                    <input disabled="disabled"  type="text" class="form-control input-sm" id="nombre_r" name="nombre_r" placeholder="Nombre" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr height="40">
                                                            <td class="letras"> Apellidos:</td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input disabled="disabled" type="text" class="form-control input-sm" id="apellido_r" name="apellido_r" placeholder="Apellido" />
                                                                </div>
                                                            </td>
                                                            <td class="letras"> Parentesco: </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input disabled="disabled"  type="text" class="form-control input-sm" id="parentesco" name="parentesco" placeholder="Parentesco" />
                                                                </div>
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
                                                                    <input type="text" style="width: 250px !important;" disabled="disabled" class="form-control input-sm" id="cedula_cho" name="cedula_cho" placeholder="Cédula"/>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr height="40">
                                                            <td class="letras"> Nombres:</td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input disabled="disabled" type="text" class="form-control input-sm" id="nombre_cho" name="nombre_cho" placeholder="Nombres" />
                                                                </div>
                                                            </td>
                                                            <td class="letras"> Apellidos: </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input disabled="disabled" type="text" class="form-control input-sm" id="apellido_cho" name="apellido_cho" placeholder="Apellidos" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr height="40">
                                                            <td class="letras"> Placa: </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input disabled="disabled" type="text" class="form-control input-sm" id="placa" name="placa" placeholder="Placa" />
                                                                </div>
                                                            </td>
                                                            <td class="letras"> Tel&eacute;fonos: </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input disabled="disabled" type="text" style="width: 250px !important;" class="form-control input-sm" id="telefono_cho" name="telefono_cho" placeholder="Teléfonos"/>
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
                                                        <input type="hidden" name="accion" value="Inscribir" id="accion"/>
                                                        <input type="hidden" name="dt" id="dt" value=""/>
                                                        <!--<button type="button" id="guardar" class="btn btn-primary btn-sm">Inscribir</button>
                                                        <button type="button" id="limpiar" class="btn btn-primary btn-sm">Limpiar</button>
                                                        <button type="button" id="salir" class="btn btn-primary btn-sm">Salir</button>--> 
                                                    </div>
                                                </td>
                                            </tr>
                                            </form>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <fieldset id="fil_datos_genereles" style="display: none">
                                        <legend class="letras_label">
                                            <span id="cdt_generales"  class="link">Cargar Datos Generales</span> 
                                            <span id="rest_generales" class="link" style="float: right;display: none">Restablecer</span>
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <table width="706">
                                        <tr>
                                            <td>
                                                <div id="main" style="display:none">
                                                    <div id="SignupForm">
                                                        <!-- Inicio Datos Misiones -->
                                                        <fieldset id="pa_ma_rep" class="paso">
                                                            <legend class="letras_titulosGe">Padre, Madre o Representante</legend>
                                                            <table border="0">
                                                                <tr>
                                                                    <td height="50">
                                                                        <table style="width:100%" border="0">
                                                                            <tr>
                                                                                <th height="39" class="letras">Fallecido</th>
                                                                                <td class="letras">
                                                                                    <input type="checkbox" name="dt_padres[padre_f]" id="padre_f" value="1">
                                                                                    <label>Padre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[madre_f]" id="madre_f" value="2">
                                                                                    <label>Madre </label>
                                                                                </td>
                                                                                <th class="letras">Privados de Libertad</th>
                                                                                <td class="letras">
                                                                                    <input type="checkbox" name="dt_padres[padre_pl]" id="padre_pl" value="1">
                                                                                    <label>Padre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[madre_pl]" id="madre_pl" value="2">
                                                                                    <label>Madre </label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th height="37" class="letras">Alcoh&oacute;licos</th>
                                                                                <td class="letras">
                                                                                    <input type="checkbox" name="dt_padres[padre_al]" id="padre_al" value="1">
                                                                                    <label>Padre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[madre_al]" id="madre_al" value="2">
                                                                                    <label>Madre </label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[represent_al]" id="represent_al" value="3">
                                                                                    <label>Representante</label>
                                                                                </td>
                                                                                <th class="letras">F&aacute;rmaco Dependiente</th>
                                                                                <td class="letras">
                                                                                    <input type="checkbox" name="dt_padres[padre_fd]" id="padre_fd" value="1">
                                                                                    <label>Padre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[madre_fd]" id="madre_fd" value="2">
                                                                                    <label>Madre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[represent_fd]" id="represent_fd" value="3">
                                                                                    <label>Representante</label>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>

                                                                        <fieldset>
                                                                            <legend class="letras_titulosGe">Estudios</legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="55">
                                                                        <table style="width:100%" border="0">
                                                                            <tr>
                                                                                <th  class="letras">Alfabetizados</th>
                                                                                <td  class="letras">
                                                                                    <input type="checkbox" name="dt_padres[padre_alf]" id="padre_alf" value="si">
                                                                                    <label>Padre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[madre_alf]" id="madre_alf" value="si">
                                                                                    <label>Madre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[represent_alf]" id="represent_alf" value="si">
                                                                                    <label>Representante</label>
                                                                                </td>
                                                                                <th height="34" class="letras">Analfabeta</th>
                                                                                <td height="34" class="letras">
                                                                                    <input type="checkbox" name="dt_padres[padre_alf]" id="padre_anl" value="no">
                                                                                    <label>Padre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[madre_alf]" id="madre_anl" value="no">
                                                                                    <label>Madre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[represent_alf]" id="represent_anl" value="no">
                                                                                    <label>Representante</label>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <fieldset>
                                                                            <legend class="letras_titulosGe">Nivel Instruci&oacute;n </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="74">
                                                                        <table width="691" border="0" align="center">
                                                                            <tr>
                                                                                <th height="54" class="letras">Padre: </th>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <select style="width: 130px;" name="dt_padres[padre_nivel]" class="form-control input-sm" id="padre_nivel">
                                                                                            <option value="0">Seleccione</option>
                                                                                            <?php
                                                                                            $resultado = $obj_datos->nivelInst();
                                                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                                                ?>
                                                                                                <option value="<?php echo $resultado[$i]['id_nivel']; ?>"><?php echo $resultado[$i]['nombre_nivel']; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <th class="letras">Madre: </th>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <select style="width: 130px;" name="dt_padres[madre_nivel]" class="form-control input-sm" id="madre_nivel">
                                                                                            <option value="0">Seleccione</option>
                                                                                            <?php
                                                                                            $resultado = $obj_datos->nivelInst();
                                                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                                                ?>
                                                                                                <option value="<?php echo $resultado[$i]['id_nivel']; ?>"><?php echo $resultado[$i]['nombre_nivel']; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <th class="letras">Representante: </th>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <select style="width: 130px;" name="dt_padres[represent_nivel]" class="form-control input-sm" id="represent_nivel">
                                                                                            <option value="0">Seleccione</option>
                                                                                            <?php
                                                                                            $resultado = $obj_datos->nivelInst();
                                                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                                                ?>
                                                                                                <option value="<?php echo $resultado[$i]['id_nivel']; ?>"><?php echo $resultado[$i]['nombre_nivel']; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <fieldset>
                                                                            <legend class="letras_titulosGe">Situaci&oacute;n Econ&oacute;mica </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table style="width:100%" border="0">
                                                                            <tr>
                                                                                <th height="39" class="letras">Trabajan</th>
                                                                                <td class="letras">
                                                                                    <input type="checkbox" name="dt_padres[padre_set]" id="padre_set" value="1">
                                                                                    <label>Padre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[madre_set]" id="madre_set" value="2">
                                                                                    <label>Madre</label>
                                                                                </td>
                                                                                <th class="letras">Estudiantes</th>
                                                                                <td class="letras">
                                                                                    <input type="checkbox" name="dt_padres[padre_see]" id="padre_see" value="1">
                                                                                    <label>Padre</label>
                                                                                    &nbsp;&nbsp;
                                                                                    <input type="checkbox" name="dt_padres[madre_see]" id="madre_see" value="2">
                                                                                    <label>Madre</label>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="84">
                                                                        <fieldset>
                                                                            <legend class="letras_titulosGe" >Concepto de Ingreso  Familiar </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="letras">
                                                                        <div class="form-inline" style="margin-top: -40px;">
                                                                            <?php
                                                                            $resul_naci = $obj_misi->concepIngreso();
                                                                            for ($i = 0; $i < count($resul_naci); $i++) {
                                                                                $tipo_ingreso = $resul_naci[$i]['tipo_ingreso'];
                                                                                if (($i % 6) == 0) {
                                                                                    echo '<br/>';
                                                                                }
                                                                                ?>
                                                                                <div class="form-group" >
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input  type="checkbox" name="id_ingreso[]" value="<?php echo $resul_naci[$i]['id_ingreso']; ?>" />
                                                                                            <?php echo $tipo_ingreso; ?>
                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>  
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="688" align="center">&nbsp;
                                                                        <input type="hidden" name="paso1" id="paso1" value="0" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                        <!-- Fin Datos Padre Madre Representante -->

                                                        <!-- Inicio Datos Misiones -->
                                                        <fieldset class="paso">
                                                            <legend class="letras_titulosGe">Misiones</legend>
                                                            <table style="width:100%">
                                                                <tr>
                                                                    <td height="102">
                                                                        <fieldset >
                                                                            <legend class="letras_titulosGe" >Misiones por la que ha sido beneficiada la familia </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="letras">
                                                                        <div class="form-inline" style="margin-top: -80px;">
                                                                            <?php
                                                                            $resul_naci = $obj_misi->misiones();
                                                                            for ($i = 0; $i < count($resul_naci); $i++) {
                                                                                $nombre_programa = $resul_naci[$i]['nombre_programa'];
                                                                                ;
                                                                                if (($i % 5) == 0) {
                                                                                    echo '<br/><br/><br/><br/>';
                                                                                }
                                                                                ?>
                                                                                <div class="form-group" >
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input  type="checkbox" name="mision[]" value="<?php echo $resul_naci[$i]['id_programa']; ?>" /><?php echo $nombre_programa; ?>
                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>  
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center">
                                                                        <input type="hidden" name="paso2" id="paso2" value="0" />
                                                                        &nbsp;
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>


                                                        <!-- Fin Datos Misiones -->

                                                        <!-- Inicio Datos Vivienda -->

                                                        <fieldset class="paso">
                                                            <legend class="letras_titulosGe">Vivienda</legend>
                                                            <table align="center" style="width:100%">
                                                                <tr>
                                                                    <td>
                                                                        <fieldset>
                                                                            <legend class="letras_titulosGe">Ubicaci&oacute;n y Tipo de Vivienda </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="81">
                                                                        <table width="691" border="0" align="center">
                                                                            <tr>
                                                                                <th width="123" class="letras">Ubicaci&oacute;n: </th>
                                                                                <td width="191">
                                                                                    <div class="form-group">
                                                                                        <select style="width: 130px;" name="ubicacion_vivienda" class="form-control input-sm" id="ubicacion_vivienda">
                                                                                            <option value="0">Seleccione</option>
                                                                                            <?php
                                                                                            $resultado = $obj_misi->ubicacion();
                                                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                                                ?>
                                                                                                <option value="<?php echo $resultado[$i]['id_ubicacion']; ?>"><?php echo $resultado[$i]['ubicacion']; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <th width="163" class="letras">Tipo de Vivienda: </th>
                                                                                <td width="196">
                                                                                    <div class="form-group">
                                                                                        <select style="width: 130px !important;" name="tipo_vivienda" class="form-control input-sm" id="tipo_vivienda">
                                                                                            <option value="0">Seleccione</option>
                                                                                            <?php
                                                                                            $resultado = $obj_misi->tipoVivienda();
                                                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                                                ?>
                                                                                                <option value="<?php echo $resultado[$i]['id_tipo']; ?>"><?php echo $resultado[$i]['tipo_vivienda']; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <fieldset >
                                                                            <legend class="letras_titulosGe" >Estado y Total de Habitaciones de la Viviendad</legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="76">
                                                                        <table width="691" border="0" align="center">
                                                                            <tr>
                                                                                <th width="122" class="letras">Estado de la Vivienda: </th>
                                                                                <td width="183">
                                                                                    <div class="form-group">
                                                                                        <select style="width: 130px;" name="estado_vivienda" class="form-control input-sm" id="estado_vivienda">
                                                                                            <option value="0">Seleccione</option>
                                                                                            <?php
                                                                                            $resultado = $obj_misi->estadoVivienda();
                                                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                                                ?>
                                                                                                <option value="<?php echo $resultado[$i]['id_estado']; ?>"><?php echo $resultado[$i]['estado_vivienda']; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <th width="179" class="letras">Total de Hab de la Vivienda: </th>
                                                                                <td width="189">
                                                                                    <div class="form-group">
                                                                                        <input style="width: 130px !important;" type="text" class="form-control  input-sm" id="cant_habitacion" name="cant_habitacion" placeholder="Total Habitaci&oacute;n" maxlength="2"/>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <fieldset>
                                                                            <legend class="letras_titulosGe" >Tipo de Cama</legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="88">
                                                                        <table style="width:100%" border="0">
                                                                            <tr>
                                                                                <th width="19%" class="letras">Cama donde duerme:</th>
                                                                                <td width="81%">
                                                                                    <div class="form-group">
                                                                                        <select style="width: 130px;" name="cama" class="form-control input-sm" id="cama">
                                                                                            <option value="0">Seleccione</option>
                                                                                            <?php
                                                                                            $resultado = $obj_misi->cama();
                                                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                                                ?>
                                                                                                <option value="<?php echo $resultado[$i]['id_cama']; ?>"><?php echo $resultado[$i]['cama']; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div></td>
                                                                            </tr>
                                                                        </table></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <fieldset>
                                                                            <legend class="letras_titulosGe" >Acceso al Desarrollo Tecnol&oacute;gico</legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="letras">
                                                                        <div class="form-inline" style="margin-top: -80px;">
                                                                            <?php
                                                                            $resul_naci = $obj_misi->tecnologia();
                                                                            for ($i = 0; $i < count($resul_naci); $i++) {
                                                                                $nombre_tecnologia = $resul_naci[$i]['nombre_tecnologia'];
                                                                                if (($i % 6) == 0) {
                                                                                    echo '<br/><br/><br/><br/>';
                                                                                }
                                                                                ?>
                                                                                <div class="form-group" >
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input  type="checkbox" name="tecnologia[]" value="<?php echo $resul_naci[$i]['id_tecnologia']; ?>" />
                                                                                            <?php echo $nombre_tecnologia; ?>
                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>  
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="paso3" id="paso3" value="0" />
                                                                        &nbsp;
                                                                    </td>
                                                                </tr>
                                                            </table>


                                                            <!-- Fin Datos Vivienda -->

                                                            <!-- Inicio Datos Diversidad Funcional -->

                                                        </fieldset>
                                                        <fieldset class="paso">
                                                            <legend class="letras_titulosGe">Diversidad Funcional</legend>
                                                            <table style="width:100%">
                                                                <tr>
                                                                    <td height="64">
                                                                        <fieldset >
                                                                            <legend class="letras_titulosGe" >Tipo de Diversidad Funcional </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="83" class="letras">
                                                                        <div class="form-inline" style="margin-top: -80px;">
                                                                            <?php
                                                                            $resul_naci = $obj_misi->diversidad();
                                                                            for ($i = 0; $i < count($resul_naci); $i++) {
                                                                                $tipo_diversidad = $resul_naci[$i]['tipo_diversidad'];
                                                                                if (($i % 4) == 0) {
                                                                                    echo '<br/><br/><br/>';
                                                                                }
                                                                                ?>
                                                                                <div class="form-group" >
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input  type="checkbox" name="diversidad[]" value="<?php echo $resul_naci[$i]['id_diversidad']; ?>" />
                                                                                            &nbsp;&nbsp;<?php echo $tipo_diversidad; ?>
                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>  
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="72">
                                                                        <fieldset >
                                                                            <legend class="letras_titulosGe" >Enfermedades que padese el ni&ntilde;o(a) </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="89" class="letras"> 
                                                                        <div class="form-inline" style="margin-top: -80px;">
                                                                            <?php
                                                                            $resul_naci = $obj_misi->enfermedad();
                                                                            for ($i = 0; $i < count($resul_naci); $i++) {
                                                                                $enfermedad = $resul_naci[$i]['enfermedad'];
                                                                                if (($i % 5) == 0) {
                                                                                    echo '<br/><br/><br/>';
                                                                                }
                                                                                ?>
                                                                                <div class="form-group" >
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input  type="checkbox" name="enfermedad[]" value="<?php echo $resul_naci[$i]['id_enfermedad']; ?>" />
                                                                                            <?php echo $enfermedad; ?>
                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>  
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> 
                                                                        <fieldset >
                                                                            <legend class="letras_titulosGe" >Servivion P&uacute;blico al que es atendido </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="63" class="letras">
                                                                        <div class="form-inline" style="margin-top: -80px;">
                                                                            <?php
                                                                            $resul_naci = $obj_misi->servicio();
                                                                            for ($i = 0; $i < count($resul_naci); $i++) {
                                                                                $tiposervicio = $resul_naci[$i]['tiposervicio'];
                                                                                if (($i % 5) == 0) {
                                                                                    echo '<br/><br/><br/>';
                                                                                }
                                                                                ?>
                                                                                <div class="form-group" >
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input  type="checkbox" name="servicio[]" value="<?php echo $resul_naci[$i]['id_tiposervicio']; ?>" />
                                                                                            <?php echo $tiposervicio; ?>
                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>  
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="54">
                                                                        <fieldset >
                                                                            <legend class="letras_titulosGe" >Destrezas, Habilidades y Preferencias del Adolescente o Joven </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="75" class="letras">
                                                                        <div class="form-inline" style="margin-top: -80px;">
                                                                            <?php
                                                                            $resul_naci = $obj_misi->destreza();
                                                                            for ($i = 0; $i < count($resul_naci); $i++) {
                                                                                $tipo_destreza = $resul_naci[$i]['tipo_destreza'];
                                                                                if (($i % 6) == 0) {
                                                                                    echo '<br/><br/><br/>';
                                                                                }
                                                                                ?>
                                                                                <div class="form-group" >
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input  type="checkbox" name="destreza[]" value="<?php echo $resul_naci[$i]['id_destreza']; ?>" />
                                                                                            <?php echo $tipo_destreza; ?>
                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>  
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="45">
                                                                        <fieldset>
                                                                            <legend class="letras_titulosGe">Alimentaci&oacute;n </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="79">
                                                                        <table width="691" border="0" align="center">
                                                                            <tr>
                                                                                <td width="132" height="47" class="letras">Acceso a la Alimentaci&oacute;n: </td>
                                                                                <td width="201">
                                                                                    <div class="form-group">
                                                                                        <select style="width: 140px;" name="alimentacion" class="form-control input-sm" id="alimentacion">
                                                                                            <option value="0">Seleccione</option>
                                                                                            <?php
                                                                                            $resultado = $obj_misi->accesoAlim();
                                                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                                                ?>
                                                                                                <option value="<?php echo $resultado[$i]['id_acceso']; ?>"><?php echo $resultado[$i]['tipo_acceso']; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                                <td width="144" class="letras">Alimentaci&oacute;n Regularmente: </td>
                                                                                <td width="196">
                                                                                    <div class="form-group">
                                                                                        <select style="width: 140px;" name="alimentacion_regular" class="form-control input-sm" id="alimentacion_regular">
                                                                                            <option value="0">Seleccione</option>
                                                                                            <?php
                                                                                            $resultado = $obj_misi->alimRegular();
                                                                                            for ($i = 0; $i < count($resultado); $i++) {
                                                                                                ?>
                                                                                                <option value="<?php echo $resultado[$i]['id_regular']; ?>"><?php echo $resultado[$i]['tipo_regular']; ?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="107">
                                                                        <fieldset >
                                                                            <legend class="letras_titulosGe" >¿Amerita ser Ayudado al Momento de? </legend>
                                                                        </fieldset>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="letras">
                                                                        <div class="form-inline" style="margin-top: -80px;">
                                                                            <?php
                                                                            $resul_naci = $obj_misi->ameritaAyu();
                                                                            for ($i = 0; $i < count($resul_naci); $i++) {
                                                                                $tipo_ayuda = $resul_naci[$i]['tipo_ayuda'];
                                                                                if (($i % 4) == 0) {
                                                                                    echo '<br/><br/><br/>';
                                                                                }
                                                                                ?>
                                                                                <div class="form-group" >
                                                                                    <div class="checkbox">
                                                                                        <label>
                                                                                            <input  type="checkbox" name="ayuda[]" value="<?php echo $resul_naci[$i]['id_ayuda']; ?>" />
                                                                                            <?php echo $tipo_ayuda; ?>
                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>  
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" name="paso4" id="paso4" value="0" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
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

