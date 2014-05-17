$(document).ready(function() {

    var TEstado = $('#tabla_estado').dataTable({
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
        $('#registro_estado').slideDown(2000);
        $('#reporte_estado').slideUp(2000);
    });

    /**Los monta todos***/
    $('#todos').change(function() {
        var TotalRow = TEstado.fnGetData().length;
        var nodes = TEstado.fnGetNodes();
        if (TotalRow > 0) {
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_estado[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_estado[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });

    /***Monta de uno***/
    $('table#tabla_estado').on('change', 'input:checkbox[name="id_estado[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TEstado.fnGetNodes();
        var count = $("input:checkbox[name='id_estado[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });

    /****Imprimi el reporte***/
    $('#imprimir').click(function() {
        var url = '../reportes/reporte_estados.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_estado[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TEstado.fnGetNodes();
            $("input:checkbox[name='id_estado[]']:checked", nodes).each(function() {
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
        if ($('#nombre_estado').val() === null || $('#nombre_estado').val().length === 0 || /^\s+$/.test($('#nombre_estado').val())) {
            $('#div_estado').addClass('has-error');
            $('#nombre_estado').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {
                $('#id_estado').remove();

                // obtener el ultimo codigo del estado
                var codigo = 1;
                var TotalRow = TEstado.fnGetData().length;
                if (TotalRow > 0) {
                    var lastRow = TEstado.fnGetData(TotalRow - 1);
                    var codigo = parseInt(lastRow[1]) + 1;
                }

                var $check_estado = '<input type="checkbox" name="id_estado[]" value="' + codigo + '" />';

                var $id_estado = '<input type="hidden" id="id_estado"  value="' + codigo + '" name="id_estado">';
                $($id_estado).prependTo($('#frmestado'));


                $.post("../../controlador/Estado.php", $("#frmestado").serialize(), function(respuesta) {
                    if (respuesta == 1) {
                        window.parent.bootbox.alert("Registro con Exito", function() {
                            // Agregar los datos a la tabla
                            TEstado.fnAddData([$check_estado, codigo, $('#nombre_estado').val(), modificar, eliminar]);
                            $('input[type="text"]').val('');
                        });
                    } else if (respuesta == 13) {
                        window.parent.bootbox.alert("El Estado se encuentra Registrado", function() {
                            $('#div_estado').addClass('has-error');
                            $('#nombre_estado').focus();
                        });
                    } else {
                        window.parent.bootbox.alert("Ocurrio un error comuniquese con informatica", function() {

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
                            $.post("../../controlador/Estado.php", $("#frmestado").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_estado tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#nombre_estado').val());
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

    // modificar las funciones de modificar
    $('table#tabla_estado').on('click', 'img.modificar', function() {
        $('#id_estado').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_estado = padre.children('td:eq(1)').text();
        var nombre_estado = padre.children('td:eq(2)').html();

        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        $('#nombre_estado').val(nombre_estado);
        $('#registro_estado').slideDown(2000);
        $('#reporte_estado').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmestado'));

        var $id_estado = '<input type="hidden" id="id_estado"  value="' + id_estado + '" name="id_estado">';
        $($id_estado).appendTo($('#frmestado'));

    });


    // modificar las funciones de eliminar
    $('table#tabla_estado').on('click', 'img.eliminar', function() {
        $('#id_estado').remove();
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
//                    var id_estado = padre.children('td:eq(0)').text();
                    var id_estado = padre.children('td:eq(1)').text();
                    $.post("../../controlador/Estado.php", {'accion': 'Eliminar', 'id_estado': id_estado}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TEstado.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                            });


                        }
                    });
                }
            }
        });

    });

    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_estado').slideUp(2000);
        $('#reporte_estado').slideDown(2000);
        $('#id_estado').remove();
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('#id_estado').remove();
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre_estado').validar(letra);
});