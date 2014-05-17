<<<<<<< HEAD
<?php
session_start();
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/Seguridad.php';
require_once '../../modelo/Choferes.php';

$obj_parro            = new Parroquia();
$obj_chof             = new Seguridad();
$obj_cho              = new Choferes();
$d_choferes['campos'] = "CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = ch.nacionalidad),ch.cedula) AS cedula,
                         CONCAT_WS(' ',ch.nombre,ch.apellido) AS nombres,
                         CONCAT_WS(', ', 
                         CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = ch.cod_telefono),ch.telefono),
                         CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = ch.cod_celular),ch.celular)) AS telefonos";
$resul_choferes       = $obj_cho->getChofer($d_choferes);


$_SESSION['menu']        = 'registros_choferes';
$_SESSION['dir_sys']     = 'registros';
$_SESSION['archivo_sys'] = 'choferes';
$_SESSION['height']      = '770px';
$_SESSION['heightifm']   = '720px';
$_SESSION['abrir']       = 'registros';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Choferes</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>  
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2-bootstrap.css"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
        
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/script/choferes.js"></script>

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
        <div id="reporte_choferes" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Choferes
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Choferes</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_choferes" align="center">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">C&eacute;dula</th>
                            <th width="150">Nombres</th>
                            <th width="150">Tel&eacute;fonos</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $es_array                = is_array($resul_choferes) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resul_choferes); $i++) {
                                ?>
                                <tr class="letras">
                                    <td>
                                        <input type="checkbox" id="<?php echo $resul_choferes[$i]['cedula']; ?>" name="cedula[]" value="<?php echo $resul_choferes[$i]['cedula']; ?>" />
                                    </td>
                                    <td><span class="sub-rayar tooltip_ced"><?php echo $resul_choferes[$i]['cedula'] ?></span></td>
                                    <td><?php echo $resul_choferes[$i]['nombres']; ?></td>
                                    <td><?php echo $resul_choferes[$i]['telefonos']; ?></td>
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
                        <li><span id="v_datos_r">Ver Datos del Chofer</span></li>
                    </ul>
                </div>

                <!-------------------------------------------------------->
            </div>
        </div>

        <div id="registro_choferes" style="display: none">
            <form name="frmchoferes" id="frmchoferes"  role="form">
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Datos del chofer</div>
                    <div class="panel-body">
                        <table width="887" border="0" align="center">                        
                            <tr>
                                <td height="72" colspan="4" align="center">
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos Personales del Chofer
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
                                                $resul_naci = $obj_chof->codNacionalidad();
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
                                <td class="letras"> Email </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="email" name="email" placeholder="Email">
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
                                                $res_cod_tele = $obj_chof->codTelefono('tipo=1');
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
                                                $res_cod_tele = $obj_chof->codTelefono('tipo=2');
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
                            <tr>
                                <td height="86" colspan="4" align="center"> 
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos de Vehiculo
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr  height="45">
                                <td class="letras"> Placa  </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control  input-sm" id="placa" name="placa" placeholder="Placa"/>
                                    </div>
                                </td>
                            </tr>
                            <tr height="35">
                                <td class="letras"> Modelo </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="modelo" name="modelo" placeholder="Modelo">
                                    </div>
                                </td>
                            </tr>
                            <tr height="35">
                                <td class="letras"> Color </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="color" name="color" placeholder="Color">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center"> 
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
=======
<?php
session_start();
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/Seguridad.php';
require_once '../../modelo/Choferes.php';

$obj_parro            = new Parroquia();
$obj_chof             = new Seguridad();
$obj_cho              = new Choferes();
$d_choferes['campos'] = "CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = ch.nacionalidad),ch.cedula) AS cedula,
                         CONCAT_WS(' ',ch.nombre,ch.apellido) AS nombres,
                         CONCAT_WS(', ', 
                         CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = ch.cod_telefono),ch.telefono),
                         CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = ch.cod_celular),ch.celular)) AS telefonos";
$resul_choferes       = $obj_cho->getChofer($d_choferes);


