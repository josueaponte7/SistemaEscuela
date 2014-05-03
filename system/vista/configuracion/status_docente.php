<?php
session_start();
require_once '../../modelo/StatusDocente.php';
$obj_statusDoc = new StatusDocente();

$d_statusdoc['campos'] = 'esdoc.id_estatus, esdoc.nombre';
$resul_statusdoc = $obj_statusDoc->getStdoc($d_statusdoc);


$_SESSION['menu']        = 'configuracion_status_docente';
$_SESSION['dir_sys']     = 'configuracion';
$_SESSION['archivo_sys'] = 'status_docente';
$_SESSION['height']      = '700px';
$_SESSION['heightifm']   = '540px';
$_SESSION['abrir']       = 'configuracion';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Status del Docente</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/> 

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/script/status_docente.js"></script>
    </head>
    <body>  
        <div id="reporte_statusdoc" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Status del Docente
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Status</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_statusdoc" align="center" name="tabla_statusdoc">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">Codigo Status</th>
                            <th width="81">Status Docente</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                         $es_array = is_array($resul_statusdoc) ? TRUE : FALSE;
                        if($es_array === TRUE){
                        for ($i = 0; $i < count($resul_statusdoc); $i++) {
                            ?>
                        <tr class="letras">
                                <td>
                                    <input type="checkbox" id="<?php echo $resul_statusdoc[$i]['id_estatus']; ?>" name="id_estatus[]" value="<?php echo $resul_statusdoc[$i]['id_estatus']; ?>" />
                                </td> 
                                <td><?php echo $resul_statusdoc[$i]['id_estatus']; ?></td>                            
                                <td><?php echo $resul_statusdoc[$i]['nombre']; ?></td>
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

        <div id="registro_statusdoc" style="display: none">
            <form id="frmstatus_docente"  name="frmstatus_docente" role="form">
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Status del Docente</div>
                    <div class="panel-body">
                        <table width="376" border="0" align="center" style="margin-top: 25px;">                         
                            <tr>
                                <td width="90" class="letras"> Status Docente </td>
                                <td width="276"  align="center">
                                    <div id="div_statusdocen" class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="nombre" name="nombre" placeholder="Nombre del Status"/>
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