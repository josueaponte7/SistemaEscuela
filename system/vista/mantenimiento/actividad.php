<?php
session_start();
require_once '../../modelo/Actividad.php';
$obj_activ = new Actividad();

$d_actividad['campos'] = 'ac.id_actividad,  ac.actividad, ac.descripcion ';
$resul_actividad       = $obj_activ->getActividad($d_actividad);

$_SESSION['menu']        = 'mantenimiento_actividad';
$_SESSION['dir_sys']     = 'mantenimiento';
$_SESSION['archivo_sys'] = 'actividad';
$_SESSION['height']      = '700px';
$_SESSION['heightifm']   = '540px';
$_SESSION['abrir']       = 'mantenimiento';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Actividad</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
		<link href="../../librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>  

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/script/actividad.js"></script>
    </head>
    <body>  
        <div id="reporte_actividad" style="display: block; margin: auto; padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Actividades
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Actividades</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_actividad" align="center" name="tabla_actividad">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">C&oacute;digo Actividad</th>
                            <th width="150">Nombre Actividad</th>
                            <th width="350">Descripci&oacute;n</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                         $es_array = is_array($resul_actividad) ? TRUE : FALSE;
                        if($es_array === TRUE){
                        for ($i = 0; $i < count($resul_actividad); $i++) {
                            ?>
                            <tr class="letras">
                                <td>
                                    <input type="checkbox" id="<?php echo $resul_actividad[$i]['id_actividad']; ?>" name="id_actividad[]" value="<?php echo $resul_actividad[$i]['id_actividad']; ?>" />
                                </td>
                                <td><?php echo $resul_actividad[$i]['id_actividad']; ?></td>                            
                                <td><?php echo $resul_actividad[$i]['actividad']; ?></td>
                                <td><?php echo $resul_actividad[$i]['descripcion'] ?></td>
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

        <div id="registro_actividad" style="display: none">
            <form id="frmactividad"  name="frmactividad" role="form">
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Acitividades</div>
                    <div class="panel-body">
                        <table width="376" border="0" align="center" style="margin-top: 25px;">                         
                            <tr>
                                <td height="49" class="letras"> Nombre de la Actividad: </td>
                                <td align="center">
                                    <div id="div_acti" class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="actividad" name="actividad" placeholder="Nombre de la Actividad"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>                                
                                <td height="49" class="letras"> Descripci&oacute;n </td>
                                <td align="center">
                                    <div id="div_desc" class="form-group">
                                        <textarea  name="descripcion" rows="2"  class="form-control input-sm"  id="descripcion" placeholder="Descripción de la Actividad"></textarea>
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