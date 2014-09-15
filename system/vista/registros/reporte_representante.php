<?php
require_once '../../modelo/Representante.php';
$obj_repre       = new Representante();
$datos['campos'] = "cedula,CONCAT_WS(' ',nombre,apellido) AS nombres,sexo,IF(cod_telefono='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_telefono),telefono)) AS telefono, 
IF(cod_celular='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_celular),celular)) AS celular";
$datos['condicion'] ='condicion = 1';
$resultado       = $obj_repre->getRepresentantes($datos);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>jQuery Modal Contact Demo</title>
        <meta name="author" content="Jake Rocheleau">
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <link href="../../librerias/css/dataTables.css" rel="stylesheet" media="screen"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2.css"/>
        <link rel="stylesheet" type="text/css" href="../../librerias/css/select2-bootstrap.css"/>
        <script type="text/javascript" src="../../librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../librerias/js/bootbox.min.js"></script>
        <script type="text/javascript" src="../../librerias/js/dataTables.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2.js"></script>
        <script type="text/javascript" src="../../librerias/js/select2_locale_es.js"></script>
        <style type="text/css">
            #parentesco {
                width:150px !important;

            }
            .select2-chosen{
                text-align: left !important;
            }
        </style>
        <script type="text/javascript" >
            $(document).ready(function() {

                $('select').on({
                    change: function() {
                        $(this).removeClass('has-error');
                    }
                });

                var TReporterepre = $('#tbl_representante').dataTable({
                    "iDisplayLength": 5,
                    "iDisplayStart": 0,
                    "sPaginationType": "full_numbers",
                    "bLengthChange": false,
                    "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
                    "aoColumns": [
                        {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                        {"sClass": "center", "sWidth": "15%"},
                        {"sClass": "center", "sWidth": "45%"},
                        {"sWidth": "40%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                        {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                    ]
                });
                $('.parentesco').select2();
   
                $('input:checkbox[name="repre[]"]').on('change', function() {
                    var nodes      = TReporterepre.fnGetNodes();
                    var count      = $('input:checkbox[name="repre[]"]:checked', nodes).length;
                    var $chkbox    = $(this);
                    var $actualrow = $chkbox.closest('tr');
                    var $clonedRow = $actualrow.children('td');
                    var sexo       = $clonedRow.attr('id');
                    if ($(this).is(':checked')) {
                        if(sexo==2){
                            $clonedRow.find('select.parentesco option[value="1"]').text('Padre').val(2);
                            $clonedRow.find('select.parentesco option[value="3"]').text('Abuelo').val(4);
                            $clonedRow.find('select.parentesco option[value="5"]').text('Tio').val(6);
                        }
                        $clonedRow.find('select.parentesco').prop('disabled', false);
                        $clonedRow.find('input:radio.representant').prop('disabled', false);
                    } else {
                        $clonedRow.find('select.parentesco option[value="2"]').text('Madre').val(1);
                        $clonedRow.find('select.parentesco option[value="4"]').text('Abuela').val(3);
                        $clonedRow.find('select.parentesco option[value="6"]').text('Tia').val(5);
                        $clonedRow.find('select.parentesco').select2('val', 0);
                        $clonedRow.find('select.parentesco').select2('val', 0);
                        $clonedRow.find('select.parentesco').prop('disabled', true);
                        $clonedRow.find('input:radio.representant').prop('disabled', true);
                        $clonedRow.find('input:radio.representant').prop('checked', false);
                    }

                    if (count >= 3) {
                        $('input:checkbox[name="repre[]"]:not(:checked)', nodes).prop('disabled', true);
                        //$('input:checkbox[name="repre[]"]:not(:checked)',nodes).closest('tr').find('td').find('select').attr('disabled', true);
                        //$('input:checkbox[name="repre[]"]:not(:checked)',nodes).closest('tr').find('td').find('input:radio').attr('disabled', true);

                    } else {
                        $('input:checkbox[name="repre[]"]:not(:checked)', nodes).prop('disabled', false);
                        //$('input:checkbox[name="repre[]"]:not(:checked)',nodes).closest('tr').find('td').find('select').attr('disabled', false);
                        //$('input:checkbox[name="repre[]"]:not(:checked)',nodes).closest('tr').find('td').find('input:radio').attr('disabled', false)
                    }
                });
                
                
               $(".parentesco").change(function() {
                   
                    var nodes = TReporterepre.fnGetNodes();
                    var este  = $(this);
                    var sel_madre  = $('select.parentesco option:selected[value="1"]',nodes).val();
                    var sel_padre  = $('select.parentesco option:selected[value="2"]',nodes).val();
                    var sel_sele = este.val();
                    
                    var madre_count = $('select.parentesco option:selected[value="1"]',nodes).length;
                    var padre_count = $('select.parentesco option:selected[value="2"]',nodes).length;
                    if(madre_count > 1 && sel_madre == sel_sele){
                        bootbox.alert("Solo puede selecionar una madre");
                        este.select2('val',0);
                    }
                    if(padre_count > 1 && sel_padre == sel_sele){
                        bootbox.alert("Solo puede selecionar un padre");
                        este.select2('val',0);
                    }
                });
                
                
                $('#asignar_rep').click(function() {
                    var nodes = TReporterepre.fnGetNodes();
                    var countCheck  = $('input:checkbox[name="repre[]"]:checked', nodes).length;
                    var countRadio  = $('input:radio[name="representant"]:checked', nodes).length;
                    var countSelect = $('select[name="parentesco[]"] option:gt(0):selected', nodes).length;
                    if (countCheck == 0) {
                        alert("Seleccione minimo un Representante");
                    } else if (countRadio == 0) {
                        alert('Selecione al representante del alumno');
                    } else if (countCheck > 0 && countSelect == 0) {
                        alert('Selecione el parentesco');
                    } else if (countCheck != countSelect) {
                        alert('Selecione todos los parentescos');
                    } else {
                        var $iframe = window.parent.frames[0].$('body');
                        var TEstuRepre = $iframe.find('#tbl_repre').dataTable();
                        //var checkboxValues = [];
                        TEstuRepre.fnClearTable();
                        $('input:checkbox:checked', nodes).each(function() {
                            
                            var $chkbox       = $(this);          
                            var $actualrow    = $chkbox.closest('tr');
                            var checkbox      = '<input type="checkbox" name="repre[]" value="'+$chkbox.val()+'" checked/>';
                            var telefonos     = $actualrow.find('td:eq(1)').attr('id');
                            var nombre        = $actualrow.find('td:eq(2)').text();
                            var parentesco    = $actualrow.find('td:eq(3)').find('select').find('option').filter(':selected').text();
                            var id_parentesco = $actualrow.find('td:eq(3)').find('select').find('option').filter(':selected').val();
                            var ra_marcado    = $actualrow.find('td:eq(4)').find('input:radio[name="representant"]:checked').length;
                            
                            var marcado = '';
                            if(ra_marcado > 0){
                                var marcado = 'checked';
                            }
                            var cedula = '<span class="datos">'+$chkbox.val()+'</span>';
                            var radio  = '<input  type="radio" class="representant" name="representant" value="1" '+marcado+'/>';
                            var newRow = TEstuRepre.fnAddData([checkbox,cedula, nombre,telefonos, parentesco, radio]);
                            
                            // Agregar el id a la fila tblrepresentante en alumno en la cuarta columna
                            var oSettings = TEstuRepre.fnSettings();
                            var nTr       = oSettings.aoData[ newRow[0] ].nTr;
                            $('td', nTr)[4].setAttribute( 'id', id_parentesco );

                            if(ra_marcado > 0){
                                nTr.setAttribute('style','color:#FF0000');
                            }
                            
                            if(ra_marcado > 0){
                               nTr.setAttribute('style','color:red');
                            }   

                        });
                        $iframe.find('table#tbl_repre').css('display', 'block');
                        window.parent.$.fancybox.close();
                    }
                });

            });
        </script>
    </head>
    <body>
        <table border="0" align="center">
            <tr>
                <td width="340">&nbsp;</td>
            </tr>
            <tr>
                <td align="center">
                    <table style="width: 700px !important" class="dataTable" border="0" align="center" id="tbl_representante">
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
                            <?php
                            $es_array                = is_array($resultado) ? TRUE : FALSE;
                        if ($es_array === TRUE) {
                            for ($i = 0; $i < count($resultado); $i++) {
                                    //$telefonos = "";
                                    $telefono = $resultado[$i]['telefono'];
                                    $celular  = $resultado[$i]['celular'];

                                    if($telefono != 0 && $celular == 0){
                                        $telefonos =$telefono;
                                    }else if($celular != 0 && $telefono == 0){
                                        $telefonos = $celular;
                                    }else if($telefono != 0 && $celular != 0){
                                        $telefonos = $telefono.','.$celular;
                                    }
                            
                                ?>
                                <tr>
                                    <td id="<?php echo $resultado[$i]['sexo'] ?>"><input type="checkbox" name="repre[]" value="<?php echo $resultado[$i]['cedula'] ?>" /></td>
                                    <td id="<?php echo $telefonos; ?>"><?php echo $resultado[$i]['cedula'] ?></td>
                                    <td><?php echo $resultado[$i]['nombres'] ?></td>
                                    <td>
                                        <select disabled="disabled" style="width: 150px;" name="parentesco[]" class="parentesco">
                                            <option value="0">Seleccione</option>
                                            <option value="1">Madre</option>
                                            <option value="3">Abuela</option>
                                            <option value="5">Tia</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input disabled="disabled" type="radio" class="representant" name="representant" value="1" />
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                            ?>

                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center">&nbsp;</td>
            </tr>
            <tr>
                <td height="55" align="center">
                    <div class="form-group" >
                        <input type="hidden" name="filas" id="filas" value="" />
                        <button type="button" id="asignar_rep" class="btn btn-success">Asignar Representantes</button>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>