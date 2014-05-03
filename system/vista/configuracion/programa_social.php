<?php
session_start();
require_once '../../modelo/ProgramaSocial.php';
$obj_progSoc = new ProgramaSocial();

$d_programa['campos'] = 'ps.id_programa,  ps.nombre_programa';
$resul_programa = $obj_progSoc->getPrograma($d_programa);


$_SESSION['menu']        = 'configuracion_programa_social';
$_SESSION['dir_sys']     = 'configuracion';
$_SESSION['archivo_sys'] = 'programa_social';
$_SESSION['height']      = '880px';
$_SESSION['heightifm']   = '830px';
$_SESSION['abrir']       = 'configuracion';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Programa Social</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/script/programa_social.js"></script>
    </head>
    <body>  
        <div id="reporte_programa" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Programas Sociales
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Programa</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_programa" align="center" name="tabla_programa">
                    <thead>
                        <tr class="letras">
                             <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">Codigo Programa</th>
                            <th width="81">Nombre Programa</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $es_array = is_array($resul_programa) ? TRUE : FALSE;
                        if($es_array === TRUE){
                        for ($i = 0; $i < count($resul_programa); $i++) {
                            ?>
                        <tr class="letras">
                                <td>
                                    <input type="checkbox" id="<?php echo $resul_programa[$i]['id_programa']; ?>" name="id_programa[]" value="<?php echo $resul_programa[$i]['id_programa']; ?>" />
                                </td>
                                <td><?php echo $resul_programa[$i]['id_programa']; ?></td>                            
                                <td><?php echo $resul_programa[$i]['nombre_programa']; ?></td>
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

        <div id="registro_programa" style="display: none">
            <form id="frmprograma_social"  name="frmprograma_social" role="form">
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Programas Sociales</div>
                    <div class="panel-body">
                        <table width="376" border="0" align="center" style="margin-top: 25px;">                         
                            <tr>
                                <td height="49" class="letras"> Nombre del Programa</td>
                                <td align="center">
                                    <div id="div_progra" class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="nombre_programa" name="nombre_programa" placeholder="Nombre del Programa"/>
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

