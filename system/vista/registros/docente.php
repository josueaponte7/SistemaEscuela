<?php
session_start();
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/Seguridad.php';
require_once '../../modelo/Docente.php';

$obj_parro = new Parroquia();
$obj_doc = new Seguridad();
$obj_docen = new Docente();

$datos['sql'] = "SELECT 
                    CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = doc.nacionalidad),doc.cedula) AS cedula,
                    doc.nombre,
                    doc.apellido,
                    (SELECT ac.actividad FROM actividad ac WHERE doc.id_actividad = ac.id_actividad ) AS actividad
                    FROM docente AS doc WHERE condicion = 1;";
$resultado = $obj_docen->getDocente($datos);

$_SESSION['menu'] = 'registros_docente';
$_SESSION['dir_sys'] = 'registros';
$_SESSION['archivo_sys'] = 'docente';
$_SESSION['height'] = '1100px';
$_SESSION['heightifm'] = '995px';
$_SESSION['abrir'] = 'registros';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Docente</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>  
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/datepicker3.css" rel="stylesheet" media="screen"/> 
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2-bootstrap.css"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.es.js"></script>

        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/script/docente.js"></script>

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
        <div id="reporte_docente" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Docentes
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Docente</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_docente" align="center" name="tabla_docente">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">C&eacute;dula</th>
                            <th width="150">Nombre</th>
                            <th width="150">Apellido</th>
                            <th width="150">Actividad</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $es_array = is_array($resultado) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resultado); $i++) {
                                ?>
                                <tr class="letras">
                                    <td>
                                        <input type="checkbox" id="<?php echo $resultado[$i]['cedula']; ?>" name="cedula[]" value="<?php echo $resultado[$i]['cedula']; ?>" />
                                    </td>
                                    <td><?php echo $resultado[$i]['cedula'] ?></td>
                                    <td><?php echo $resultado[$i]['nombre'] ?></td>
                                    <td><?php echo $resultado[$i]['apellido'] ?></td>
                                    <td><?php echo $resultado[$i]['actividad'] ?></td>
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

                <!-- Menu desplegable al hacer click sobre la cedula --->
                <button type="button" id="imprimir" class="btn btn-default btn-sm" style="margin-top:5%;margin-left: 25%;display: none;color:#2781D5" >Generar Listado</button>
                <div id="contextMenu" class="dropdown clearfix">
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                        <li><span id="v_datos_r">Ver Datos del Docente</span></li>
                    </ul>
                </div>

                <!-------------------------------------------------------->
            </div>
        </div>        

        <div id="registro_docente" style="display: none">       
            <form name="frmdocente" id="frmdocente"  role="form">
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Datos del Docente</div>
                    <div class="panel-body">
                        <table width="887" border="0" align="center">                        
                            <tr>
                                <td height="72" colspan="5" align="center">
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos Personales del Docente
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td width="116" height="66" class="letras"> C&eacute;dula: </td>
                                <td width="344">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="nacionalidad" class="form-control input-sm select2" id="nacionalidad" style="float: left;">
                                                <option value="0">N</option>
                                                <?php
                                                $resul_naci = $obj_doc->codNacionalidad();
                                                for ($i = 0; $i < count($resul_naci); $i++) {
                                                    ?>
                                                    <option value="<?php echo $resul_naci[$i]['id_nacionalidad']; ?>"><?php echo $resul_naci[$i]['nombre']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div id="div_cedula" class="form-group">
                                            <input type="text" style="background-color: #ffffff" class="form-control input-sm" id="cedula" name="cedula" placeholder="Cédula" maxlength="8"/>
                                        </div>
                                    </div>
                                </td>
                                <td width="35" align="left">
                                    <img style="cursor: pointer; margin-top: -8px; margin-left:-25px;" id="imgcedula" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                                
                                <td width="88" align="left" class="letras">Nombre:</td>
                                <td width="277">
                                    <div id="div_nombre" class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="nombre" name="nombre" placeholder="Nombre"/>
                                    </div>
                                </td>
                                <td  width="18" heigth="10">
                                    <img style="cursor: pointer; margin-top: -16px;" id="imgnombre" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                            </tr>
                            
                            <tr height="60">
                                <td height="49" class="letras"> Apellido: </td>
                                <td>
                                    <div id="div_apellido" class="form-group">
                                        <input type="text" class="form-control  input-sm" id="apellido" name="apellido" placeholder="Apellido"/>
                                    </div>
                                </td>
                                <td width="35" align="left">
                                    <img style="cursor: pointer; margin-top: -16px; margin-left:-25px;" id="imgapellido" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                                
                                <td align="left" class="letras">Sexo: </td>
                                <td>
                                    <select name="sexo" class="form-control input-sm select2" id="sexo">
                                        <option value="0">Seleccione</option>
                                        <option value="1">Femenino</option>
                                        <option value="2">Masculino</option>
                                    </select>
                                </td>
                                 <td  width="18" heigth="10">
                                    <img style="cursor: pointer;" id="imgsexo" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                            </tr>
                            
                            <tr height="40">
                                <td class="letras" width="150"> Fecha de Naci: </td>
                                <td>
                                    <div id="div_fech_naci" class="form-group">
                                        <input type="text" style="background-color: #ffffff" readonly="readonly" class="form-control input-sm" id="fech_naci" name="fech_naci" placeholder="Fecha de Nacimiento">
                                    </div>
                                </td>
                                <td width="54" align="left">
                                    <img style="cursor: pointer; margin-top: -16px; margin-left:-25px;" id="imgfechaNac" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                                
                                <td align="left" class="letras">Edad: </td>
                                <td>
                                    <div id="div_edad" class="form-group">
                                        <input type="text"  disabled="disabled" style="background-color: #ffffff" class="form-control input-sm" id="edad" name="edad" placeholder="Edad">
                                    </div>
                                </td>
                            </tr>
                            
                            <tr height="60">
                                <td class="letras"> Email: </td>
                                <td>
                                    <div id="div_email" class="form-group">
                                        <input type="text" class="form-control input-sm" id="email" name="email" placeholder="Email">
                                    </div>
                                </td>
                                <td align="left" class="letras">&nbsp;</td>
                                <td class="letras" width="120">Tel&eacute;fono Hab:</td>
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="cod_telefono" class="form-control input-sm select2" id="cod_telefono" style="float: left;">
                                                <option value="0">Cod</option>
                                                <?php
                                                $res_cod_tele = $obj_doc->codTelefono('tipo=1');
                                                for ($i = 0; $i < count($res_cod_tele); $i++) {
                                                    ?>
                                                    <option value="<?php echo $res_cod_tele[$i]['id']; ?>"><?php echo $res_cod_tele[$i]['codigo']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div id="div_telefono" class="form-group">
                                            <input type="text" class="form-control input-sm" id="telefono" name="telefono" placeholder="Teléfono Hab.." maxlength="7"/>
                                        </div>
                                    </div>
                                </td> 
                                <td width="54" align="left"></td>
                            </tr>

                            <tr>
                                <td class="letras">Tel&eacute;fono Cel: </td>  
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="cod_celular" class="form-control input-sm select2" id="cod_celular" style="float: left;">
                                                <option value="0">Cod</option>
                                                <?php
                                                $res_cod_tele = $obj_doc->codTelefono('tipo=2');
                                                for ($i = 0; $i < count($res_cod_tele); $i++) {
                                                    ?>
                                                    <option value="<?php echo $res_cod_tele[$i]['id']; ?>"><?php echo $res_cod_tele[$i]['codigo']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>

                                        </div> 
                                        <div id="div_celular" class="form-group">
                                            <input  type="text" class="form-control input-sm" id="celular" name="celular" placeholder="Teléfono Celular" maxlength="7"/>

                                        </div> 
                                    </div>
                                </td>
                                <td  width="5" heigth="10">
                                    <img style="cursor: pointer; margin-top: -1px; margin-left: -25px;" id="imgtelcel" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="60">
                                <td height="52" class="letras">Lugar de Naci:</td>
                                <td colspan="4">
                                    <div id="div_lugar_naci" class="form-group">
                                        <textarea style="width:99% !important" id="lugar_naci" class="form-control input-sm" placeholder="Lugar de Nacimiento" rows="1" name="lugar_naci"></textarea>
                                    </div>
                                </td>
                                <td  width="18" heigth="10">
                                    <img style="cursor: pointer; margin-top: -16px;" id="imglugarNac" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                            </tr>

                            <tr>
                                <td height="86" colspan="5" align="center"> 
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Direcci&oacute;n del Docente 
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td class="letras"> Estado: </td>
                                <td>
                                    <div class="form-group">
                                        <select name="estado" class="form-control input-sm select2" id="estado">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_parro->getEstados();
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_estado']; ?>"><?php echo $resultado[$i]['nombre_estado']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                                <td width="35" align="left">
                                    <img style="cursor: pointer; margin-left: -25px; margin-top: -16px;" id="imgestado" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                                
                                <td align="left" class="letras">Municipio: </td>
                                <td>
                                    <div class="form-group">
                                        <select name="municipio" class="form-control input-sm select2" id="municipio">
                                            <option value="0">Seleccione</option>
                                        </select>
                                    </div>
                                </td>
                                <td  width="18" heigth="10">
                                    <img style="cursor: pointer; margin-top: -16px;" id="imgminicipio" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                            </tr>
                            
                            <tr height="45">
                                <td class="letras"> Parroquia: </td>
                                <td>
                                    <div class="form-group">
                                        <select name="parroquia" class="form-control input-sm select2" id="parroquia">
                                            <option value="0">Seleccione</option>
                                        </select>
                                    </div>
                                </td>
                               <td width="35" align="left">
                                    <img style="cursor: pointer; margin-left: -25px; margin-top: -16px;" id="imgparroquia" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                                
                                <td align="left" class="letras">Calle: </td>
                                <td>
                                    <div id="div_calle" class="form-group">
                                        <input type="text" class="form-control input-sm" id="calle" name="calle" placeholder="Calle, Avenida o Vereda"/>
                                    </div>
                                </td>
                                <td  width="18" heigth="10">
                                    <img style="cursor: pointer; margin-top: -16px;" id="imgcalle" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                            </tr>
                            
                            <tr  height="45">
                                <td class="letras"> Casa o Apto: </td>
                                <td>
                                    <div id="div_casa" class="form-group">
                                        <input type="text" class="form-control  input-sm" id="casa" name="casa" placeholder="Casa o Apartamento"/>
                                    </div>
                                </td>
                                 <td width="35" align="left">
                                    <img style="cursor: pointer; margin-left: -25px; margin-top: -16px;" id="imgcasa" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                                
                                <td align="left" class="letras">Edificio:</td>
                                <td>
                                    <div id="div_edificio" class="form-group">
                                        <input type="text" class="form-control  input-sm" id="edificio" name="edificio" placeholder="Edificio"/>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr height="35">
                                <td class="letras"> Barrio o Urb: </td>
                                <td>
                                    <div id="div_barrio" class="form-group">
                                        <input type="text" class="form-control input-sm" id="barrio" name="barrio" placeholder="Barrio o Urbanización">
                                    </div>
                                </td>
                                <td width="35" align="left">
                                    <img style="cursor: pointer; margin-left: -25px; margin-top: -16px;" id="imgbarrio" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                            </tr>

                            <tr>
                                <td height="86" colspan="5" align="center"> 
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Otrso Datos
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td class="letras">Status: </td>
                                <td>
                                    <div cclass="form-group">
                                        <select  name="estatus" class="form-control input-sm" id="estatus">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_docen->estatusDoce();
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_estatus']; ?>"><?php echo $resultado[$i]['nombre']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>                                                
                                    </div> 
                                </td>
                                <td width="35" align="left">
                                    <img style="cursor: pointer; margin-left: -25px;" id="imgestatus" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                                
                                <td align="left" class="letras">Actividad:</td>
                                <td>
                                    <div class="form-group">
                                        <select  name="actividad" class="form-control input-sm select2" id="actividad">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_docen->activi();
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_actividad']; ?>"><?php echo $resultado[$i]['actividad']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>                                                
                                    </div> 
                                </td>
                                 <td  width="18" heigth="10">
                                    <img style="cursor: pointer; margin-top: -16px;" id="imgactividad" src="../../imagenes/exclamtion.png" width="15" height="15" alt="img_info"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" align="center"> 
                                    <div id="botones" style="margin-top: 50px;">
                                        <input type="hidden" name="accion" value="agregar" id="accion"/>
                                        <button type="button" id="guardar" class="btn btn-primary btn-sm">Guardar</button>
                                        <button type="button" id="limpiar" class="btn btn-primary btn-sm">Limpiar</button>
                                        <button type="button" id="salir" class="btn btn-primary btn-sm">Salir</button>
                                    </div>
                                </td>
                            </tr>
                        </table><!--Cierre de toda la tabla -->
                    </div>
                </div>
            </form>  
        </div> 
    </body>
</html>