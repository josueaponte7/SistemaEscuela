$(document).ready(function() {
    var TStatusrepre = $('#tabla_statusrep').dataTable({
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
        $('#registro_statusrep').slideDown(2000);
        $('#reporte_statusrep').slideUp(2000);
    });

    $('#todos').change(function() {
        var TotalRow = TStatusrepre.fnGetData().length;
        var nodes = TStatusrepre.fnGetNodes();
        if (TotalRow > 0) {
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_estatus[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_estatus[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('table#tabla_statusrep').on('change', 'input:checkbox[name="id_estatus[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TStatusrepre.fnGetNodes();
        var count = $("input:checkbox[name='id_estatus[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('#imprimir').click(function() {
        var url = '../reportes/reporte_statusrepresentante.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_estatus[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TStatusrepre.fnGetNodes();
            $("input:checkbox[name='id_estatus[]']:checked", nodes).each(function() {
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

        if ($('#nombre').val() === null || $('#nombre').val().length === 0 || /^\s+$/.test($('#nombre').val())) {
            $('#div_statusrepre').addClass('has-error');
            $('#nombre').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {

                $('#id_estatus').remove();

                // obtener el ultimo codigo del status 
                var codigo = 1;
                var TotalRow = TStatusrepre.fnGetData().length;
                if (TotalRow > 0) {
                    var lastRow = TStatusrepre.fnGetData(TotalRow - 1);
                    var codigo = parseInt(lastRow[1]) + 1;
                }

                var $check_status = '<input type="checkbox" name="id_estatus[]"  />';

                var $id_estatus = '<input type="hidden" id="id_estatus"  value="' + codigo + '" name="id_estatus">';
                $($id_estatus).prependTo($('#frmstatus_representante'));

                $.post("../../controlador/StatusRepresentante.php", $("#frmstatus_representante").serialize(), function(respuesta) {
                    if (respuesta == 1) {

                        window.parent.bootbox.alert("Registro con Exito", function() {
                            // Agregar los datos a la tabla
                            TStatusrepre.fnAddData([$check_status, codigo, $('#nombre').val(), modificar, eliminar]);
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
                            $.post("../../controlador/StatusRepresentante.php", $("#frmstatus_representante").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_statusrep tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#nombre').val());
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
        $('#registro_statusrep').slideUp(2000);
        $('#reporte_statusrep').slideDown(2000);
        $('#id_estatus').remove();
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });

    $('table#tabla_statusrep').on('click', 'img.modificar', function() {
        $('#id_estatus').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_estatus = padre.children('td:eq(1)').text();
        var nombre = padre.children('td:eq(2)').html();

        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        $('#nombre').val(nombre);
        $('#registro_statusrep').slideDown(2000);
        $('#reporte_statusrep').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmstatus_representante'));

        var $id_estatus = '<input type="hidden" id="id_estatus"  value="' + id_estatus + '" name="id_estatus">';
        $($id_estatus).appendTo($('#frmstatus_representante'));
    });

    $('table#tabla_statusrep').on('click', 'img.eliminar', function() {

        $('#id_estatus').remove();
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
                    var id_estatus = padre.children('td:eq(1)').text();
                    $.post("../../controlador/StatusRepresentante.php", {'accion': 'Eliminar', 'id_estatus': id_estatus}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TStatusrepre.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                            });


                        }
                    });
                }
            }
        });

    });

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre').validar(letra);

});


