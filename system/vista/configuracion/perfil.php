<?php
session_start();
require_once '../../modelo/Perfil.php';
$obj_perfil= new Perfil();

$d_perfil['sql'] = 'SELECT  id_perfil,  nombre_usuario,  nombre,  apellido,  email,  grupo_usuario,  contrasena,  confirmar_contrasena,  estatus FROM perfil';
$resul_perfil    = $obj_perfil->getPerfil($d_perfil);


$_SESSION['menu']        = 'configuracion_perfil';
$_SESSION['dir_sys']     = 'configuracion';
$_SESSION['archivo_sys'] = 'perfil';
$_SESSION['height']      = '700px';
$_SESSION['heightifm']   = '540px';
$_SESSION['abrir']       = 'configuracion';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Perfil</title>
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
        <script type="text/javascript" src="../../librerias/script/perfil.js"></script>
    </head>
    <body>
        <div id="reporte_perfil" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Perfil
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Perfil</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_menu" align="center" name="tabla_menu">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th style="width: 35%">Codigo Perfil</th>
                            <th width="81">Grupo Usuario</th>
                            <th width="81">Menu</th>
                            <th width="81">Status</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $es_array                = is_array($resul_perfil) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resul_perfil); $i++) {

                                $estatus = 'Activo';
                                if ($resul_perfil[$i]['activo'] == 0) {
                                    $estatus = 'Inactivo';
                                }
                                ?>
                                <tr class="letras">
                                    <td>
                                        <input type="checkbox" id="<?php echo $resul_perfil[$i]['id_perfil']; ?>" name="id_perfil[]" value="<?php echo $resul_perfil[$i]['id_perfil']; ?>" />
                                    </td>
                                    <td><?php echo $resul_perfil[$i]['id_perfil']; ?></td>
                                    <td id="<?php echo $resul_perfil[$i]['id_grupo']; ?>"><?php echo $resul_perfil[$i]['nombre_grupo']; ?></td>
                                    <td id="<?php echo $resul_perfil[$i]['id_menu']; ?>"><?php echo $resul_perfil[$i]['nombre_menu']; ?></td>
                                    <td id="<?php echo $resul_perfil[$i]['activo']; ?>"><?php echo $estatus; ?></td>
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

        <div id="registro_perfil" style="display: none;">
            <form id="frmperfil" name="frmperfil"  role="form"> 
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Registro de Perfil</div>
                    <div class="panel-body">
                        <table width="887" border="0" align="center">                        
                            <tr>
                                <td height="72" colspan="4" align="center">
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos del Perfil
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td class="letras"> Grupo de Usuario: </td>
                                <td>
                                    <div class="form-group">
                                        <select  name="grupo_usuario" class="form-control input-sm select2" id="grupo_usuario">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_perfil->grupoUsuario();
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_grupo']; ?>"><?php echo $resultado[$i]['nombre_grupo']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                                <td width="139" align="right" class="letras"> Men&uacute;: </td>
                                <td width="269">
                                    <div id="" class="form-group">
                                        <select  name="menu_comb" class="form-control input-sm select2" id="menu_comb" style="width: 250px !important;">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_perfil->Menu();
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_menu']; ?>"><?php echo $resultado[$i]['nombre_menu']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="letras"> Sub Men&uacute;: </td>
                                <td>
                                    <div class="form-group">
                                        <select  name="sub_menu" class="form-control input-sm select2" id="sub_menu" style="width: 250px !important;">
                                            <option value="0">Seleccione</option>
                                        </select>
                                    </div>
                                </td>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="147" class="letras"> Acci&oacute;n: </td>
                                <td width="314" colspan="3">
                                    <table style="width: 70%" border="0">
                                    <tr>
                                        <td width="20"><input type="checkbox" name="accion_mod[registrar]" value="1" /></td>
                                        <td width="80">Registrar</td>
                                        <td width="20"><input type="checkbox" name="accion_mod[modificar]" value="2" /></td>
                                        <td width="74">Modificar</td>
                                        <td width="20"><input type="checkbox" name="accion_mod[eliminar]" value="3" /></td>
                                        <td width="73">Eliminar</td>
                                        <td width="20"><input type="checkbox" name="accion_mod[consultar]" value="4" /></td>
                                        <td width="73">Consultar</td>
                                        <td width="20"><input type="checkbox" name="accion_mod[imprimir]" value="5" /></td>
                                        <td width="73">Imprimir</td>
                                    </tr>
                                </table>
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