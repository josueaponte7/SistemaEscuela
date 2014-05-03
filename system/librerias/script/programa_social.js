$(document).ready(function() {
    var TPrograma = $('#tabla_programa').dataTable({
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
        $('#registro_programa').slideDown(2000);
        $('#reporte_programa').slideUp(2000);
    });
    
    $('#todos').change(function() {
        var TotalRow = TPrograma.fnGetData().length;
        var nodes = TPrograma.fnGetNodes();
        if(TotalRow > 0){
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_programa[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_programa[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });

//    $('#todos').change(function() {
//        var nodes = TPrograma.fnGetNodes();
//        if ($(this).is(':checked')) {
//            $("input:checkbox[name='id_programa[]']", nodes).prop('checked', true);
//            $('#imprimir').fadeIn(500);
//        } else {
//            $("input:checkbox[name='id_programa[]']", nodes).prop('checked', false);
//            $('#imprimir').fadeOut(500);
//        }
//    });

    $('table#tabla_programa').on('change', 'input:checkbox[name="id_programa[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TPrograma.fnGetNodes();
        var count = $("input:checkbox[name='id_programa[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('#imprimir').click(function() {
        var url = '../reportes/reporte_programasocial.php';
        var nodes = TPrograma.fnGetNodes();
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_programa[]"]', nodes).is(':checked')) {
            var checkboxValues = "";
            
            $("input:checkbox[name='id_programa[]']:checked", nodes).each(function() {
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

        if ($('#nombre_programa').val() === null || $('#nombre_programa').val().length === 0 || /^\s+$/.test($('#nombre_programa').val())) {
            $('#div_progra').addClass('has-error');
            $('#nombre_programa').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {
                $('#id_programa').remove();

                // obtener el ultimo codigo del status 
                var ToltalRow = TPrograma.fnGetData().length;
                var lastRow = TPrograma.fnGetData(ToltalRow - 1);
                var codigo = parseInt(lastRow[1]) + 1;

                var $check_programa = '<input type="checkbox" name="id_programa[]"  />';

                var $id_programa = '<input type="hidden" id="id_programa"  value="' + codigo + '" name="id_programa">';
                $($id_programa).prependTo($('#frmprograma_social'));

                $.post("../../controlador/ProgramaSocial.php", $("#frmprograma_social").serialize(), function(respuesta) {
                    if (respuesta == 1) {

                        window.parent.bootbox.alert("Registro con Exito", function() {
                            // Agregar los datos a la tabla
                            TPrograma.fnAddData([$check_programa, codigo, $('#nombre_programa').val(), modificar, eliminar]);
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
                            $.post("../../controlador/ProgramaSocial.php", $("#frmprograma_social").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_programa tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#nombre_programa').val());
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
        $('#registro_programa').slideUp(2000);
        $('#reporte_programa').slideDown(2000);
        $('#id_programa').remove();
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('#id_programa').remove();
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });

    $('table#tabla_programa').on('click', 'img.modificar', function() {
        $('#id_programa').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_programa = padre.children('td:eq(1)').text();
        var nombre_programa = padre.children('td:eq(2)').html();

        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        $('#nombre_programa').val(nombre_programa);
        $('#registro_programa').slideDown(2000);
        $('#reporte_programa').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmprograma_social'));

        var $id_programa = '<input type="hidden" id="id_programa"  value="' + id_programa + '" name="id_programa">';
        $($id_programa).appendTo($('#frmprograma_social'));
    });

    $('table#tabla_programa').on('click', 'img.eliminar', function() {
        $('#id_programa').remove();
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
                    var id_programa = padre.children('td:eq(1)').text();
                    $.post("../../controlador/ProgramaSocial.php", {'accion': 'Eliminar', 'id_programa': id_programa}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TPrograma.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                            });
                        }
                    });
                }
            }
        });
    });

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre_programa').validar(letra);

});



