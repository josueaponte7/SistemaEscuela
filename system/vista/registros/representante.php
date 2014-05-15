<?php
session_start();
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/Seguridad.php';
require_once '../../modelo/Representante.php';

$obj_parro = new Parroquia();
$obj_repre = new Seguridad();
$obj_rep   = new Representante();

$datos['sql'] = "SELECT  
                    CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = re.nacionalidad),re.cedula) AS cedula,  
                    CONCAT_WS(' ',re.nombre,re.apellido) AS nombres,
                    CONCAT_WS(', ', 
                    CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = re.cod_telefono),re.telefono),
                    CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = re.cod_celular),re.celular)) AS telefonos,
                    (SELECT er.nombre FROM estatus_representante er WHERE re.id_estatus = er.id_estatus) AS estatus
                   FROM representante re WHERE condicion = 1 ;";
$resultado    = $obj_rep->getRepresentantes($datos);

$_SESSION['menu']        = 'registros_representante';
$_SESSION['dir_sys']     = 'registros';
$_SESSION['archivo_sys'] = 'representante';
$_SESSION['height']      = '1200px';
$_SESSION['heightifm']   = '1100px';
$_SESSION['abrir']       = 'registros';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Representante</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>  
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/datepicker3.css" rel="stylesheet" media="screen"/> 
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2-bootstrap.css"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.tooltip.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.es.js"></script>

        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/script/representante.js"></script>
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
        <div id="reporte_representante" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Representantes
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Representante</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_representante" align="center">
                    <thead>
                        <tr>
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">C&eacute;dula</th>
                            <th width="150">Nombres</th>
                            <th width="150">Tel&eacute;fonos</th>
                            <th width="150">Estatus</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $es_array                = is_array($resultado) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resultado); $i++) {
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="cedula[]" value="<?php echo $resultado[$i]['cedula'] ?>" /></td>
                                    <td><span class="sub-rayar tooltip_ced"><?php echo $resultado[$i]['cedula'] ?></span></td>
                                    <td><?php echo $resultado[$i]['nombres'] ?></td>
                                    <td><?php echo $resultado[$i]['telefonos'] ?></td>
                                    <td><?php echo $resultado[$i]['estatus'] ?></td>
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
                        <li><span id="v_datos_r">Ver Datos del Representante</span></li>
                    </ul>
                </div>

                <!-------------------------------------------------------->
            </div>
        </div>

        <div id="registro_erepresentante" style="display: none">
            <form name="frmrepresentante" id="frmrepresentante"  role="form">
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Datos del Representante</div>
                    <div class="panel-body">
                        <table width="887" border="0" align="center">                        
                            <tr>
                                <td height="72" colspan="4" align="center">
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos Personales del Representante 
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td width="109" height="66" class="letras"> C&eacute;dula </td>
                                <td width="369">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="nacionalidad" class="form-control input-sm select2 " id="nacionalidad" style="float: left;">
                                                <?php
                                                $resul_naci = $obj_repre->codNacionalidad();
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
                                <td width="119" class="letras"> Nombre </td>
                                <td width="272">
                                    <div class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="nombre" name="nombre" placeholder="Nombre"/>
                                    </div>
                                </td>
                            </tr>
                            <tr height="60">
                                <td height="49" class="letras"> Apellido </td>
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
                            <tr height="40">
                                <td class="letras"> Fecha de Naci</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" style="background-color: #FFFFFF" readonly class="form-control input-sm" id="fech_naci" name="fech_naci" placeholder="Fecha de Nacimiento">
                                    </div>
                                </td>
                                <td class="letras"> Edad: </td>
                                <td>
                                    <div class="form-group">
                                        <input disabled="disabled" type="text" style="background-color: #FFFFFF" class="form-control input-sm" id="edad" name="edad" placeholder="Edad">
                                    </div>
                                </td>
                            </tr>

                            <tr height="60">
                                <td class="letras"> Tel&eacute;fono Hab </td>
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="cod_telefono" class="form-control input-sm select2" id="cod_telefono" style="float: left;">
                                                <option value="0">Cod</option>
                                                <?php
                                                $res_cod_tele = $obj_repre->codTelefono('tipo=1');
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
                                <td class="letras">Tel&eacute;fono Cel</td>  
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="cod_celular" class="form-control input-sm select2" id="cod_celular" style="float: left;">
                                                <option value="0">Cod</option>
                                                <?php
                                                $res_cod_tele = $obj_repre->codTelefono('tipo=2');
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
                                <td height="52" class="letras">Lugar de Naci:</td>
                                <td colspan="3">
                                    <div class="form-group">
                                        <textarea style="width:98% !important" id="lugar_naci" class="form-control input-sm" placeholder="Lugar de Nacimiento" rows="1" name="lugar_naci"></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td height="86" colspan="4" align="center"> 
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Direcci&oacute;n del Representante
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td class="letras"> Estado </td>
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
                                <td class="letras"> Municipio </td>
                                <td>
                                    <div class="form-group">
                                        <select name="municipio" class="form-control input-sm select2" id="municipio">
                                            <option value="0">Seleccione</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr height="45">
                                <td class="letras"> Parroquia </td>
                                <td>
                                    <div class="form-group">
                                        <select name="parroquia" class="form-control input-sm" id="parroquia">
                                            <option value="0">Seleccione</option>
                                        </select>
                                    </div>
                                </td>
                                <td class="letras"> Calle </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="calle" name="calle" placeholder="Calle, Avenida o Vereda"/>
                                    </div>
                                </td>
                            </tr>
                            <tr  height="45">
                                <td class="letras"> Casa o Apto </td>
                                <td><div class="form-group">
                                        <input type="text" class="form-control  input-sm" id="casa" name="casa" placeholder="Casa o Apartamento"/>
                                    </div>
                                </td>
                                <td class="letras"> Edificio </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control  input-sm" id="edificio" name="edificio" placeholder="Edificio"/>
                                    </div>
                                </td>
                            </tr>
                            <tr height="35">
                                <td class="letras" > Barrio o Urb </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="barrio" name="barrio" placeholder="Barrio o Urbanización">
                                    </div>
                                </td>
                                <td class="letras"></td>
                                <td>
                                    &nbsp;
                                </td>
                            </tr>

                            <tr>
                                <td height="86" colspan="4" align="center"> 
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Otros Datos
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>

                            <tr>
                                <td width="126" class="letras">
                                    Status
                                </td>
                                <td width="250">
                                    <div class="form-group">
                                        <select  name="estatus" class="form-control input-sm" id="estatus">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_rep->estatusRep();
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_estatus']; ?>"><?php echo $resultado[$i]['nombre']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>                                                
                                    </div> 
                                </td>
                                <td class="letras">
                                    Antecedentes
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="antecedente" name="antecedente" placeholder="Antecedentes"/>
                                    </div>
                                </td>
                            </tr>

                            <tr height="45">
                                <td width="103" class="letras">Nivel Instrucci&oacute;n</td>
                                <td width="286">
                                    <div class="form-group">
                                        <select  name="nivel_inst" class="form-control input-sm" id="nivel_inst">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_rep->nivelInst();
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_nivel']; ?>"><?php echo $resultado[$i]['nombre_nivel']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>                                                
                                    </div> 
                                </td>
                                <td class="letras"> Profesi&oacute;n </td>
                                <td>
                                    <div class="form-group">
                                        <select name="profesion" class="form-control input-sm" id="profesion">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_rep->Profesion();
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_profesion']; ?>"><?php echo $resultado[$i]['nombre_profesion']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                                <td>&nbsp;

                                </td>
                            </tr>
                            <tr height="35">
                                <td class="letras">
                                    Fuente Ingreso
                                </td>
                                <td>
                                    <div cclass="form-group">
                                        <input  type="text" class="form-control input-sm" id="fuente_ingreso" name="fuente_ingreso" placeholder="Fuente de Ingreso" maxlength="6">
                                    </div>
                                </td>
                               <td class="letras"> Email </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="email" name="email" placeholder="Email">
                                    </div>
                                </td>
                            </tr> 

                            <tr>
                                <td colspan="4" align="center"> 
                                    <div  class="form-group" id="botones" style="margin-top: 50px;">
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
