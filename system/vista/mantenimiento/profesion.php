<?php
session_start();
require_once '../../modelo/Profesion.php';
$obj_prof = new Profesion();

$d_profesion['campos'] = 'pf.id_profesion,  pf.nombre_profesion';
$resul_profesion = $obj_prof->getProfesion($d_profesion);


$_SESSION['menu']        = 'mantenimiento_profesion';
$_SESSION['dir_sys']     = 'mantenimiento';
$_SESSION['archivo_sys'] = 'profesion';
$_SESSION['height']      = '880px';
$_SESSION['heightifm']   = '830px';
$_SESSION['abrir']       = 'mantenimiento';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Programa Social</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
		<link href="../../librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/script/profesion.js"></script>
    </head>
    <body>  
        <div id="reporte_profesion" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Profesi&oacute;n
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Profesi&oacute;n</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_profesion" align="center" name="tabla_profesion">
                    <thead>
                        <tr class="letras">
                             <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">C&oacute;digo Profesi&oacute;n</th>
                            <th width="81">Nombre Profesi&oacute;n</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $es_array = is_array($resul_profesion) ? TRUE : FALSE;
                        if($es_array === TRUE){
                        for ($i = 0; $i < count($resul_profesion); $i++) {
                            ?>
                        <tr class="letras">
                                <td>
                                    <input type="checkbox" id="<?php echo $resul_profesion[$i]['id_profesion']; ?>" name="id_profesion[]" value="<?php echo $resul_profesion[$i]['id_profesion']; ?>" />
                                </td>
                                <td><?php echo $resul_profesion[$i]['id_profesion']; ?></td>                            
                                <td><?php echo $resul_profesion[$i]['nombre_profesion']; ?></td>
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

        <div id="registro_profesion" style="display: none">
            <form id="frmprofesion"  name="frmprofesion" role="form">
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Profesi&oacute;n</div>
                    <div class="panel-body">
                        <table width="376" border="0" align="center" style="margin-top: 25px;">                         
                            <tr>
                                <td height="49" class="letras"> Nombre de la Profesi&oacute;n: </td>
                                <td align="center">
                                    <div id="div_prof" class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="nombre_profesion" name="nombre_profesion" placeholder="Nombre de la Profesi&oacute;n"/>
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

