<?php
session_start();
require_once '../../modelo/Usuario.php';
$obj_usuario = new Usuario();

$d_usuar['sql'] = 'SELECT 
                    u.id_usuario,
                    u.usuario, 
                    u.nombre, 
                    u.apellido, 
                    u.activo, 
                    u.id_grupo,
                    gp.nombre_grupo
                    FROM usuario u 
                    INNER JOIN grupo_usuario gp ON u.id_grupo=gp.id_grupo
                    ORDER BY u.id_usuario';
$resul_usuario     = $obj_usuario->getUsuario($d_usuar);

$_SESSION['menu']        = 'configuracion_usuario';
$_SESSION['dir_sys']     = 'configuracion';
$_SESSION['archivo_sys'] = 'usuario';
$_SESSION['height']      = '700px';
$_SESSION['heightifm']   = '540px';
$_SESSION['abrir']       = 'configuracion';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Usuario</title>
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
        <script type="text/javascript" src="../../librerias/script/usuario.js"></script>
    </head>
    <body>  
        <div id="reporte_usuario" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Usuarios
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 650px;" >Registrar Usuarios</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_usuario" align="center">
                    <thead>
                        <tr class="letras">
                            <th style="margin-left: 20px !important;" width="81">
                                <input type="checkbox" name="todos" id="todos" value="todos" />
                            </th>
                            <th>ID</th>
                            <th style="width: 35%">Usuario</th>
                            <th width="96">Nombre</th>
                            <th width="45">Apellido</th>
                            <th width="35">Status</th>
                            <th width="42">Grupo de Usuario</th>
                            <th width="51" style="width: 5%;text-align: center">Modificar</th>
                            <th width="44" style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                         $es_array = is_array($resul_usuario) ? TRUE : FALSE;
                        if($es_array === TRUE){
                        for ($i = 0; $i < count($resul_usuario); $i++) {

                            $estatus = 'Activo';
                            if ($resul_usuario[$i]['activo'] == 0) {
                                $estatus = 'Inactivo';
                            }
                            ?>
                            <tr class="letras">
                                <td>
                                    <input type="checkbox" id="<?php echo $resul_usuario[$i]['id_usuario']; ?>" name="id_usuario[]" value="<?php echo $resul_usuario[$i]['id_usuario']; ?>" />
                                </td>
                                <td><?php echo $resul_usuario[$i]['id_usuario']; ?></td>
                                <td><?php echo $resul_usuario[$i]['usuario']; ?></td>
                                <td><?php echo $resul_usuario[$i]['nombre']; ?></td>
                                <td><?php echo $resul_usuario[$i]['apellido']; ?></td>
                                <td id="<?php echo $resul_usuario[$i]['activo']; ?>"><?php echo $estatus; ?></td>
                                <td id="<?php echo $resul_usuario[$i]['id_grupo']; ?>"><?php echo $resul_usuario[$i]['nombre_grupo']; ?></td>
                                <td style="text-align: center">
                                    <img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>
                                </td>
                                <td style="text-align: center">
                                    <?php 
                                    if($resul_usuario[$i]['id_usuario'] > 1){
                                    ?>
                                     <img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>
                                    <?php 
                                    }
                                    ?>
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

        <div id="registro_usuario" style="display: none">
            <form name="frmusuario" id="frmusuario"  role="form" >
                <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                    <div class="panel-heading letras_titulos">Usuario</div>
                    <div class="panel-body">
                        <table width="887" border="0" align="center">                        
                            <tr>
                                <td height="72" colspan="4" align="center">
                                    <fieldset style="width: 710px;">
                                        <legend class="letras_label"> 
                                            Datos del Usuario
                                        </legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <td width="99" class="letras"> Usuario </td>
                                <td width="306">
                                    <div id="div_usuario" class="form-group">
                                        <input  type="text" class="form-control  input-sm" id="usuario" name="usuario" placeholder="Nombre de Usuario"/>
                                    </div>
                                </td>
                                <td width="161" class="letras"> Nombre </td>
                                <td width="303">
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
                                <td class="letras"> Grupo de Usuario </td>
                                <td>
                                    <div class="form-group">
                                        <select  name="grupo_usuario" class="form-control input-sm" id="grupo_usuario">
                                            <option value="0">Seleccione</option>
                                            <?php
                                            $resultado = $obj_usuario->grupoUsuario();
                                            for ($i = 0; $i < count($resultado); $i++) {
                                                ?>
                                                <option value="<?php echo $resultado[$i]['id_grupo']; ?>"><?php echo $resultado[$i]['nombre_grupo']; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr height="40">
                                <td class="letras"> Contrase&ntilde;a</td>
                                <td>
                                    <div id="div_contrasena" class="form-group">
                                        <input type="password"  class="form-control input-sm" id="contrasena" name="contrasena" placeholder="Contrase&ntilde;a">
                                    </div>
                                </td>
                                <td class="letras"> Confirmar Contrase&ntilde;a</td>
                                <td>
                                    <div id="div_confirmar" class="form-group">
                                        <input  type="password" class="form-control input-sm" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirmar Contrase&ntilde;a">
                                    </div>
                                </td>
                            </tr>
                            <tr height="60">
                                <td class="letras"> Status </td>
                                <td>
                                    <div class="form-group">
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