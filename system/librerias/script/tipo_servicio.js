$(document).ready(function() {
    var TTiposerv = $('#tabla_servicio').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%","bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "15%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    $('#registrar').click(function() {
        $('#registro_servicio').slideDown(2000);
        $('#reporte_servicio').slideUp(2000);
    });
    
     $('#todos').change(function() {
        var TotalRow = TTiposerv.fnGetData().length;
        var nodes = TTiposerv.fnGetNodes();
        if(TotalRow > 0){
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_tiposervicio[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_tiposervicio[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('table#tabla_servicio').on('change', 'input:checkbox[name="id_tiposervicio[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TTiposerv.fnGetNodes();
        var count = $("input:checkbox[name='id_tiposervicio[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('#imprimir').click(function() {
        var url = '../reportes/reporte_tiposervicio.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_tiposervicio[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TTiposerv.fnGetNodes();
            $("input:checkbox[name='id_tiposervicio[]']:checked", nodes).each(function() {
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

        if ($('#tiposervicio').val() === null || $('#tiposervicio').val().length === 0 || /^\s+$/.test($('#tiposervicio').val())) {
            $('#div_serv').addClass('has-error');
            $('#tiposervicio').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {
                $('#id_tiposervicio').remove();

                // obtener el ultimo codigo del estado
                var codigo = 1;
                var TotalRow = TTiposerv.fnGetData().length;
                if(TotalRow > 0){
                var lastRow = TTiposerv.fnGetData(TotalRow - 1);
                var codigo = parseInt(lastRow[1]) + 1;  
            }
                
                var $check_tiposerv = '<input type="checkbox" name="id_tiposervicio[]"  />';

                var $id_tiposervicio = '<input type="hidden" id="id_tiposervicio"  value="' + codigo + '" name="id_tiposervicio">';
                $($id_tiposervicio).prependTo($('#frmtipo_servicio'));

                $.post("../../controlador/TipoServicio.php", $("#frmtipo_servicio").serialize(), function(respuesta) {
                    if (respuesta == 1) {
                        window.parent.bootbox.alert("Registro con Exito", function() {
                            // Agregar los datos a la tabla
                            TTiposerv.fnAddData([$check_tiposerv, codigo, $('#tiposervicio').val(), modificar, eliminar]);
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

                            $.post("../../controlador/TipoServicio.php", $("#frmtipo_servicio").serialize(), function(respuesta) {
                                if (respuesta == 1) {
                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();
                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_servicio tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#tiposervicio').val());
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
        $('#registro_servicio').slideUp(2000);
        $('#reporte_servicio').slideDown(2000);
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });

    $('table#tabla_servicio').on('click', 'img.modificar', function() {
        // borra el campo fila
        $('#fila').remove();

        var padre = $(this).closest('tr');
        var id_tiposervicio = padre.children('td:eq(1)').text();
        var tiposervicio = padre.children('td:eq(2)').html();

        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        $('#tiposervicio').val(tiposervicio);
        $('#registro_servicio').slideDown(2000);
        $('#reporte_servicio').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmtipo_servicio'));

        var $id_tiposervicio = '<input type="hidden" id="id_tiposervicio"  value="' + id_tiposervicio + '" name="id_tiposervicio">';
        $($id_tiposervicio).appendTo($('#frmtipo_servicio'));
    });

    $('table#tabla_servicio').on('click', 'img.eliminar', function() {
        $('#id_tiposervicio').remove();
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
                    var id_tiposervicio = padre.children('td:eq(1)').text();
                    $.post("../../controlador/TipoServicio.php", {'accion': 'Eliminar', 'id_tiposervicio': id_tiposervicio}, function(respuesta) {
                        if (respuesta == 1) {
                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TTiposerv.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                            });

                        }
                    });
                }
            }
        });
    });

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#tiposervicio').validar(letra);

});
