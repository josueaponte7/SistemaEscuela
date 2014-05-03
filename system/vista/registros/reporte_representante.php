<?php
require_once '../../modelo/Representante.php';
$obj_repre       = new Representante();
$datos['campos'] = "cedula,CONCAT_WS(' ',nombre,apellido) AS nombres,sexo";
$resultado       = $obj_repre->getRepresentantes($datos);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>jQuery Modal Contact Demo</title>
        <meta name="author" content="Jake Rocheleau">
        <link href="../../librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
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
                
                
               /* $(".parentesco").change(function() {
                    var valor = $(this).val();
                    alert($(this).index());
                    if(valor ==1 || valor == 2){
                        $('select.parentesco option[value="'+valor+'"]').prop('disabled',true);
                    }else{
                        $('select.parentesco option[value="1"]').prop('disabled',false);
                    }
                    
                })*/
                
                
                $('#asignar_rep').click(function() {
                    var nodes = TReporterepre.fnGetNodes();
                    var countCheck = $('input:checkbox[name="repre[]"]:checked', nodes).length;
                    var countRadio = $('input:radio[name="representant"]:checked', nodes).length;
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
                        var checkboxValues = [];
                        $('input:checkbox:checked', nodes).each(function() {
                            var $chkbox = $(this);
                            var $actualrow = $chkbox.closest('tr');
                            var $clonedRow = $actualrow.clone();

                            $clonedRow.find("select").each(function(i) {
                                this.selectedIndex = $actualrow.find("select")[i].selectedIndex;
                            });
                            //.TTbl_Repre.fnAddData([codigo, estado, $('#nombre_municipio').val(), modificar, eliminar]);
                            $($clonedRow).prependTo($iframe.find('table#tbl_repre tbody'));
                            $iframe.find('table#tbl_repre').css('display', 'block');

                        });
                        $iframe.find('table#tbl_repre tbody tr:last ').remove();
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
                            for ($i = 0; $i < count($resultado); $i++) {
                                ?>
                                <tr>
                                    <td id="<?php echo $resultado[$i]['sexo'] ?>"><input type="checkbox" name="repre[]" value="<?php echo $resultado[$i]['cedula'] ?>" /></td>
                                    <td><?php echo $resultado[$i]['cedula'] ?></td>
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