<?php
session_start();
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/Seguridad.php';
require_once '../../modelo/StatusEstudiante.php';
require_once '../../modelo/Estudiante.php';

$obj_parro               = new Parroquia();
$obj_estudi              = new Estudiante();
$obj_status              = new StatusEstudiante();
$d_estudianterep ['sql'] = "SELECT 
                            CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = e.nacionalidad),e.cedula) AS cedula,
                            CONCAT_WS(' ',e.nombre,e.apellido) AS nombres,
                            ee.nombre AS estatus,
                            r.cedula as cedula_r,
                            CONCAT_WS(' ',r.nombre,r.apellido) AS representante
                            FROM estudiante_representante AS er
                            INNER JOIN estudiante AS e ON(er.cedula_estudiante=e.cedula AND er.representante=1)
                            INNER JOIN representante AS r ON(er.cedula_representante=r.cedula AND er.representante=1)
                            INNER JOIN estatus_estudiante ee ON e.id_estatus=ee.id_estatus";

$resul_estudiante = $obj_estudi->getEstudianterepre($d_estudianterep);

$_SESSION['menu']        = 'registros_estudiante';
$_SESSION['dir_sys']     = 'registros';
$_SESSION['archivo_sys'] = 'estudiante';
$_SESSION['height']      = '1220px';
$_SESSION['heightifm']   = '1120px';
$_SESSION['abrir']       = 'registros';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Estudiante</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/datepicker3.css" rel="stylesheet" media="screen"/> 
        <link href="../../librerias/css/select2.css" rel="stylesheet" type="text/css" />
        <link href="../../librerias/css/select2-bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.tooltip.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.es.js"></script>       

        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script> 
        <script type="text/javascript" src="../../librerias/script/estudiante.js"></script> 
        <style type="text/css">
            .sub-rayar:hover{
                text-decoration: underline;
                cursor: pointer;
                color: #0154A0;
            }
            #contextMenuEst.dropdown-menu{
                width: 150px !important;
                min-width: 150px
            }
            #contextMenuEst,#contextMenuRep{
                position: absolute;
                display:none;
            }
        </style>
    </head>
    <body>  
        <div id="reporte_estudiante" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Estudiantes
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Estudiante</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_estudiante" align="center" name="tabla_estudiante">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">C&eacute;dula</th>
                            <th width="150">Nombres</th>
                            <th width="150">Estatus</th>
                            <th width="150">Representante</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $es_array                = is_array($resul_estudiante) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resul_estudiante); $i++) {
                                ?>
                                <tr class="letras">
                                    <td>
                                        <input type="checkbox" id="<?php echo $resul_estudiante[$i]['cedula']; ?>" name="cedula[]" value="<?php echo $resul_estudiante[$i]['cedula']; ?>" />
                                    </td>
                                    <td>
                                        <span class="sub-rayar tooltip_ced"><?php echo $resul_estudiante[$i]['cedula']; ?></span>
                                    </td>                                 
                                    <td><?php echo $resul_estudiante[$i]['nombres']; ?></td>
                                    <td><?php echo $resul_estudiante[$i]['estatus']; ?></td>
                                    <td>
                                        <span class="sub-rayar representante" id="<?php echo $resul_estudiante[$i]['cedula_r']; ?>"><?php echo $resul_estudiante[$i]['representante']; ?></span>
                                    </td>
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
                <button type="button" id="imprimir" class="btn btn-default btn-sm" style="margin-top:5%;margin-left: 25%;display: none;color:#2781D5" >Generar Listado</button>
                <div id="contextMenuEst" class="dropdown clearfix">
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                        <li><span id="v_datos">Ver Datos</span></li>
                        <li><span id="v_repre">Ver Representantes</span></li>
                    </ul>
                </div>
                <div id="contextMenuRep" class="dropdown clearfix">
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                        <li><span id="v_datos_r">Ver Representante</span></li>
                        <li><span id="m_repre">Modificar Representante</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="registro_estudiante" style="display:none">
            <form name="frmestudiante" id="frmestudiante"  role="form" >
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Datos del Estudiante</div>
                    <div class="panel-body">
                        <table width="887" border="0" align="center">                        
                            <tr>
                                <td height="72" colspan="4" align="center">
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos Personales del Estudiante 
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td width="109" height="66" class="letras"> C&eacute;dula: </td>
                                <td width="369">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="nacionalidad" class="form-control input-sm select2 " id="nacionalidad" style="float: left;">
                                                <option value="0">N</option>
                                                <?php
                                                $resul_naci = $obj_estudi->codNacionalidad();
                                                for ($i = 0; $i < count($resul_naci); $i++) {
                                                    ?>
                                                    <option value="<?php echo $resul_naci[$i]['id_nacionalidad']; ?>"><?php echo $resul_naci[$i]['nombre']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control input-sm" id="cedula" name="cedula" placeholder="Cédula" maxlength="8"/>
                                        </div>
                                    </div>
                                </td>
                                <td width="119" class="letras"> Nombre: </td>
                                <td width="272">
                                    <div class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="nombre" name="nombre" placeholder="Nombre"/>
                                    </div>
                                </td>
                            </tr>
                            <tr height="60">
                                <td height="49" class="letras"> Apellido: </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control  input-sm" id="apellido" name="apellido" placeholder="Apellido"/>
                                    </div>
                                </td>
                                
                                <td class="letras"> Sexo:</td>
                                <td>
                                    <select name="sexo" class="form-control input-sm select2" id="sexo">
                                        <option value="0">Seleccione</option>
                                        <option value="1">Femenino</option>
                                        <option value="2">Masculino</option>
                                    </select>
                                </td>
                            </tr>
                            <tr height="49">
                                <td class="letras"> Fecha de Naci: </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" style="background-color: #ffffff" readonly class="form-control input-sm" id="fech_naci" name="fech_naci" placeholder="Fecha de Nacimiento">
                                    </div>
                                </td>
                                <td class="letras"> Edad: </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" disabled="disabled"  style="background-color: #ffffff" class="form-control input-sm" id="edad" name="edad" placeholder="Edad">
                                    </div>
                                </td
                            </tr>

                            <tr height="60">
                                <td class="letras"> Tel&eacute;fono Hab: </td>
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="cod_telefono" class="form-control input-sm select2" id="cod_telefono" style="float: left;">
                                                <option value="0">Cod</option>
                                                <?php
                                                $res_cod_tele = $obj_estudi->codTelefono('tipo=1');
                                                for ($i = 0; $i < count($res_cod_tele); $i++) {
                                                    ?>
                                                    <option value="<?php echo $res_cod_tele[$i]['id']; ?>"><?php echo $res_cod_tele[$i]['codigo']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control input-sm" id="telefono" name="telefono" placeholder="Teléfono Hab.." maxlength="7"/>
                                        </div>
                                    </div>
                                </td>                          
                                <td class="letras">Tel&eacute;fono Cel: </td>  
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="cod_celular" class="form-control input-sm select2" id="cod_celular" style="float: left;">
                                                <option value="0">Cod</option>
                                                <?php
                                                $res_cod_tele = $obj_estudi->codTelefono('tipo=2');
                                                for ($i = 0; $i < count($res_cod_tele); $i++) {
                                                    ?>
                                                    <option value="<?php echo $res_cod_tele[$i]['id']; ?>"><?php echo $res_cod_tele[$i]['codigo']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>

                                        </div> 
                                        <div class="form-group">
                                            <input  type="text" class="form-control input-sm" id="celular" name="celular" placeholder="Teléfono Celular" maxlength="7"/>

                                        </div> 
                                    </div>
                                </td>
                            </tr>
                            <tr height="60">
                                <td class="letras"> Email: </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="email" name="email" placeholder="Email">
                                    </div>
                                </td>
                                <td class="letras">Estatus</td>
                                <td>
                                    <select name="estatus"  class="form-control input-sm" id="estatus">
                                        <option value="0">Seleccione</option>
                                        <?php
                                        $opciones['campos'] = 'id_estatus,nombre';

                                        $resul_status = $obj_status->getStatusestu($opciones);
                                        for ($i = 0; $i < count($resul_status); $i++) {
                                            ?>
                                            <option value="<?php echo $resul_status[$i]['id_estatus']; ?>"><?php echo $resul_status[$i]['nombre']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td class="letras">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr height="60">
                                <td height="52" class="letras">Lugar de Naci:</td>
                                <td colspan="3">
                                    <div class="form-group">
                                        <textarea style="width:99% !important" id="lugar_naci" class="form-control input-sm" placeholder="Lugar de Nacimiento" rows="1" name="lugar_naci"></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td height="86" colspan="4" align="center"> 
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Direcci&oacute;n del Estudiante 
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
                                <td class="letras"> Municipio: </td>
                                <td>
                                    <div class="form-group">
                                        <select name="municipio" class="form-control input-sm select2" id="municipio">
                                            <option value="0">Seleccione</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr height="45">
                                <td class="letras"> Parroquia: </td>
                                <td>
                                    <div class="form-group">
                                        <select name="id_parroquia" class="form-control input-sm" id="id_parroquia">
                                            <option value="0">Seleccione</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="letras"> Calle: </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="calle" name="calle" placeholder="Calle, Avenida o Vereda"/>
                                    </div>
                                </td>
                            </tr>
                            <tr  height="45">
                                <td class="letras"> Casa o Apto: </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control  input-sm" id="casa" name="casa" placeholder="Casa o Apartamento"/>
                                    </div>
                                </td>
                                <td class="letras"> Edificio: </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control  input-sm" id="edificio" name="edificio" placeholder="Edificio"/>
                                    </div>
                                </td>
                            </tr>
                            <tr height="35">
                                <td height="49" class="letras" > Barrio o Urb: </td>
                                <td colspan="3">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="barrio" name="barrio" placeholder="Barrio o Urbanización">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <!--Botones-->
                                    <table border="1" class="dataTable" align="center" id="tbl_repre" style="width:100%;display: none">
                                        <thead>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <th>Cedula</th>
                                                <th>Nombre</th>
                                                <th>Parentesco</th>
                                                <th>Representante</th>
                                            </tr>
                                        </thead>
                                        <tbody>        
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="86" colspan="4" align="center"> 
                                    <div id="botones" style="margin-top: 30px;">
                                        <input type="hidden" name="accion" value="agregar" id="accion"/>
                                        <button type="button" id="asignar_rep" class="btn btn-success btn-sm">Asignar Representantes</button>
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

