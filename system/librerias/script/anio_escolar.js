$(document).ready(function() {

    var TAnio = $('#tabla_anio').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "10%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });


    $('#registrar').click(function() {
        $('#registro_anio').slideDown(2000);
        $('#reporte_anio').slideUp(2000);
    });

    $('#guardar').click(function() {
        if ($('#anio_escolar').val() === null || $('#anio_escolar').val().length === 0 || /^\s+$/.test($('#anio_escolar').val())) {
            $('#div_anio').addClass('has-error');
            $('#anio_escolar').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {
                $('#id_anio').remove();

                // obtener el ultimo codigo del estado
                var codigo = 1;
                var TotalRow = TAnio.fnGetData().length;
                if (TotalRow > 0) {
                    var lastRow = TAnio.fnGetData(TotalRow - 1);
                    var codigo = parseInt(lastRow[0]) + 1;
                }

               // var $check_anio = '<input type="checkbox" name="id_anio[]" value="' + codigo + '" />';

                var $id_anio= '<input type="hidden" id="id_anio"  value="' + codigo + '" name="id_anio">';
                $($id_anio).prependTo($('#frmanio'));
                
                $.post("../../controlador/AnioEscolar.php", $("#frmanio").serialize(), function(respuesta) {
                    if (respuesta == 1) {

                        window.parent.bootbox.alert("Registro con Exito", function() {
                            // Agregar los datos a la tabla
                            TAnio.fnAddData([codigo, $('#anio_escolar').val(), modificar, eliminar]);
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
                            $.post("../../controlador/AnioEscolar.php", $("#frmanio").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_anio tbody tr:eq(" + fila + ")").find("td:eq(1)").html($('#anio_escolar').val());
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
    $('table#tabla_anio').on('click', 'img.modificar', function() {
        $('#id_anio').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_anio = padre.children('td:eq(0)').text();
        var anio_escolar = padre.children('td:eq(1)').html();


        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        $('#anio_escolar').val(anio_escolar);
        $('#registro_anio').slideDown(2000);
        $('#reporte_anio').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmanio'));

        var $id_anio= '<input type="hidden" id="id_anio"  value="' + id_anio + '" name="id_anio">';
        $($id_anio).appendTo($('#frmanio'));

    });
    

    // modificar las funciones de eliminar
    $('table#tabla_anio').on('click', 'img.eliminar', function() {
        $('#id_anio').remove();
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
                    var id_anio = padre.children('td:eq(0)').text();
                    $.post("../../controlador/AnioEscolar.php", {'accion': 'Eliminar', 'id_anio': id_anio}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TAnio.fnDeleteRow(nRow);

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
        $('#registro_anio').slideUp(2000);
        $('#reporte_anio').slideDown(2000);
        $('#id_anio').remove();
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('#id_anio').remove();
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });

    var numero = ' 0123456789';
    $('#anio_escolar').validar(numero);

});