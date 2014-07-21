<?php 

require_once '../../modelo/Ciudad.php';
$obj_ciu = new Ciudad;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Usuario</title>
        <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8"> 
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/estilos.css" rel="stylesheet" media="screen"/>        
        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/ciudad.js"></script>
    </head>
    <body>  
        <form id="frmciudad" class="form-horizontal" role="form">
            <div id="cabezera_form">
                <h1>Formulario de Ciudad</h1>
            </div>
            <div class="panel panel-default" style="width : 90%;margin: auto;height: auto;position: relative; top:25px; left: -10px;">
                <div class="panel-heading" style="font-weight: bold;font-size: 12px; font-family: Arial,'OpenSans',Tahoma,Geneva,sans-serif;">Registro de Ciudad</div>
                <div class="panel-body">
                    <table width="681" border="0" align="center">
                        <tr>
                            <td width="675" align="center">                          
                                <table>
                                    <tr>
                                        <td class="letras">
                                            Estado
                                        </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <select name="estado" class="form-control input-sm" id="estado">
                                                    <option value="0">Seleccione</option>
                                                   <?php
                                                    $resultado = $obj_ciu->getEstados();
                                                    for ($i = 0; $i < count($resultado); $i++) {
                                                        ?>
                                                        <option value="<?php echo $resultado[$i]['id_estado'];?>"><?php echo $resultado[$i]['nombre_estado'];?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>                                                
                                            </div> 
                                        </td>
                                    </tr>
                                    <tr  height="45">
                                        <td class="letras">
                                            Ciudad
                                        </td>
                                        <td>
                                            <div class="col-sm-10">
                                                <input style="width: 300px;" type="text" class="form-control input-sm" id="nombre_ciudad" name="nombre_ciudad" placeholder="Nombre de Ciudad"/>
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