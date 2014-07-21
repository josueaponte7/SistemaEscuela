<?php
session_start();
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/Estudiante.php';
require_once '../../modelo/Representante.php';
require_once '../../modelo/DatosGenerales.php';
require_once '../../modelo/Seguridad.php';

$obj_parro = new Parroquia();
$obj_dat   = new Estudiante();
$obj_datos = new Representante();
$obj_misi  = new DatosGenerales();
$obj_datosge = new Seguridad();

$_SESSION['menu']      = 'registros_datos_generales';
$_SESSION['dir_sys']       = 'registros';
$_SESSION['archivo_sys']   = 'datos_generales';
$_SESSION['height']    = '1800px';
$_SESSION['heightifm'] = '1700px';
$_SESSION['abrir']     = 'registros';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Datos Generales</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/datepicker3.css" rel="stylesheet" media="screen"/> 
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2-bootstrap.css"/>

        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../librerias/js/formToWizard.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.es.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/js/tab.js"></script>
        <script type="text/javascript" src="../../librerias/script/datos_generales.js"></script>
        <style>
            #steps { list-style:none; width:100%; overflow:hidden; margin:0px; padding:0px;}
            #steps li {font-size:24px; float:left; padding:10px; color:#b0b1b3;}
            #steps li span {font-size:11px; display:block;}
            #steps li.current { color:#2781D5;}
        </style>
    </head>
    <body>  
        <div id="reporte_datosge" style="display: block;margin: auto;padding-bottom: 80px;">
            <fieldset>
                <legend class="letras_label"> 
                    Listado de Datos Generales 
                </legend>
            </fieldset>
            <button type="button" id="registrar" class="btn btn-primary btn-sm" style="margin-left: 640px;" >Registrar Datos Generales</button>
            <br/>
            <br/>
            <br/>
            <br/>
            <div style="width: 95%;margin-left: auto;margin-right: auto">
                <table style="width:100%;" border="0" class="dataTable" id="tabla_datosge" align="center" name="tabla_datosge">
                    <thead>
                        <tr>
                            <th style="width: 35%">C&eacute;dula</th>
                            <th width="150">Nombre</th>
                            <th width="150">Apellido</th>
                            <th style="width: 5%;text-align: center">Modificar</th>
                            <th style="width: 5%;text-align: center">Eliminar</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>                           
                            <td>13575772</td>
                            <td>holaaa</td>                            
                            <td>holaertt</td>  
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
        
        <div id="registro_datosge" style="display: block">
        <form name="frmdatosgenerales" id="frmdatosgenerales"  role="form" >
            <div class="panel panel-default" style="width : 97%;margin: auto;height: auto;position: relative;">
                <div class="panel-heading letras_titulos">Datos Generales del Estudiante</div>
                <div class="panel-body">
                    <table width="711" border="0" align="center">
                        <tr>
                            <td width="79" height="50" class="letras">Estudiante</td>
                            <td width="741"> 
                                <select  name="datos" class="form-control input-sm select2" id="datos">
                                    <option value="0">Seleccione</option>
                                    <?php
                                    $datos['campos']       = "CONCAT_WS( '  ',cedula, nombre,apellido) AS datos";
                                    $resul                 = $obj_dat->datos($datos);
                                    for ($i = 0; $i < count($resul); $i++) {
                                        ?>
                                        <option value="<?php echo $resul[$i]['datos']; ?>"><?php echo $resul[$i]['datos']; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td height="86" colspan="2" align="center">
                                <fieldset>
                                    <legend class="letras_label"> 
                                        Datos de Inscripci&oacute;n
                                    </legend>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <table width="706">
                                    <tr height="60">
                                        <td width="88" class="letras"> Actividad </td>
                                        <td width="279">
                                            <div class="form-group">
                                                <input type="text" class="form-control  input-sm" id="cedula_d" name="cedula_d" placeholder="Cédula del Estudiante"/>
                                            </div>
                                        </td>
                                        <td width="63" class="letras"> Nombres </td>
                                        <td width="256">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm" id="nombre" name="nombre" placeholder="Nombres del Estudiante" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="40">
                                        <td class="letras"> Fecha de Naci</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm" id="fech_naci" name="fech_naci" placeholder="Fecha de Nacimiento" />
                                            </div>
                                        </td>
                                        <td class="letras"> Edad</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm" id="edad" name="edad" placeholder="Edad" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="60">
                                        <td class="letras"> Sexo </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm" id="sexo" name="sexo" placeholder="Sexo" />
                                            </div>
                                        </td>
                                        <td class="letras"> Tel&eacute;fono</td>
                                        <td>
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <select name="cod_telefono" class="form-control input-sm select2" id="cod_telefono" style="float: left;">
                                                        <option value="0">Cod</option>
                                                        <?php
                                                        $res_cod_tele = $obj_datosge->codTelefono('tipo=1');
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
                                    <tr height="60">
                                        <td height="68" class="letras">Lugar de Naci </td>
                                        <td colspan="3">
                                            <div class="form-group">
                                                <textarea name="lugar_naci" rows="2"  class="form-control input-sm"  id="lugar_naci" placeholder="Lugar de Nacimiento"></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="60">
                                        <td height="64" class="letras"> Direcci&oacute;n</td>
                                        <td colspan="3">
                                            <div class="form-group">
                                                <textarea name="direccion" rows="2"  class="form-control input-sm"  id="direccion"  placeholder="Dirección"></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <fieldset>
                                    <legend class="letras_label"> Datos de la Madre, Padre o Representante </legend>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <td height="120" colspan="2" align="center">
                                <table width="706">
                                    <tr height="60">
                                        <td width="83" class="letras"> C&eacute;dula </td>
                                        <td width="284">
                                            <div class="form-group">
                                                <input type="text" class="form-control  input-sm" id="cedula_r" name="cedula_r" placeholder="Cédula del Estudiante"/>
                                            </div>
                                        </td>
                                        <td width="67" class="letras"> Nombres </td>
                                        <td width="252">
                                            <div class="form-group">
                                                <input  type="text" class="form-control input-sm" id="nombre" name="nombre" placeholder="Nombres del Estudiante" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="40">
                                        <td class="letras"> Apellidos</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm" id="fech_naci" name="fech_naci" placeholder="Fecha de Nacimiento" />
                                            </div>
                                        </td>
                                        <td class="letras"> Parentesco </td>
                                        <td>
                                            <div class="form-group">
                                                <input  type="text" class="form-control input-sm" id="edad" name="edad" placeholder="Edad" />
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="61" colspan="2">
                                <fieldset>
                                    <legend class="letras_label"> Otros Datos </legend>
                                </fieldset>
                            </td>
                        </tr>
                        <!--Inicio Tabs1 -->
                        <tr>
                            <td height="65" colspan="2" align="center">
                                <table width="706">
                                <tr>
                                <td>
                                    <div id="main">
                                        <div id="SignupForm">
                                            <fieldset class="paso">
                                              <legend>Padre, Madre o Representante</legend>
                                                <table>
                                                <tr>
                                                  <td align="center">
                                                  <table style="width:100%" border="0">
                                                    <tr>
                                                      <th height="39" class="letras">Fallecido</th>
                                                      <td class="letras"><input type="checkbox" name="represent_f" id="padre_f">
                                                        <label>Padre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="represent_f" id="madre_f">
                                                        <label>Madre </label></td>
                                                      <th class="letras">Privados de Libertad</th>
                                                      <td class="letras"><input type="checkbox" name="represent_pl" id="padre_pl">
                                                        <label>Padre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="represent_pl" id="madre_pl">
                                                        <label>Madre </label></td>
                                                    </tr>
                                                    <tr>
                                                      <th height="37" class="letras">Alcoh&oacute;licos</th>
                                                      <td class="letras"><input type="checkbox" name="padre_al" id="padre_al">
                                                        <label>Padre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="madre_al" id="madre_al">
                                                        <label>Madre </label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="representante_al" id="representante_al">
                                                        <label>Representante</label></td>
                                                      <th class="letras">F&aacute;rmaco Dependiente</th>
                                                      <td class="letras"><input type="checkbox" name="padre_fd" id="padre_fd">
                                                        <label>Padre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="madre_fd" id="madre_fd">
                                                        <label>Madre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="representante_fd" id="representante_fd">
                                                        <label>Representante</label></td>
                                                    </tr>
                                                  </table></td>
                                                </tr>
                                                <tr>
                                                  <td align="center">
                                                    <fieldset>
                                                <legend class="letras">Estudios</legend>
                                            </fieldset>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td align="center">
                                                  <table style="width:100%" border="0">
                                                    <tr>
                                                      <th  class="letras">Alfabetizados</th>
                                                      <td  class="letras"><input type="checkbox" name="repre_alf" id="padre_alf">
                                                        <label>Padre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="repre_alf" id="madre_alf">
                                                        <label>Madre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="repre_alf" id="representante_alf">
                                                        <label>Representante</label></td>
                                                      <th height="26" class="letras">Analfabeta</th>
                                                      <td height="26" class="letras"><input type="checkbox" name="repre_anl" id="padre_anl">
                                                        <label>Padre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="repre_anl" id="madre_anl">
                                                        <label>Madre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="repre_anl" id="representante_anl">
                                                        <label>Representante</label></td>
                                                    </tr>
                                                  </table></td>
                                                </tr>
                                                <tr>
                                                  <td align="center">
                                                    <fieldset>
                                                <legend class="letras">Nivel Instruci&oacute;n </legend>
                                            </fieldset>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td align="center"><table width="691" border="0" align="center">
                                                    <tr>
                                                      <td class="letras">Padre: </td>
                                                      <td><div class="form-group">
                                                        <select style="width: 130px;" name="padre_nivel" class="form-control input-sm" id="padre_nivel">
                                                          <option value="0">Seleccione</option>
                                                          <?php
                                                                        $resultado = $obj_datos->nivelInst();
                                                                        for ($i = 0; $i < count($resultado); $i++) {
                                                                            ?>
                                                          <option value="<?php echo $resultado[$i]['id_nivel']; ?>"><?php echo $resultado[$i]['nombre_nivel']; ?></option>
                                                          <?php
                                                                        }
                                                                        ?>
                                                        </select>
                                                      </div></td>
                                                      <td class="letras">Madre: </td>
                                                      <td><div class="form-group">
                                                        <select style="width: 130px;" name="madre_nivel" class="form-control input-sm" id="madre_nivel">
                                                          <option value="0">Seleccione</option>
                                                          <?php
                                                                        $resultado = $obj_datos->nivelInst();
                                                                        for ($i = 0; $i < count($resultado); $i++) {
                                                                            ?>
                                                          <option value="<?php echo $resultado[$i]['id_nivel']; ?>"><?php echo $resultado[$i]['nombre_nivel']; ?></option>
                                                          <?php
                                                                        }
                                                                        ?>
                                                        </select>
                                                      </div></td>
                                                      <td class="letras">Representante: </td>
                                                      <td><div class="form-group">
                                                        <select style="width: 130px;" name="representante_nivel" class="form-control input-sm" id="representante_nivel">
                                                          <option value="0">Seleccione</option>
                                                          <?php
                                                                        $resultado = $obj_datos->nivelInst();
                                                                        for ($i = 0; $i < count($resultado); $i++) {
                                                                            ?>
                                                          <option value="<?php echo $resultado[$i]['id_nivel']; ?>"><?php echo $resultado[$i]['nombre_nivel']; ?></option>
                                                          <?php
                                                                        }
                                                                        ?>
                                                        </select>
                                                      </div></td>
                                                    </tr>
                                                  </table></td>
                                                </tr>
                                                <tr>
                                                  <td align="center">
                                                   <fieldset>
                                                <legend class="letras">Situaci&oacute;n Econ&oacute;mica </legend>
                                            </fieldset>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td align="center">
                                                  <table style="width:100%" border="0">
                                                    <tr>
                                                      <th height="39" class="letras">Trabajan</th>
                                                      <td class="letras"><input type="checkbox" name="repres_se" id="padre_se">
                                                        <label>Padre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="repres_se" id="madre_se">
                                                        <label>Madre</label></td>
                                                      <th class="letras">Estudiantes</th>
                                                      <td class="letras"><input type="checkbox" name="repre_se" id="padre_se">
                                                        <label>Padre</label>
                                                        &nbsp;&nbsp;
                                                        <input type="checkbox" name="repre_se" id="madre_pse">
                                                        <label>Madre</label></td>
                                                    </tr>
                                                  </table></td>
                                                </tr>
                                                <tr>
                                                  <td align="center">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                <td width="688" align="center">&nbsp;</td>
                                                </tr>
                                                </table>
                                            </fieldset>
                                            <fieldset class="paso">
                                                <legend>Misiones</legend>
                                            </fieldset>
                                            <fieldset class="paso">
                                                <legend>Vivienda</legend>
                                            </fieldset>
                                            <fieldset class="paso">
                                                <legend>Diversidad Funcional</legend>
                                            </fieldset>
                                        </div>
                                    </div>
                                </td>
                                </tr>
                                </table>
                            </td>
                        </tr> 
                        <!-- Inicio del Tabs-->
                        <tr>
                            <td height="400" colspan="2" >

                            </td>
                        </tr>
                        <!--Fin Tabs1 -->
                        <tr>
                            <td colspan="2" align="center"> 
                                <div id="botones" style="margin-top: 50px;">
                                    <input type="hidden" name="accion" value="agregar" id="accion"/>
                                        <button type="button" id="guardar" class="btn btn-primary btn-sm">Guardar</button>
                                        <button type="button" id="limpiar" class="btn btn-primary btn-sm">Limpiar</button>
                                        <button type="button" id="salir" class="btn btn-primary btn-sm">Salir</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>  
            </div>
    </body>
</html>

