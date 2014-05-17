$(document).ready(function() {

    var TMunicipio = $('#tabla_municipio').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "20%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    $('#estado').select2();

    $('#registrar').click(function() {
        $('#registro_municipio').slideDown(2000);
        $('#reporte_municipio').slideUp(2000);
    });
    
     $('#todos').change(function() {
        var TotalRow = TMunicipio.fnGetData().length;
        var nodes = TMunicipio.fnGetNodes();
        if(TotalRow > 0){
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_municipio[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_municipio[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('table#tabla_municipio').on('change', 'input:checkbox[name="id_municipio[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TMunicipio.fnGetNodes();
        var count = $("input:checkbox[name='id_municipio[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('#imprimir').click(function() {
        var url = '../reportes/reporte_municipio.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_municipio[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TMunicipio.fnGetNodes();
            $("input:checkbox[name='id_municipio[]']:checked", nodes).each(function() {
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
        if ($('#estado').val() == 0) {
            $('#estado').addClass('has-error');
        } else if ($('#nombre_municipio').val() === null || $('#nombre_municipio').val().length === 0 || /^\s+$/.test($('#nombre_municipio').val())) {
            $('#div_muni').addClass('has-error');
            $('#nombre_municipio').focus();
        } else {
            $('#accion').val($(this).text());


            //imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {

                // obtener el ultimo codigo del estado
                var codigo = 1;
                var TotalRow = TMunicipio.fnGetData().length;
                if(TotalRow > 0){
                var lastRow = TMunicipio.fnGetData(TotalRow - 1);
                var codigo = parseInt(lastRow[1]) + 1;
            }

                var $check_municipio = '<input type="checkbox" name="id_municipio[]"  />';

                var $id_municipio = '<input type="hidden" id="id_municipio"  value="' + codigo + '" name="id_municipio">';
                $($id_municipio).prependTo($('#frmmunicipio'));
                
                $.post("../../controlador/Municipio.php", $("#frmmunicipio").serialize(), function(respuesta) {
                    if (respuesta == 1) {
                        
                        // obtener el nombre del estado 
                        var estado = $('#estado').find(' option').filter(":selected").text();

                        // obtener el id del estado
                        var id_estado = $('#estado').find(' option').filter(":selected").val();
                        
                        window.parent.bootbox.alert("Registro con Exito", function() {
                             
                            var newRow = TMunicipio.fnAddData([$check_municipio, codigo, estado, $('#nombre_municipio').val(), modificar, eliminar]);

                            // Agregar el id a la fila estado
                            var oSettings = TMunicipio.fnSettings();
                            var nTr = oSettings.aoData[ newRow[0] ].nTr;
                            $('td', nTr)[2].setAttribute('id', id_estado);

                            $('input[type="text"]').val('');
                            $('#estado').select2('val', 0);
                        });
                    } else if (respuesta == 13) {
                        window.parent.bootbox.alert("El Municipio se encuentra Registrado", function() {
                            $('#div_muni').addClass('has-error');
                            $('#nombre_municipio').focus();
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

                            $.post("../../controlador/Municipio.php", $("#frmmunicipio").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        // Modificar la fila 1 en la tabla 
                                        var estado = $('#estado').find(' option').filter(":selected").text();
                                        var id_estado = $('#estado').find(' option').filter(":selected").val();
                                        $("#tabla_municipio tbody tr:eq(" + fila + ")").find("td:eq(2)").html(estado);
                                        $("#tabla_municipio tbody tr:eq(" + fila + ")").find("td:eq(2)").attr('id', id_estado);
                                        $("#tabla_municipio tbody tr:eq(" + fila + ")").find("td:eq(3)").html($('#nombre_municipio').val());
                                        $('input[type="text"]').val('');
                                        $('#estado').select2('val', 0);
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
        $('#registro_municipio').slideUp(2000);
        $('#reporte_municipio').slideDown(2000);
        $('#id_estado').remove();
        $('input:text').val('');
        $('#estado').select2('val', 0);
    });


    $('#limpiar').click(function() {
        $('#estado').select2('val', 0);
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });



    $('table#tabla_municipio').on('click', 'img.modificar', function() {
        $('#id_municipio').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_municipio = padre.children('td:eq(1)').text();
        var id_estado = padre.children('td:eq(2)').attr('id');
        var nombre_municipio = padre.children('td:eq(3)').html();
        // obtener la fila a modificar
        var fila = padre.index();



        $('#guardar').text('Modificar');
        $('#estado').select2('val', id_estado);
        $('#nombre_municipio').val(nombre_municipio);
        $('#registro_municipio').slideDown(2000);
        $('#reporte_municipio').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmmunicipio'));

        var $id_municipio = '<input type="hidden" id="id_municipio"  value="' + id_municipio + '" name="id_municipio">';
        $($id_municipio).appendTo($('#frmmunicipio'));
    });


    // modificar las funciones de eliminar
    $('table#tabla_municipio').on('click', 'img.eliminar', function() {
        $('#id_municipio').remove();
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
                    var id_municipio = padre.children('td:eq(1)').text();
                    $.post("../../controlador/Municipio.php", {'accion': 'Eliminar', 'id_municipio': id_municipio}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TMunicipio.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                            });

                        }
                    });

                }
            }
        });

    });

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre_municipio').validar(letra);

});