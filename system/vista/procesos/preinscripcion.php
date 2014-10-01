<?php
session_start();
require_once '../../modelo/Preinscripcion.php';

$obj_pre      = new Preinscripcion();
$datos        = array();
$datos['sql'] = "SELECT 
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
$resultado    = $obj_pre->datos($datos);

$_SESSION['menu']        = 'procesos_preinscripcion';
$_SESSION['dir_sys']     = 'procesos';
$_SESSION['archivo_sys'] = 'preinscripcion';
$_SESSION['height']      = '600px';
$_SESSION['heightifm']   = '520px';
$_SESSION['abrir']       = 'procesos';


$datos              = array();
$datos['campos']    = "CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = es.nacionalidad),es.cedula) AS cedula,CONCAT_WS(' ',CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = es.nacionalidad),es.cedula),es.nombre, es.apellido) AS datos";
$datos['condicion'] = "id_estatus < 2 AND condicion=1";
$resul              = $obj_pre->datos($datos);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pre-Inscripci&oacute;n</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/datepicker3.css" rel="stylesheet" media="screen"/> 
        <link href="../../librerias/css/select2.css" rel="stylesheet" type="text/css" />
        <link href="../../librerias/css/select2-bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.es.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/script/preinscripcion.js"></script>

        <style type="text/css">
            .sub-rayar:hover{
                text-decoration: underline;
                cursor: pointer;
                color: #0154A0;
            }
            #contextMenu.dropdown-menu{
                width: 150px !important;
                min-width: 150px
            }
            #contextMenu{
                position: absolute;
                display:none;
            }
        </style>

    </head>
    <body>  
        <div id="reporte_preinscrip" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Pre-Inscripci&oacute;n de Estudiantes 
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Pre-Inscripci&oacute;n</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_preinscrip" align="center">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">Nº</th>
                            <th style="width: 35%">C&eacute;dula</th>
                            <th width="150">Nombres</th>
                            <th width="150">Sexo</th>
                            <th width="150">Tel&eacute;fonos</th>
                            <th width="150">Fecha</th>                            
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $es_array = is_array($resultado) ? TRUE : FALSE;
                        if ($es_array === TRUE) {                            
                            for ($i = 0; $i < count($resultado); $i++) {
                                
                                $telefono = $resultado[$i]['telefono'];
                                $celular  = $resultado[$i]['celular'];
                               $telefonos = "";
                                
                                if($telefono != 0 && $celular == 0){
                                    $telefonos =$telefono;
                                }else if($celular != 0 && $telefono == 0){
                                    $telefonos = $celular;
                                }else if($telefono != 0 && $celular != 0){
                                    $telefonos = $telefono.','.$celular;
                                } 
                                ?>
                                <tr class="letras">
                                    <td><input type="checkbox" name="cedula[]" value="<?php echo $resultado[$i]['cedula'] ?>" /></td>
<!--                                    <td><input type="checkbox" id="<?php echo $resultado[$i]['cedula']; ?>" name="cedula[]" value="<?php echo $resultado[$i]['cedula']; ?>" /></td>-->
                                    <td><?php echo $resultado[$i]['num_registro'] ?></td>
                                    <td><span class="sub-rayar tooltip_ced"><?php echo $resultado[$i]['cedula'] ?></span></td>
                                    <td><?php echo $resultado[$i]['nombres'] ?></td>
                                    <td><?php echo $resultado[$i]['sexo'] ?></td>
                                    <td><?php echo $telefonos ?></td>
                                    <td><?php echo $resultado[$i]['fecha_actual'] ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Menu desplegable al hacer click sobre la cedula --->

                <button type="button" id="imprimir" class="btn btn-default btn-sm" style="margin-top:5%;margin-left: 25%;display: none;color:#2781D5" >Generar Listado</button>
                <div id="contextMenu" class="dropdown clearfix">
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                        <li><span id="v_datos_pre">Ver la Preinscripci&oacute;n</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="registro_preinscrip" style="display: none;">
            <form name="formpreinscripcion" id="formpreinscripcion"  role="form" >
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Pre-Inscripción de Estudiantes</div>
                    <div class="panel-body">
                        <table width="1151" border="0">
                            <tr>
                                <td width="130" height="70">
                                    <span class="letras"> Estudiante: </span>
                                </td>
                                <td width="514">
                                    <select style="width: 350px !important;" name="cedula" class="form-control input-sm select2" id="cedula">
                                        <option value="0">Seleccione</option>
                                        <?php
                                        $es_array = is_array($resul) ? TRUE : FALSE;
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
                                <td width="323" height="70" align="right">
                                    <span class="letras"> Num Registro:</span></td>
                                <td width="156">
                                    <div class="form-group">
                                        <input disabled="disabled" type="text" style="width: 100px !important; color:#FF0000; font-weight:bold;margin-top: 10px;" class="form-control  input-sm letras" id="num_registro" name="num_registro" placeholder="Num Registro" maxlength="7"/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table width="1156" border="0" align="center">
                            <tr>
                                <td height="70" colspan="4">
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> Datos Personales del Estudiante </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td width="210" class="letras"> Nombre Completo: </td>
                                <td width="475">
                                    <div class="form-group">
                                        <input disabled="disabled" type="text" class="form-control  input-sm" id="nombre" name="nombre" placeholder="Nombre Completo"/>
                                    </div>
                                </td>
                                <td width="181" class="letras"> Fecha de Naci: </td>
                                <td width="272">
                                    <div class="form-group">
                                        <input type="text" disabled="disabled" class="form-control input-sm" id="fech_naci" name="fech_naci" placeholder="Fecha de Nacimiento">
                                    </div>
                                </td>
                            </tr>
                            <tr height="40">
                                <td class="letras"> Sexo: </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" disabled="disabled" class="form-control input-sm" id="sexo" name="sexo" placeholder="Sexo">
                                    </div>
                                </td>
                                <td class="letras"> Edad: </td>
                                <td>
                                    <div class="form-group">
                                        <input disabled="disabled" type="text" class="form-control input-sm" id="edad" name="edad" placeholder="Edad">
                                    </div>
                                </td>
                            </tr>
                            <tr height="60">
                                <td class="letras"> Tel&eacute;fono Hab: </td>
                                <td>
                                    <div class="form-group">
                                        <input disabled="disabled" style="width: 250px !important;" type="text" class="form-control input-sm" id="telefono" name="telefono" placeholder="Teléfono Hab.."/>
                                    </div>
                                </td>
                                <td class="letras"> Tel&eacute;fono Cel: </td>
                                <td>
                                    <div class="form-group">
                                        <input disabled="disabled" style="width: 250px !important;" type="text" class="form-control input-sm" id="celular" name="celular" placeholder="Teléfono Celular"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                    <input type="hidden" name="accion" value="agregar" id="accion"/>
                                    <button type="button" id="guardar" class="btn btn-primary btn-sm">Guardar</button>
                                    <button type="button" id="limpiar" class="btn btn-primary btn-sm">Limpiar</button>
                                    <button type="button" id="salir" class="btn btn-primary btn-sm">Salir</button>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                        <!--Cierre de toda la tabla -->
                    </div>
                </div>
            </form> 
        </div>
    </body>
</html>