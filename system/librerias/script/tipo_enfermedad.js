$(document).ready(function() {
    var TEnfermedad = $('#tabla_enfermedad').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "10%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    $('#registrar').click(function() {
        $('#registro_enfermedad').slideDown(2000);
        $('#reporte_enfermedad').slideUp(2000);
    });

    $('#todos').change(function() {
        var TotalRow = TEnfermedad.fnGetData().length;
        var nodes = TEnfermedad.fnGetNodes();
        if (TotalRow > 0) {
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_enfermedad[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_enfermedad[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('table#tabla_enfermedad').on('change', 'input:checkbox[name="id_enfermedad[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TEnfermedad.fnGetNodes();
        var count = $("input:checkbox[name='id_enfermedad[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('#imprimir').click(function() {
        var url = '../reportes/reporte_tipoenfermedad.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_enfermedad[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TEnfermedad.fnGetNodes();
            $("input:checkbox[name='id_enfermedad[]']:checked", nodes).each(function() {
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

        if ($('#enfermedad').val() === null || $('#enfermedad').val().length === 0 || /^\s+$/.test($('#enfermedad').val())) {
            $('#div_enfer').addClass('has-error');
            $('#enfermedad').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {
                $('#id_enfermedad').remove();

                // obtener el ultimo codigo del status 
                var codigo = 1;
                var TotalRow = TEnfermedad.fnGetData().length;
                if (TotalRow > 0) {
                    var lastRow = TEnfermedad.fnGetData(TotalRow - 1);
                    var codigo = parseInt(lastRow[1]) + 1;
                }

                var $check_enfermedad = '<input type="checkbox" name="id_enfermedad[]"  />';

                var $id_enfermedad = '<input type="hidden" id="id_enfermedad"  value="' + codigo + '" name="id_enfermedad">';
                $($id_enfermedad).prependTo($('#frmtipo_enfermedad'));

                $.post("../../controlador/TipoEnfermedad.php", $("#frmtipo_enfermedad").serialize(), function(respuesta) {
                    if (respuesta == 1) {

                        window.parent.bootbox.alert("Registro con Exito", function() {
                            // Agregar los datos a la tabla
                            TEnfermedad.fnAddData([$check_enfermedad, codigo, $('#enfermedad').val(), modificar, eliminar]);
                            $('input[type="text"]').val('');
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
                            $.post("../../controlador/TipoEnfermedad.php", $("#frmtipo_enfermedad").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_enfermedad tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#enfermedad').val());
                                        $('input[type="text"]').val('');

                                    });

                                }
                            });
                        }
                    }
                });
            }
        }
    });

    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_enfermedad').slideUp(2000);
        $('#reporte_enfermedad').slideDown(2000);
        $('#id_enfermedad').remove();
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('#id_enfermedad').remove();
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });

    $('table#tabla_enfermedad').on('click', 'img.modificar', function() {
        $('#id_enfermedad').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_enfermedad = padre.children('td:eq(1)').text();
        var enfermedad = padre.children('td:eq(2)').html();

        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        $('#enfermedad').val(enfermedad);
        $('#registro_enfermedad').slideDown(2000);
        $('#reporte_enfermedad').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmtipo_enfermedad'));

        var $id_enfermedad = '<input type="hidden" id="id_enfermedad"  value="' + id_enfermedad + '" name="id_enfermedad">';
        $($id_enfermedad).appendTo($('#frmtipo_enfermedad'));
    });

    $('table#tabla_enfermedad').on('click', 'img.eliminar', function() {
        $('#id_enfermedad').remove();
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
                    var id_enfermedad = padre.children('td:eq(1)').text();
                    $.post("../../controlador/TipoEnfermedad.php", {'accion': 'Eliminar', 'id_enfermedad': id_enfermedad}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TEnfermedad.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                            });
                        }
                    });
                }
            }
        });
    });

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#enfermedad').validar(letra);

});


