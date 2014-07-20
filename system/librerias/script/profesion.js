$(document).ready(function() {
    var TProfesion = $('#tabla_profesion').dataTable({
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
        $('#registro_profesion').slideDown(2000);
        $('#reporte_profesion').slideUp(2000);
    });

    $('#todos').change(function() {
        var TotalRow = TProfesion.fnGetData().length;
        var nodes = TProfesion.fnGetNodes();
        if (TotalRow > 0) {
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_profesion[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_profesion[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('table#tabla_profesion').on('change', 'input:checkbox[name="id_profesion[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TProfesion.fnGetNodes();
        var count = $("input:checkbox[name='id_profesion[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('#imprimir').click(function() {
        var url = '../reportes/reporte_profesion.php';
        var nodes = TProfesion.fnGetNodes();
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_profesion[]"]', nodes).is(':checked')) {
            var checkboxValues = "";

            $("input:checkbox[name='id_profesion[]']:checked", nodes).each(function() {
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

        if ($('#nombre_profesion').val() === null || $('#nombre_profesion').val().length === 0 || /^\s+$/.test($('#nombre_profesion').val())) {
            $('#div_prof').addClass('has-error');
            $('#nombre_profesion').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            
            if ($(this).text() == 'Guardar') {
                $('#id_profesion').remove();

                // obtener el ultimo codigo del status 
                var ToltalRow = TProfesion.fnGetData().length;
                var lastRow = TProfesion.fnGetData(ToltalRow - 1);
                var codigo = parseInt(lastRow[1]) + 1;

                var $check_profesion = '<input type="checkbox" name="id_profesion[]"  />';

                var $id_profesion = '<input type="hidden" id="id_profesion"  value="' + codigo + '" name="id_profesion">';
                $($id_profesion).prependTo($('#frmprofesion'));

                $.post("../../controlador/Profesion.php", $("#frmprofesion").serialize(), function(respuesta) {
                    if (respuesta == 1) {

                        window.parent.bootbox.alert("Registro con Exito", function() {
                            // Agregar los datos a la tabla
                            TProfesion.fnAddData([$check_profesion, codigo, $('#nombre_profesion').val(), modificar, eliminar]);
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
                            $.post("../../controlador/Profesion.php", $("#frmprofesion").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        
                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_profesion tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#nombre_profesion').val());
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

    $('table#tabla_profesion').on('click', 'img.modificar', function() {
        $('#id_profesion').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_profesion = padre.children('td:eq(1)').text();
        var nombre_profesion = padre.children('td:eq(2)').html();

        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        $('#nombre_profesion').val(nombre_profesion);
        $('#registro_profesion').slideDown(2000);
        $('#reporte_profesion').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmprofesion'));

        var $id_profesion = '<input type="hidden" id="id_profesion"  value="' + id_profesion + '" name="id_profesion">';
        $($id_profesion).appendTo($('#frmprofesion'));
    });

    $('table#tabla_profesion').on('click', 'img.eliminar', function() {
        $('#id_profesion').remove();
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
                    var id_profesion = padre.children('td:eq(1)').text();
                    $.post("../../controlador/Profesion.php", {'accion': 'Eliminar', 'id_profesion': id_profesion}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TProfesion.fnDeleteRow(nRow);

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
        $('#registro_profesion').slideUp(2000);
        $('#reporte_profesion').slideDown(2000);
        $('#id_profesion').remove();
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('#id_profesion').remove();
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre_profesion').validar(letra);

});



