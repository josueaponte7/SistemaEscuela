$(document).ready(function() {
    var TParroquia = $('#tabla_parroquia').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "22%"},
            {"sClass": "center", "sWidth": "25%"},
            {"sClass": "center", "sWidth": "25%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    $('#estado').select2();
    $('#municipio').select2();

    $('#registrar').click(function() {
        $('#registro_parroquia').slideDown(2000);
        $('#reporte_parroquia').slideUp(2000);
    });

    /**********Combos **********/
    $('#estado').change(function() {
        var id = $(this).val();
        $('#municipio').select2('val', 0);
        $('#municipio').find('option:gt(0)').remove().end();
        $.post('../../controlador/Municipio.php', {id_estado: id, accion: 'buscarMun'}, function(respuesta) {
            var option = "";
            $.each(respuesta, function(i, obj) {
                option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
            });
            $('#municipio').append(option);
        }, 'json');
    });

    /********Reporte*********/    
     $('#todos').change(function() {
        var TotalRow = TParroquia.fnGetData().length;
        var nodes = TParroquia.fnGetNodes();
        if(TotalRow > 0){
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_parroquia[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_parroquia[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });
    
    $('table#tabla_parroquia').on('change', 'input:checkbox[name="id_parroquia[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TParroquia.fnGetNodes();
        var count = $("input:checkbox[name='id_parroquia[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('#imprimir').click(function() {
        var url = '../reportes/reporte_parroquia.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_parroquia[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TParroquia.fnGetNodes();
            $("input:checkbox[name='id_parroquia[]']:checked", nodes).each(function() {
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
        } else if ($('#municipio').val() == 0) {
            $('#municipio').addClass('has-error');
        } else if ($('#nombre_parroquia').val() === null || $('#nombre_parroquia').val().length === 0 || /^\s+$/.test($('#nombre_parroquia').val())) {
            $('#div_parroquia').addClass('has-error');
            $('#nombre_parroquia').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {

                if ($('#estado').val() == 0) {
                    $('#estado').addClass('has-error');
                } else {

                    // obtener el ultimo codigo del estado
                    var codigo = 1;
                    var TotalRow = TParroquia.fnGetData().length;
                    if(TotalRow > 0){
                    var lastRow = TParroquia.fnGetData(TotalRow - 1);
                    var codigo = parseInt(lastRow[1]) + 1;
                }

                    var $check_parroquia = '<input type="checkbox" name="id_parroquia[]"  />';

                    var $id_parroquia = '<input type="hidden" id="id_parroquia"  value="' + codigo + '" name="id_parroquia">';
                    $($id_parroquia).prependTo($('#frmparroquia'));

                    $.post("../../controlador/Parroquia.php", $("#frmparroquia").serialize(), function(respuesta) {
                        if (respuesta == 1) {

                            // obtener el nombre del estado 
                            var estado = $('#estado').find(' option').filter(":selected").text();

                            // obtener el id del estado
                            var id_estado = $('#estado').find(' option').filter(":selected").val();

                            // obtener el nombre del municipio
                            var municipio = $('#municipio').find(' option').filter(":selected").text();

                            // obtener el id del municipio
                            var id_municipio = $('#municipio').find(' option').filter(":selected").val();

                            window.parent.bootbox.alert("Registro con Exito", function() {
                                // Agregar los datos a la tabla
                                // Cambion aqui asigno TParroquia.fnAddData a la variable newRow
                                var newRow = TParroquia.fnAddData([$check_parroquia, codigo, estado, municipio, $('#nombre_parroquia').val(), modificar, eliminar]);

                                // Agregar el id a la fila estado
                                var oSettings = TParroquia.fnSettings();
                                var nTr = oSettings.aoData[ newRow[0] ].nTr;
                                $('td', nTr)[2].setAttribute('id', id_estado);
                                $('td', nTr)[3].setAttribute('id', id_municipio);
                                $('input[type="text"]').val('');
                                $('#estado').select2('val', 0);
                                $('#municipio').select2('val', 0);
                                $('#municipio').find('option:gt(0)').remove().end();
                            });
                        } else if (respuesta == 13) {
                            window.parent.bootbox.alert("La Parroquia se encuentra Registrada", function() {
                                $('#div_parroquia').addClass('has-error');
                                $('#nombre_parroquia').focus().select();
                            });
                        }
                        else {
                            window.parent.bootbox.alert("Ocurrio un error comuniquese con informatica", function() {

                            });
                        }
                    });
                }
            } else {

                window.parent.bootbox.confirm({
                    message: '¿Desea Modificar los datos del Registro?',
                    buttons: {
                        'confirm': {
                            label: 'Modificar',
                            className: 'btn-danger'
                        }, 'cancel': {
                            label: 'Cancelar',
                            className: 'btn-default'
                        }
                    },
                    callback: function(result) {
                        if (result) {

                            $.post("../../controlador/Parroquia.php", $("#frmparroquia").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {

                                        // obtener el nombre del estado 
                                        var estado = $('#estado').find(' option').filter(":selected").text();

                                        // obtener el id del estado
                                        var id_estado = $('#estado').find(' option').filter(":selected").val();

                                        // obtener el nombre del municipio
                                        var municipio = $('#municipio').find(' option').filter(":selected").text();

                                        // obtener el id del municipio
                                        var id_municipio = $('#municipio').find(' option').filter(":selected").val();

                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_parroquia tbody tr:eq(" + fila + ")").find("td:eq(2)").html(estado);
                                        $("#tabla_parroquia tbody tr:eq(" + fila + ")").find("td:eq(2)").attr('id', id_estado);

                                        // Modificar la fila 2 en la tabla 
                                        $("#tabla_parroquia tbody tr:eq(" + fila + ")").find("td:eq(3)").html(municipio);
                                        $("#tabla_parroquia tbody tr:eq(" + fila + ")").find("td:eq(3)").attr('id', id_municipio);

                                        // Modificar la fila 3 en la tabla 
                                        $("#tabla_parroquia tbody tr:eq(" + fila + ")").find("td:eq(4 )").html($('#nombre_parroquia').val());
                                        $('input[type="text"]').val('');
                                        $('#estado').select2('val', 0);
                                        $('#municipio').select2('val', 0);
                                        $('#municipio').find('option:gt(0)').remove().end();
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
    $('table#tabla_parroquia').on('click', 'img.modificar', function() {

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_parroquia = padre.children('td:eq(1)').text();
        var id_estado = padre.children('td:eq(2)').attr('id');
        var id_municipio = padre.children('td:eq(3)').attr('id');
        var nombre_parroquia = padre.children('td:eq(4)').html();
        // obtener la fila a modificar
        var fila = padre.index();


        /*************************/

        $('#municipio').find('option:gt(0)').remove().end();
        $.post('../../controlador/Municipio.php', {id_estado: id_estado, accion: 'buscarMun'}, function(respuesta) {
            var option = "";
            $.each(respuesta, function(i, obj) {
                option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
            });
            $('#municipio').append(option);
            $('#municipio').select2('val', id_municipio);
        }, 'json');

        /***********************/
        $('#guardar').text('Modificar');
        $('#estado').select2('val', id_estado);
        $('#municipio').select2('val', id_municipio);
        $('#nombre_parroquia').val(nombre_parroquia);
        $('#registro_parroquia').slideDown(2000);
        $('#reporte_parroquia').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmparroquia'));

        var $id_parroquia = '<input type="hidden" id="id_parroquia"  value="' + id_parroquia + '" name="id_parroquia">';
        $($id_parroquia).appendTo($('#frmparroquia'));
    });

    // modificar las funciones de eliminar
    $('table#tabla_parroquia').on('click', 'img.eliminar', function() {
        $('#id_parroquia').remove();
        var padre = $(this).closest('tr');

        // obtener la fila clickeada
        var nRow = $(this).parents('tr')[0];

        window.parent.bootbox.confirm({
            message: '¿Desea Eliminar el Registro?',
            buttons: {
                'confirm': {
                    label: 'Eliminar',
                    className: 'btn-danger'
                },
                'cancel': {
                    label: 'Cancelar',
                    className: 'btn-default'
                }
            },
            callback: function(result) {
                if (result) {

                    var id_parroquia = padre.children('td:eq(1)').text();
                    $.post("../../controlador/Parroquia.php", {'accion': 'Eliminar', 'id_parroquia': id_parroquia}, function(respuesta) {
                        if (respuesta == 1) {
                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TParroquia.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                                $('#municipio').select2('val', 0);
                                $('#municipio').find('option:gt(0)').remove().end();
                            });


                        }
                    });

                }
            }
        });

    });
    
      $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_parroquia').slideUp(2000);
        $('#reporte_parroquia').slideDown(2000);
        $('#id_estado').remove();
        $('input:text').val('');
        $('#estado').select2('val', 0);
        $('#municipio').select2('val', 0);
        $('#municipio').find('option:gt(0)').remove().end();

    });

    $('#limpiar').click(function() {
        $('#estado').select2('val', 0);
        $('#municipio').select2('val', 0);
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre_parroquia').validar(letra);

});
