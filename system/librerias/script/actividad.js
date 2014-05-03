$(document).ready(function() {
    var TActividad = $('#tabla_actividad').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%","bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "20%"},
            {"sClass": "center", "sWidth": "25%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    $('#registrar').click(function() {
        $('#registro_actividad').slideDown(2000);
        $('#reporte_actividad').slideUp(2000);
    });
    
    $('#todos').change(function() {
        var TotalRow = TActividad.fnGetData().length;
        var nodes = TActividad.fnGetNodes();
        if(TotalRow > 0){
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_actividad[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_actividad[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });
    
    $('table#tabla_actividad').on('change', 'input:checkbox[name="id_actividad[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TActividad.fnGetNodes();
        var count = $("input:checkbox[name='id_actividad[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('#imprimir').click(function() {
        var url = '../reportes/reporte_actividad.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_actividad[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TActividad.fnGetNodes();
            $("input:checkbox[name='id_actividad[]']:checked", nodes).each(function() {
                var $chkbox = $(this);
                var $actualrow = $chkbox.closest('tr');
                checkboxValues += $actualrow.find('td:eq(1)').text() + ',';
            });
            checkboxValues = checkboxValues.substring(0, checkboxValues.length - 1);
            url = url + '?id=' + checkboxValues;
        }
        window.open(url);
    });

    $('#guardar').click(function() {

        if ($('#actividad').val() === null || $('#actividad').val().length === 0 || /^\s+$/.test($('#actividad').val())) {
            $('#div_acti').addClass('has-error');
            $('#actividad').focus();
        } else {
            if ($('#descripcion').val() === null || $('#descripcion').val().length === 0 || /^\s+$/.test($('#descripcion').val())) {
                $('#div_desc').addClass('has-error');
                $('#descripcion').focus();
            } else {
                $('#accion').val($(this).text());

                // Imagenes de modificar y eliminar
                var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
                var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';

                if ($(this).text() == 'Guardar') {
                    $('#id_actividad').remove();

                    // obtener el ultimo codigo del status 
                    var codigo = 1;
                    var TotalRow = TActividad.fnGetData().length;
                    if (TotalRow > 0) {
                    var lastRow = TActividad.fnGetData(TotalRow - 1);
                    var codigo = parseInt(lastRow[1]) + 1;
                }

                    var $check_actividad = '<input type="checkbox" name="id_actividad[]"  />';

                    var $id_actividad = '<input type="hidden" id="id_actividad"  value="' + codigo + '" name="id_actividad">';
                    $($id_actividad).prependTo($('#frmactividad'));


                    $.post("../../controlador/Actividad.php", $("#frmactividad").serialize(), function(respuesta) {
                        if (respuesta == 1) {
                            window.parent.bootbox.alert("Registro con Exito", function() {

                                // Agregar los datos a la tabla
                                TActividad.fnAddData([$check_actividad, codigo, $('#actividad').val(), $('#descripcion').val(), modificar, eliminar]);

                                $('input[type="text"]').val('');
                                $('textarea').val('');


                            });
                        }
                    });
                } else {
                    window.parent.bootbox.confirm({
                        message: '¿Desea Modificar los datos del Registro?',
                        buttons: {
                            'cancel': {
                                label: 'Cancelar',
                                className: 'btn-default'
                            },
                            'confirm': {
                                label: 'Modificar',
                                className: 'btn-danger'
                            }
                        },
                        callback: function(result) {
                            if (result) {
                                $.post("../../controlador/Actividad.php", $("#frmactividad").serialize(), function(respuesta) {
                                    if (respuesta == 1) {

                                        // obtener la fila a modificar
                                        var fila = $("#fila").val();

                                        window.parent.bootbox.alert("Modificacion con Exito", function() {
                                            // Modificar la fila 1 en la tabla 
                                            $("#tabla_actividad tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#actividad').val());
                                            $("#tabla_actividad tbody tr:eq(" + fila + ")").find("td:eq(3)").html($('#descripcion').val());
                                            $('input[type="text"]').val('');
                                            $('textarea').val('');
                                        });
                                    }
                                });
                            }
                        }
                    });
                }
            }
        }
    });

    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_actividad').slideUp(2000);
        $('#reporte_actividad').slideDown(2000);
        $('#id_actividad').remove();
        $('input:text').val('');
        $('textarea').val('');
    });

    $('#limpiar').click(function() {
        $('#id_actividad').remove();
        $('input:text').val('');
        $('textarea').val('');
        $('#guardar').text('Guardar');
    });

    $('table#tabla_actividad').on('click', 'img.modificar', function() {
        $('#id_actividad').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_actividad = padre.children('td:eq(1)').text();
        var actividad = padre.children('td:eq(2)').html();
        var descripcion = padre.children('td:eq(3)').html();

        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        $('#actividad').val(actividad);
        $('#descripcion').val(descripcion);
        $('#registro_actividad').slideDown(2000);
        $('#reporte_actividad').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmactividad'));

        var $id_actividad = '<input type="hidden" id="id_actividad"  value="' + id_actividad + '" name="id_actividad">';
        $($id_actividad).appendTo($('#frmactividad'));
    });

    $('table#tabla_actividad').on('click', 'img.eliminar', function() {
        $('#id_actividad').remove();

        var padre = $(this).closest('tr');

        // obtener la fila clickeada
        var nRow = $(this).parents('tr')[0];

        window.parent.bootbox.confirm({
            message: '¿Desea Eliminar el Registro?',
            buttons: {
                'cancel': {
                    label: 'Cancelar',
                    className: 'btn-default'
                },
                'confirm': {
                    label: 'Eliminar',
                    className: 'btn-danger'
                }
            },
            callback: function(result) {
                if (result) {
                    var id_actividad = padre.children('td:eq(1)').text();
                    $.post("../../controlador/Actividad.php", {'accion': 'Eliminar', 'id_actividad': id_actividad}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TActividad.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                                $('textarea').val('');
                            });
                        }
                    });
                }
            }
        });
    });

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#actividad').validar(letra);
    $('#descripcion').validar(letra);

});
