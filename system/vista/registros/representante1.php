<?php
require_once '../../modelo/Municipio.php';
$obj_estu = new Municipio;


session_start();
$_SESSION['menu']      = 'registros_representante';
$_SESSION['dir']       = 'registros';
$_SESSION['archivo']   = 'representante';
$_SESSION['height']    = '800px';
$_SESSION['heightifm'] = '780px';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Representante</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>  
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/datepicker3.css" rel="stylesheet" media="screen"/> 
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2-bootstrap.css"/>
        
        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap-datepicker.es.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <script type="text/javascript" src="../../librerias/script/representante.js"></script>
    </head>
    <body>  
        <form name="frmrepresentante" id="frmrepresentante"  role="form">
            <div id="cabezera_form">
                <h1>Formulario del Representante</h1>
            </div>


            <div class="panel panel-default" style="width : 94%;margin: auto;height: auto;position: relative; top:25px;">
                <div class="panel-heading" style="font-weight: bold;font-size: 12px; font-family: Arial,'OpenSans',Tahoma,Geneva,sans-serif;">Datos del Representante</div>
                <div class="panel-body">
                    <table width="716">
                        <tr>
                            <td width="987" align="center">                            
                                <table width="707">
                                    <tr>
                                        <td width="82" class="letras">
                                            C&eacute;dula
                                        </td>
                                        <td width="281">
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                        <select name="nacionalidad" class="form-control input-sm" id="nacionalidad" style="width:57px; margin-top: 15px; float: left;">
                                                            <option value="1">V</option>
                                                            <option value="2">E</option>
                                                            <option value="3">P</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <div class="col-sm-10">
                                                        <input style="width: 138px; margin-left: 5px; float: left;" type="text" class="form-control input-sm" id="cedula" name="cedula" placeholder="Cédula"/>
                                                    </div>
                                                </div> 
                                            </div>
                                        </td>

                                        <td width="81" class="letras"> Nombre </td>
                                        <td width="243">
                                            <div class="col-sm-10">
                                                <input style="width: 200px;" type="text" class="form-control  input-sm" id="nombre" name="nombre" placeholder="Nombre"/>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="60">
                                        <td class="letras">
                                            Apellido
                                        </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <input style="width: 200px;" type="text" class="form-control  input-sm" id="apellido" name="apellido" placeholder="Apellido"/>
                                            </div> 
                                        </td>
                                        <td class="letras"> Email </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <input style="width: 200px;" type="text" class="form-control input-sm" id="email" name="email" placeholder="Email">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="40">
                                        <td class="letras">
                                            Fecha de Naci</td>
                                        <td>
                                            <div class="col-sm-10">
                                                <input style="width: 200px;" type="text" readonly="readonly"  class="form-control input-sm" id="fech_naci" name="fech_naci" placeholder="Fecha de Nacimiento">
                                            </div> 
                                        </td>
                                        <td class="letras"> Lugar de Naci</td>
                                        <td>
                                            <div class="col-sm-10">
                                                <input style="width: 200px;" type="text" class="form-control input-sm" id="lugar_naci" name="lugar_naci" placeholder="Lugar de Nacimiento">
                                            </div>
                                        </td>
                                    </tr>                                    
                                </table>                            
                            </td>
                        </tr>    
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="panel panel-default" style="width : 94%;margin: auto;height: auto;position: relative; top:65px;">
                <div class="panel-heading" style="font-weight: bold;font-size: 12px; font-family: Arial,'OpenSans',Tahoma,Geneva,sans-serif;">Dirección</div>
                <div class="panel-body">
                    <table width="796" border="0" align="center">
                        <tr>
                            <td width="1017" align="center">                          
                                <table width="790" height="60">
                                    <tr>
                                        <td width="83" class="letras">
                                            Estado
                                        </td>
                                        <td width="285">
                                            <div class="col-sm-10">
                                                <select style="width: 200px;" name="estado" class="form-control input-sm" id="estado">
                                                    <option value="0">Seleccione</option>
                                                    <?php
                                                    $resultado             = $obj_estu->getEstados();
                                                    for ($i = 0; $i < count($resultado); $i++) {
                                                        ?>
                                                        <option value="<?php echo $resultado[$i]['id_estado']; ?>"><?php echo $resultado[$i]['nombre_estado']; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>                                                
                                            </div> 
                                        </td>
                                        <td width="79" class="letras"> Municipio </td>
                                        <td width="323">
                                            <div class="col-sm-10">
                                                <select style="width: 200px;" name="municipio" class="form-control input-sm" id="municipio">
                                                    <option value="0">Seleccione</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="45">
                                        <td class="letras">
                                            Parroquia
                                        </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <select style="width: 200px;" name="parroquia" class="form-control input-sm" id="parroquia">
                                                    <option value="0">Seleccione</option>
                                                </select>                                               
                                            </div> 
                                        </td>
                                        <td class="letras"> Calle </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <input style="width: 200px;" type="text" class="form-control input-sm" id="calle" name="calle" placeholder="Calle, Avenida o Vereda"/>
                                            </div> 
                                        </td>
                                    </tr>
                                    <tr  height="45">
                                        <td class="letras">
                                            Casa o Apto
                                        </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <input style="width: 200px;" type="text" class="form-control  input-sm" id="casa" name="casa" placeholder="Casa o Apartamento"/>
                                            </div>
                                        </td>
                                        <td class="letras"> Edificio </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <input style="width: 200px;" type="text" class="form-control  input-sm" id="edificio" name="edificio" placeholder="Edificio"/>
                                            </div> 
                                        </td>
                                    </tr>
                                    <tr height="35">
                                        <td class="letras">
                                            Barrio o Urb
                                        </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <input style="width: 200px;" type="text" class="form-control input-sm" id="barrio" name="barrio" placeholder="Barrio o Urbanización">
                                            </div>
                                        </td>
<!--                                        <td class="letras"> Barrio o Urb </td>
                                        <td>
                                            <div class="col-sm-10">
                                          <input style="width: 200px;" type="text" class="form-control input-sm" id="barrio" name="barrio" placeholder="Barrio o Urbanización">
                                        </div>
                                        </td>-->
                                    </tr> 
                                </table>                           

                            </td>
                        </tr>    
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!--                <div class="panel panel-default" style="width : 90%;margin: auto;height: auto;position: relative; top:70px; left: -100px;">
                        <div class="panel-heading" style="font-weight: bold;font-size: 12px; font-family: Arial,'OpenSans',Tahoma,Geneva,sans-serif;">Otros Datos</div>
                        <div class="panel-body">
                            <table width="681" border="0" align="center">
                                <tr>
                                    <td width="675" align="center">
                                        <form class="form-horizontal" role="form">
                                             <div class="form-group">
                                                <label for="status" class="col-sm-3 control-label letras_lebel" style="margin-left: -95px;">Status</label>
                                                <div class="col-sm-5">
                                                    <select name="status" class="form-control" id="status" style="margin-left: 85px;">
                                                        <option value="1">Seleccione</option>
                                                        <option value="2">Activo</option>
                                                        <option value="3">Inactivo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="antecedente" class="col-sm-3 control-label letras_lebel" style="margin-left: -55px;">Antecedentes</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="antecedente"  name="antecedente" placeholder="Antecedentes" style="margin-left: 45px;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                 <label for="alcoholismo" class="col-sm-3 control-label letras_lebel" style="margin-left: -62px;">Alcoholismo</label>  
                                                 <label>
                                                     <input type="checkbox" id="alcoholismo" name="alcoholismo" style="margin-left: -418px;">
                                                </label>
                                            </div>
                                             <div class="form-group">
                                                 <label for="farmaco" class="col-sm-3 control-label letras_lebel" style="margin-left: -8px;">Farmaco Dependiente</label>  
                                                 <label>
                                                     <input type="checkbox" id="farmaco" name="farmaco" style="margin-left: -470px;">
                                                </label>
                                            </div>  
                                            <div class="form-group">
                                                <label for="nivel_inst" class="col-sm-3 control-label letras_lebel" style="margin-left: -25px;">Nivel de Instrucción </label>
                                                <div class="col-sm-5">
                                                    <select name="nivel_inst" class="form-control" id="nivel_inst"  style="margin-left: 15px;">
                                                        <option value="1">Seleccione</option>
                                                        <option value="2">Primaria</option>
                                                        <option value="3">Secundaria</option>
                                                        <option value="3">Bachillerato</option>
                                                        <option value="3">T.S.U</option>
                                                        <option value="3">Ingeniero</option>
                                                    </select>                                        
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="profesion" class="col-sm-3 control-label letras_lebel" style="margin-left: -78px;">Profesión</label>
                                                <div class="col-sm-5">
                                                    <select name="profesion" class="form-control" id="profesion"  style="margin-left: 65px;">
                                                        <option value="1">Seleccione</option>
                                                        <option value="2">Sin Empleo</option>
                                                        <option value="3">Con Empleo</option>
                                                        <option value="4">CEstudiante</option>
                                                        <option value="5">Jubilado</option>
                                                        <option value="6">Pensionado</option>
                                                    </select>                                        
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label for="ingreso" class="col-sm-3 control-label letras_lebel" style="margin-left: -30px;">Fuente de Ingreso</label>
                                                <div class="col-sm-5">
                                                    <input type="text" class="form-control" id="ingreso"  name="ingreso" placeholder="Fuente de Ingreso" style="margin-left: 17px;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="telefono_hab" class="col-sm-3 control-label letras_lebel" style="margin-left: -2px;">Teléfono de Habitación</label>
                                                <div class="col-sm-2">
                                                    <select name="telefono_hab" class="form-control" id="telefono_hab" style="margin-left: -15px;">
                                                        <option value="1">Cod</option>
                                                        <option value="2">0243</option>
                                                        <option value="2">0244</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="telefono_hab" name="telefono_hab" placeholder="Teléfono de Hab.." style="margin-left: -82px; width: 160px;">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label for="telefono_cel" class="col-sm-3 control-label letras_lebel" style="margin-left: -38px;">Teléfono Celular</label>
                                                <div class="col-sm-2">
                                                    <select name="telefono_cel" class="form-control" id="telefono_cel" style="margin-left: 27px;">
                                                        <option value="1">Cod</option>
                                                        <option value="2">0412</option>
                                                        <option value="3">0416</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="telefono_cel" name="telefono_cel" placeholder="Teléfono Cel.." style="margin-left: -5px; width: 160px;">
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                 <label for="beneficiados" class="col-sm-5 control-label letras_lebel" style="margin-left: -38px;">Beneficiado por Programas Sociales</label>                                      
                                            </div> 
                                            <div class="form-group">
                                                <label for="robinson" class="col-sm-5 control-label letras_lebel" style="margin-left: -130px;">Misión Robinson</label>                                      
                                                <div class="checkbox">
                                                    <input type="checkbox" value="1" name="robinson" id="robinson" style="margin-left: -125px;">                                         
                                                </div> 
                                            </div> 
                                             <div class="form-group">
                                                <label for="barrio_adentro" class="col-sm-5 control-label letras_lebel" style="margin-left: -108px; margin-top: -10px;">Misión Barrio Adentro</label>                                      
                                                <div class="checkbox">
                                                    <input type="checkbox" value="1" name="barrio_adentro" id="barrio_adentro" style="margin-left: -148px; margin-top: -10px;"> 
                                                    </label>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label for="guaicaipuro" class="col-sm-5 control-label letras_lebel" style="margin-left: -118px; margin-top: -17px;">Misión Guaicaipuro</label>                                      
                                                <div class="checkbox">
                                                    <input type="checkbox" value="1" name="guaicaipuro" id="guaicaipuro" style="margin-left: -138px; margin-top: -16px;"> 
                                                    </label>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label for="negra" class="col-sm-5 control-label letras_lebel" style="margin-left: -108px; margin-top: -17px;">Misión Negra Hipolita</label>                                      
                                                <div class="checkbox">
                                                    <input type="checkbox" value="1" name="negra" id="negra" style="margin-left: -150px; margin-top: -17px;"> 
                                                    </label>
                                                </div> 
                                            </div>
                                              <div class="form-group">
                                                <label for="vivienda" class="col-sm-5 control-label letras_lebel" style="margin-left: -108px; margin-top: -17px;">Misión Gran Vivienda</label>                                      
                                                <div class="checkbox">
                                                    <input type="checkbox" value="1" name="vivienda" id="vivienda" style="margin-left: -150px; margin-top: -16px;"> 
                                                    </label>
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label for="hijos_vene" class="col-sm-5 control-label letras_lebel" style="margin-left: -38px; margin-top: -17px;">Misión Hijos e Hijas de Venezuela</label>                                      
                                                <div class="checkbox">
                                                    <input type="checkbox" value="1" name="hijos_vene" id="hijos_vene" style="margin-left: -220px; margin-top: -16px;"> 
                                                    </label>
                                                </div> 
                                            </div>
                                            
                                            
                                            
                                            
            
                                            
                                             <div class="checkbox">
                                              
                                             
                                             <div class="checkbox">
                                                <label for="farmaco" class="col-sm-5 control-label letras_lebel" style="margin-left: -38px;">Misión Hijos e Hijas de Venezuela
                                                    <input type="checkbox"> 
                                                </label>
                                            </div>
                                            
                                            
                                        </form>
                                    </td>
                                </tr>    
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                    </div>--> 
            <table style="margin-left: 370px; margin-top: 100px;">
                <tr height="80">
                    <td colspan="2" align="center">
                        <div class="form-group">
                            <button type="button" id="asignar_rep" class="btn btn-success" style="width: 180px; margin-left: -230px; position: relative; color: #FFFFFF; font-weight: bold;">Asignar Estudiantes</button>
                        </div>
                    </td> 
                    <td colspan="2" align="center">
                        <div class="form-group">
                            <button type="button" id="guardar" class="btn btn-primary" style="width: 80px; margin-left: -10px; position: relative; color: #FFFFFF; font-weight: bold">Guardar</button>
                        </div>
                    </td>          

                    <td colspan="2" align="center">
                        <div class="form-group">
                            <button type="button" id="salir" class="btn btn-primary" style="width: 80px; margin-left: 13px; position: relative; color: #FFFFFF; font-weight: bold">Salir</button>
                        </div>
                    </td>
                </tr>
            </table>
        </form>        
    </body>
</html>

