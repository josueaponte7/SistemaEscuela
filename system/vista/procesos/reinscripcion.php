<?php
session_start();
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/Seguridad.php';
require_once '../../modelo/Estudiante.php';

$obj_parro  = new Parroquia();
$obj_estu   = new Seguridad();
//$obj_estudi = new Estudiante();

//$d_estudianterep ['sql'] = "SELECT 
//                            e.cedula,
//                            e.nombre,
//                            e.apellido,
//                            CONCAT_WS(' ',r.nombre,r.apellido) AS representante
//                            FROM estudiante_representante AS er
//                            INNER JOIN estudiante AS e ON(er.cedula_estudiante=e.cedula AND er.representante=1)
//                            INNER JOIN representante AS r ON(er.cedula_representante=r.cedula AND er.representante=1)";
//
//$resul_estudiante = $obj_estudi->getEstudianterepre($d_estudianterep);

$_SESSION['menu']        = 'procesos_reinscripcion';
$_SESSION['dir_sys']     = 'procesos';
$_SESSION['archivo_sys'] = 'reinscripcion';
$_SESSION['height']      = '980px';
$_SESSION['heightifm']   = '920px';
$_SESSION['abrir']       = 'procesos';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Re-Inscripcion</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/datepicker3.css" rel="stylesheet" media="screen"/> 
        <link href="../../librerias/css/select2.css" rel="stylesheet" type="text/css" />
        <link href="../../librerias/css/select2-bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.es.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/script/reinscripcion.js"></script>       
    </head>
    <body>  
        <div id="reporte_reinscripcion" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Re-Inscripci&oacute;n
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Re-Inscripci&oacute;n</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_reinscripcion" align="center" name="tabla_reinscripcion">
                    <thead>
                        <tr>
                            <th style="width: 35%">C&eacute;dula</th>
                            <th width="150">Nombre</th>
                            <th width="150">Apellido</th>
                            <th width="150">Representante</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>                           
                            <td>13575772</td>
                            <td>Yergiroska</td>
                            <td>Aguirre</td>
                            <td>Reintegro</td> 
                            <td style="text-align: center">
                                <img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>
                            </td>
                            <td style="text-align: center">
                                <img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="registro_reinscripcion" style="display: none">
            <form name="frmreincripcion" id="frmreincripcion"  role="form" >
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Re-Inscripci&oacute;n del Estudiante</div>
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
                                <td width="109" height="66" class="letras"> C&eacute;dula </td>
                                <td width="396">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="nacionalidad" class="form-control input-sm select2 " id="nacionalidad" style="float: left;">
                                                <?php
                                                $resul_naci              = $obj_estu->codNacionalidad();
                                                for ($i = 0; $i < count($resul_naci); $i++) {
                                                    ?>
                                                    <option value="<?php echo $resul_naci[$i]['id_nacionalidad']; ?>"><?php echo $resul_naci[$i]['nombre']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control input-sm" id="cedula" name="cedula" placeholder="Cédula"/>
                                        </div>
                                    </div>
                                </td>
                                <td width="90" class="letras"> Nombre </td>
                                <td width="274">
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
                            <tr height="40">
                                <td class="letras"> Fecha de Naci</td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" readonly="readonly" class="form-control input-sm" id="fech_naci" name="fech_naci" placeholder="Fecha de Nacimiento">
                                    </div>
                                </td>
                                <td class="letras"> Lugar de Naci</td>
                                <td>
                                    <div class="form-group">
                                        <input  type="text" class="form-control input-sm" id="lugar_naci" name="lugar_naci" placeholder="Lugar de Nacimiento">
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
                                <td>
                                    <div class="form-group">
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
                                <td height="64" class="letras"> Barrio o Urb </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="barrio" name="barrio" placeholder="Barrio o Urbanización">
                                    </div>
                                </td>
                                <td class="letras"> Tel&eacute;fono Hab </td>
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="cod_telefono" class="form-control input-sm select2" id="cod_telefono" style="float: left;">
                                                <option value="0">Cod</option>
                                                <?php
                                                $res_cod_tele = $obj_estu->codTelefono('tipo=1');
                                                for ($i = 0; $i < count($res_cod_tele); $i++) {
                                                    ?>
                                                    <option value="<?php echo $res_cod_tele[$i]['id']; ?>"><?php echo $res_cod_tele[$i]['codigo']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control input-sm" id="telefono" name="telefono" placeholder="Teléfono Hab.."/>
                                        </div>
                                    </div>
                                </td>           
                            </tr>
                            <tr height="35">
                                <td class="letras">Tel&eacute;fono Cel</td>  
                                <td>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select name="cod_celular" class="form-control input-sm select2" id="cod_celular" style="float: left;">
                                                <option value="0">Cod</option>
                                                <?php
                                                $res_cod_tele = $obj_estu->codTelefono('tipo=2');
                                                for ($i = 0; $i < count($res_cod_tele); $i++) {
                                                    ?>
                                                    <option value="<?php echo $res_cod_tele[$i]['id']; ?>"><?php echo $res_cod_tele[$i]['codigo']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>

                                        </div> 
                                        <div class="form-group">
                                            <input  type="text" class="form-control input-sm" id="celular" name="celular" placeholder="Teléfono Celular"/>

                                        </div> 
                                    </div>
                                </td>      
                            </tr>
<!--                            <tr>
                                <td colspan="4">
                                    Botones
                                    <table border="1" align="center" id="tbl_repre" style="margin-left: 200px;display:none">
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
                            </tr>-->
                            <tr>
                                <td colspan="4" align="center"> 
                                    <div id="botones" style="margin-top: 50px;">
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

