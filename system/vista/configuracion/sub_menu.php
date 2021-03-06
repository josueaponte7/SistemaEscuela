<?php
session_start();
require_once '../../modelo/SubMenu.php';
$obj_submenu = new SubMenu();

$d_submenu['sql'] = 'SELECT  
                        sbm.id_submenu,  
                        me.nombre_menu AS menu,  
                        sbm.nombre_submenu,  
                        sbm.url,  
                        sbm.activo 
                        FROM sub_menu sbm
                        INNER JOIN menu me ON sbm.id_menu = me.id_menu';
$resul_submenu    = $obj_submenu->getSubMenu($d_submenu);


$_SESSION['menu']        = 'configuracion_sub_menu';
$_SESSION['dir_sys']     = 'configuracion';
$_SESSION['archivo_sys'] = 'sub_menu';
$_SESSION['height']      = '700px';
$_SESSION['heightifm']   = '540px';
$_SESSION['abrir']       = 'configuracion';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sub Men&uacute;</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8">
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2-bootstrap.css"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/script/sub_menu.js"></script>
    </head>
    <body>
        <div id="reporte_submenu" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Sub_Men&uacute;
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Sub Men&uacute;</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_submenu" align="center" name="tabla_submenu">
                    <thead>
                        <tr class="letras">                            
                            <th style="width: 35%">Cod. Sub Men&uacute;</th>
                            <th width="81">Nombre Men&uacute;</th>
                            <th width="81">Nombre Sub Men&uacute;</th>
                            <th width="81">Status</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $es_array                = is_array($resul_submenu) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resul_submenu); $i++) {

                                $estatus = 'Activo';
                                if ($resul_submenu[$i]['activo'] == 0) {
                                    $estatus = 'Inactivo';
                                }
                                ?>
                                <tr class="letras">
                                    <td><?php echo $resul_submenu[$i]['id_submenu']; ?></td>
                                    <td><?php echo $resul_submenu[$i]['menu']; ?></td>
                                    <td><?php echo $resul_submenu[$i]['nombre_submenu']; ?></td>
                                    <td id="<?php echo $resul_submenu[$i]['activo']; ?>"><?php echo $estatus; ?></td>
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

        <div id="registro_submenu" style="display: none">
            <form id="frmsubmenu" name="frmsubmenu"  role="form"> 
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Registro de Sub Men&uacute;</div>
                    <div class="panel-body">
                        <table width="887" border="0" align="center">                        
                            <tr>
                                <td height="72" colspan="4" align="center">
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos del Sub Men&uacute;
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td class="letras"> Men&uacute;: </td>
                                <td>
                                    <div class="form-group">
                                        <select name="menu_comb" class="form-control input-sm select2" id="menu_comb" style="width: 250px !important;">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_submenu->getMenu();
                                        
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_menu']; ?>"><?php echo $resultado[$i]['nombre_menu']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                                <td width="65" class="letras"> Sub Men&uacute;: </td>
                                <td width="303">
                                    <div id="div_subme" class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="nombre_submenu" name="nombre_submenu" placeholder="Nombre del Men&uacute;"/>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td width="45" class="letras"> URL: </td>
                                <td width="410">
                                    <div id="div_url" class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="url" name="url" placeholder="Nombre de la URL"/>
                                    </div>
                                </td>
                                <td width="57" class="letras"> Status: </td>
                                <td width="303">
                                    <div id="div_nombre" class="form-group">
                                        <select  name="estatus" class="form-control input-sm select2" id="estatus">
                                            <option value="2">Seleccione</option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center"> 
                                    <div id="botones" style="margin-top: 50px;">
                                        <input type="hidden" name="accion" value="agregar" id="accion"/>                                    
                                        <button type="button" id="guardar" class="btn btn-primary btn-sm" >Guardar</button>
                                        <button type="button" id="limpiar" class="btn btn-primary btn-sm" >Limpiar</button>
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