$_SESSION['menu']        = 'registros_choferes';
$_SESSION['dir_sys']     = 'registros';
$_SESSION['archivo_sys'] = 'choferes';
$_SESSION['height']      = '770px';
$_SESSION['heightifm']   = '720px';
$_SESSION['abrir']       = 'registros';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Choferes</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>  
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2-bootstrap.css"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
        
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/script/choferes.js"></script>

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
        <div id="reporte_choferes" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Choferes
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Choferes</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_choferes" align="center">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">C&eacute;dula</th>
                            <th width="150">Nombres</th>
                            <th width="150">Tel&eacute;fonos</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $es_array                = is_array($resul_choferes) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resul_choferes); $i++) {
                                ?>
                                <tr class="letras">
                                    <td>
                                        <input type="checkbox" id="<?php echo $resul_choferes[$i]['cedula']; ?>" name="cedula[]" value="<?php echo $resul_choferes[$i]['cedula']; ?>" />
                                    </td>
                                    <td><span class="sub-rayar tooltip_ced"><?php echo $resul_choferes[$i]['cedula'] ?></span></td>
                                    <td><?php echo $resul_choferes[$i]['nombres']; ?></td>
                                    <td><?php echo $resul_choferes[$i]['telefonos']; ?></td>
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
                        <li><span id="v_datos_r">Ver Datos del Chofer</span></li>
                    </ul>
                </div>

                <!-------------------------------------------------------->
            </div>
        </div>

        <div id="registro_choferes" style="display: none">
            <form name="frmchoferes" id="frmchoferes"  role="form">
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Datos del chofer</div>
                    <div class="panel-body">
                        <table width="887" border="0" align="center">                        
                            <tr>
                                <td height="72" colspan="4" align="center">
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos Personales del Chofer
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
                                                $resul_naci = $obj_chof->codNacionalidad();
                                                for ($i = 0; $i < count($resul_naci); $i++) {
                                                    ?>
                                                    <option value="<?php echo $resul_naci[$i]['id_nacionalidad']; ?>"><?php echo $resul_naci[$i]['nombre']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div id="div_cedula" class="form-group">
                                            <input type="text" class="form-control input-sm" id="cedula" name="cedula" placeholder="Cédula" maxlength="8"/>
                                        </div>
                                    </div>
                                </td>
                                <td width="119" class="letras"> Nombre </td>
                                <td width="272">
                                    <div id="div_nombre" class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="nombre" name="nombre" placeholder="Nombre"/>
                                    </div>
                                </td>
                            </tr>
                            <tr height="60">
                                <td height="49" class="letras"> Apellido </td>
                                <td>
                                    <div id="div_apellido" class="form-group">
                                        <input type="text" class="form-control  input-sm" id="apellido" name="apellido" placeholder="Apellido"/>
                                    </div>
                                </td>
                                <td class="letras"> Email </td>
                                <td>
                                    <div id="div_email" class="form-group">
                                        <input type="text" class="form-control input-sm" id="email" name="email" placeholder="Email">
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
                                                $res_cod_tele = $obj_chof->codTelefono('tipo=1');
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
                                <td class="letras">Tel&eacute;fono Cel</td>  
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="cod_celular" class="form-control input-sm select2" id="cod_celular" style="float: left;">
                                                <option value="0">Cod</option>
                                                <?php
                                                $res_cod_tele = $obj_chof->codTelefono('tipo=2');
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
                            </tr>
                            <tr>
                                <td height="86" colspan="4" align="center"> 
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos de Vehiculo
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr  height="45">
                                <td class="letras"> Placa  </td>
                                <td>
                                    <div id="div_placa" class="form-group">
                                        <input type="text" class="form-control  input-sm" id="placa" name="placa" placeholder="Placa"/>
                                    </div>
                                </td>
                            </tr>
                            <tr height="35">
                                <td class="letras"> Modelo </td>
                                <td>
                                    <div id="div_modelo" class="form-group">
                                        <input type="text" class="form-control input-sm" id="modelo" name="modelo" placeholder="Modelo">
                                    </div>
                                </td>
                            </tr>
                            <tr height="35">
                                <td class="letras"> Color </td>
                                <td>
                                    <div id="div_color" class="form-group">
                                        <input type="text" class="form-control input-sm" id="color" name="color" placeholder="Color">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center"> 
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
>>>>>>> 287b2d82a1880b0f76d2b16dfba4a13ba33624b4
</html>