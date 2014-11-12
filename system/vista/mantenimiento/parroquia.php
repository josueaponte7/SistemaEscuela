<?php
session_start();
require_once '../../modelo/Parroquia.php';
$obj_parr = new Parroquia;

$d_parroquia['sql'] = 'SELECT 
                            p.id_parroquia,
                            e.id_estado,
                            e.nombre_estado,
                            m.id_municipio,
                            m.nombre_municipio, 
                            p.nombre_parroquia
                            FROM parroquia AS p
                            INNER JOIN municipio AS m ON p.id_municipio=m.id_municipio 
                            INNER JOIN estado AS e ON m.id_estado=e.id_estado ORDER BY p.id_parroquia';

$resul_parroquia = $obj_parr->getParroquia($d_parroquia);

$_SESSION['menu']        = 'mantenimiento_parroquia';
$_SESSION['dir_sys']     = 'mantenimiento';
$_SESSION['archivo_sys'] = 'parroquia';
$_SESSION['height']      = '880px';
$_SESSION['heightifm']   = '830px';
$_SESSION['abrir']       = 'mantenimiento';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Parroquia</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
		<link href="../../librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/> 
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2-bootstrap.css"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="../../librerias/script/parroquia.js"></script>
    </head>
    <body>  

        <div id="reporte_parroquia" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Parroquias
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Parroquias</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_parroquia" align="center" name="tabla_parroquia">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">C&oacute;digo Parroquia</th>
                            <th width="81">Estado</th>
                            <th width="81">Municipio</th>
                            <th style="width: 35%">Parroquia</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                         $es_array = is_array($resul_parroquia) ? TRUE : FALSE;
                        if($es_array === TRUE){
                        for ($i = 0; $i < count($resul_parroquia); $i++) {
                            ?>
                            <tr class="letras">
                                <td>
                                    <input type="checkbox" id="<?php echo $resul_parroquia[$i]['id_parroquia']; ?>" name="id_parroquia[]" value="<?php echo $resul_parroquia[$i]['id_parroquia']; ?>" />
                                </td>
                                <td><?php echo $resul_parroquia[$i]['id_parroquia']; ?></td>  
                                <td id="<?php echo $resul_parroquia[$i]['id_estado']; ?>"><?php echo $resul_parroquia[$i]['nombre_estado']; ?></td>
                                <td id="<?php echo $resul_parroquia[$i]['id_municipio']; ?>"><?php echo $resul_parroquia[$i]['nombre_municipio']; ?></td>
                                <td><?php echo $resul_parroquia[$i]['nombre_parroquia']; ?></td>
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

        <div id="registro_parroquia" style="display: none">
            <form id="frmparroquia" name="frmparroquia" role="form"> 
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Registro de Parroquia</div>
                    <div class="panel-body">
                        <table width="887" border="0" align="center" style="margin-top: 25px;">  
                            <tr>
                                <td width="639" height="84" align="center">
                                    <table width="370" align="center">
                                        <tr>
                                            <td width="62" height="60" class="letras">
                                                Estado:
                                            </td>
                                            <td width="296">
                                                <div class="form-group">
                                                    <select name="estado" class="form-control input-sm select2" id="estado">
                                                        <option value="0">Seleccione</option>
                                                        <?php
                                                        $resultado = $obj_parr->getEstados();
                                                        for ($i = 0; $i < count($resultado); $i++) {
                                                            ?>
                                                            <option value="<?php echo $resultado[$i]['id_estado']; ?>"><?php echo $resultado[$i]['nombre_estado']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select> 
                                                </div>
                                            </td>                                        
                                        </tr>
                                        <td class="letras"> Municipio: </td>
                                        <td>
                                            <div class="form-group">
                                                <select name="municipio" class="form-control input-sm select2" id="municipio">
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </td>
                                        <tr>
                                            <td width="62" class="letras">
                                                Parroquia:
                                            </td>
                                            <td width="296">
                                                <div id="div_parroquia" class="form-group">
                                                    <input type="text" class="form-control input-sm" id="nombre_parroquia" name="nombre_parroquia" placeholder="Nombre de la Parroquia"/>
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4" align="center"> 
                                    <div id="botones" style="margin-top: 50px;">
                                        <input type="hidden" name="accion" value="agregar" id="accion"/>                                    
                                        <button type="button" id="guardar" class="btn btn-primary btn-sm" >Guardar</button>
                                        <button type="reset" id="limpiar" class="btn btn-primary btn-sm" >Limpiar</button>
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