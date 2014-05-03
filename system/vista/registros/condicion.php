<!DOCTYPE html>
<html>
    <head>
        <title>Condici&oacute;n</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>        
        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
<!--        <script type="text/javascript" src="../../librerias/js/estado.js"></script>-->
    </head>
    <body>  
        <form id="frmcondicion" name="condicion" class="form-horizontal" role="form">
            <div id="cabezera_form">
                <h1>Formulario de Condiciones</h1>
            </div>
            <div class="panel panel-default" style="width : 90%;margin: auto;height: auto;position: relative; top:25px; left: -10px;">
                <div class="panel-heading" style="font-weight: bold;font-size: 12px; font-family: Arial,'OpenSans',Tahoma,Geneva,sans-serif;">Datos de la Condición</div>
                <div class="panel-body">                
                    <table width="681" border="0" align="center">
                        <tr>
                            <td width="675" align="center">
                                <table width="660">
                                    <tr>
                                        <td width="95" height="66" class="letras">
                                            Nombre
                                        </td>
                                        <td width="267">
                                            <div class="col-sm-10">
                                                <input style="width: 200px;" type="text" class="form-control input-sm" id="nombre" name="nombre" placeholder="Nombre"/>
                                            </div> 
                                        </td>
                                        <td width="68" class="letras"> Tipo </td>
                                        <td width="241"><div class="col-sm-10" style="margin-top: 10px;">
                                                <select style="width: 200px;" name="tipo" class="form-control input-sm" id="tipo">
                                                    <option value="0">Seleccione</option>
                                                    <option value="1">Condiciones</option>
                                                    <option value="2">Discapacidad</option>
                                                </select>
                                            </div></td>
                                    </tr>
                                    <tr height="48">
                                        <td height="44" class="letras">
                                            Contagio
                                        </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <select style="width: 200px;" name="nivel_con" class="form-control input-sm" id="nivel_con">
                                                    <option value="0">Seleccione</option>
                                                    <option value="2">Contagiosa</option>
                                                    <option value="3">No Contagiosa</option>
                                                </select>                                                
                                            </div>  
                                        </td>
                                        <td class="letras">Fatalidad</td>
                                        <td><div class="col-sm-10" style="margin-top: 10px;">
                                                <select style="width: 200px;" name="tipo" class="form-control input-sm" id="tipo">
                                                    <option value="0">Seleccione</option>
                                                    <option value="1">Condiciones</option>
                                                    <option value="2">Discapacidad</option>
                                                </select>
                                            </div></td>
                                    </tr>
                                    <tr height="45">
                                        <td class="letras"> Descripci&oacute;n </td>
                                        <td width="267" align="left">
                                            <div class="col-sm-10">
                                                <textarea style="width: 200px; resize: none;"  class="form-control input-sm" rows="2"  id="descripcion" placeholder="Descripción"></textarea>
                                            </div>
                                        </td>
                                        <td class="letras"> Hereditaria </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <input style="width: 200px; margin-left: -80px;" type="checkbox" value="1" id="hereditaria" name="hereditaria" >
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
        </form>
		<table style="margin-left: 540px; margin-top: 120px;">
            <tr height="80">
                <td colspan="2" align="center">
                    <div class="form-group">
                        <button type="button" id="guardar" class="btn btn-primary" style="width: 80px; margin-left: -10px; position: relative">Guardar</button>
                    </div>
                </td>          
           
              <td colspan="2" align="center">
                    <div class="form-group">
                        <button type="button" id="salir" class="btn btn-primary" style="width: 80px; margin-left: 13px; position: relative">Salir</button>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>