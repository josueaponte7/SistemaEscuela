<?php
session_start();
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/TipoServicio.php';
require_once '../../modelo/ServicioSalud.php';

$obj_parro = new Parroquia();
$obj_tipo  = new TipoServicio();
$obj_salud = new ServicioSalud();

$d_serviciosa['sql'] = "SELECT sp.id_servicio, sp.servicio, 
                        CONCAT_WS('-',ct.codigo, sp.telefono) AS telefono, ts.tiposervicio 
                        FROM servicio_publico sp 
                        INNER JOIN codigo_telefono ct ON (sp.cod_telefono = ct.id) 
                        INNER JOIN tiposervicio ts ON (sp.id_tiposervicio = ts.id_tiposervicio) ORDER BY sp.id_servicio";

$resul_serviciosa = $obj_salud->getServicio($d_serviciosa);

$_SESSION['menu']        = 'registros_servicio_salud';
$_SESSION['dir_sys']     = 'registros';
$_SESSION['archivo_sys'] = 'servicio_salud';
$_SESSION['height']      = '770px';
$_SESSION['heightifm']   = '720px';
$_SESSION['abrir']       = 'registros';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Servicio Salud</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>  
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
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
        <script type="text/javascript" src="../../librerias/script/servicio_salud.js"></script>        
    </head>
    <body>  
        <div id="reporte_salud" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Centro de Salud P&uacute;blico
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Centro Salud</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_salud" align="center">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">Codigo</th>
                            <th width="150">Centro de Salud</th>
                            <th width="150">Tipo de Centro de Salud</th>
                            <th width="150">Tel&eacute;fono</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $es_array                = is_array($resul_serviciosa) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resul_serviciosa); $i++) {
                                ?>
                                <tr class="letras">
                                    <td>
                                        <input type="checkbox" id="<?php echo $resul_serviciosa[$i]['id_servicio']; ?>" name="id_servicio[]" value="<?php echo $resul_serviciosa[$i]['id_servicio']; ?>" />
                                    </td>
                                    <td><?php echo $resul_serviciosa[$i]['id_servicio']; ?></td>
                                    <td><?php echo $resul_serviciosa[$i]['servicio']; ?></td>
                                    <td><?php echo $resul_serviciosa[$i]['tiposervicio']; ?></td>
                                    <td><?php echo $resul_serviciosa[$i]['telefono']; ?></td>
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
            </div>
        </div>

        <div id="registro_salud" style="display: none">                
            <form name="frmservicio_salud" id="frmservicio_salud"  role="form">
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Centro de Salud P&uacute;blica</div>
                    <div class="panel-body">
                        <table width="887" border="0" align="center">                        
                            <tr>
                                <td height="72" colspan="4" align="center">
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos del Centro de Salud 
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>                            
                                <td width="125" class="letras"> Nombre de Centro </td>
                                <td width="353">
                                    <div id="div_servicio" class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="servicio" name="servicio" placeholder="Nombre de Centro de Salud P&uacute;blica"/>
                                    </div>
                                </td>
                                <td width="96" class="letras"> Tipo  </td>
                                <td width="295">
                                    <div class="form-group">
                                        <select name="tiposervicio" class="form-control input-sm" id="tiposervicio">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_tipo->getTipo();
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_tiposervicio']; ?>"><?php echo $resultado[$i]['tiposervicio']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td height="86" colspan="4" align="center"> 
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Ubicaci&oacute;n del Centro de Salud P&uacute;blica  
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
                                <td class="letras"> Tel&eacute;fono Ubic. </td>
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="cod_telefono" class="form-control input-sm select2" id="cod_telefono" style="float: left;">
                                                <option value="0">Cod</option>
                                                <?php
                                                $res_cod_tele = $obj_salud->codTelefono('tipo=1');
                                                for ($i = 0; $i < count($res_cod_tele); $i++) {
                                                    ?>
                                                    <option value="<?php echo $res_cod_tele[$i]['id']; ?>"><?php echo $res_cod_tele[$i]['codigo']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div  id="div_telefono" class="form-group">
                                            <input type="text" class="form-control input-sm" id="telefono" name="telefono" placeholder="Teléfono Ubicaci&oacute;n" maxlength="7"/>
                                        </div>
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
</html>