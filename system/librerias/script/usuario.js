$(document).ready(function() {
    var TUsuario = $('#tabla_usuario').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center"},
            {"sClass": "center", "sWidth": "10%"},
            {"sClass": "center", "sWidth": "20%"},
            {"sClass": "center", "sWidth": "20%"},
            {"sClass": "center", "sWidth": "20%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    var usuario = 'abcdefghijklmnopqrstuvwxyz0123456789';
    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    var clave = '1234567890abcdefghijklmnopqrstuvwxyz';
    $('#usuario').validar(usuario);
    $('#nombre').validar(letra);
    $('#apellido').validar(letra);
    $('#contrasena').validar(clave);

    $('#grupo_usuario').select2();
    $('#estatus').select2();

    $('#registrar').click(function() {
        $('#registro_usuario').slideDown(2000);
        $('#reporte_usuario').slideUp(2000);
    });

    $('#todos').change(function() {
        var TotalRow = TUsuario.fnGetData().length;
        var nodes = TUsuario.fnGetNodes();
        if (TotalRow > 0) {
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_usuario[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_usuario[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });

    $('table#tabla_usuario').on('change', 'input:checkbox[name="id_usuario[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TUsuario.fnGetNodes();
        var count = $("input:checkbox[name='id_usuario[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });


    $('#imprimir').click(function() {
        var url = '../reportes/reporte_usuario.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_usuario[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TUsuario.fnGetNodes();
            $("input:checkbox[name='id_usuario[]']:checked", nodes).each(function() {
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
        if ($('#usuario').val() === null || $('#usuario').val().length === 0 || /^\s+$/.test($('#usuario').val())) {
            $('#div_usuario').addClass('has-error');
            $('#usuario').focus();
        } else if ($('#nombre').val() === null || $('#nombre').val().length === 0 || /^\s+$/.test($('#nombre').val())) {
            $('#div_nombre').addClass('has-error');
            $('#nombre').focus();
        } else if ($('#apellido').val() === null || $('#apellido').val().length === 0 || /^\s+$/.test($('#apellido').val())) {
            $('#div_apellido').addClass('has-error');
            $('#apellido').focus();
        } else if ($('#grupo_usuario').val() == 0) {
            $('#grupo_usuario').addClass('has-error');
            $('#grupo_usuario').focus();
        } else if ($(this).text() == 'Guardar' && $('#contrasena').val().length < 6 || $('#contrasena').val().length > 20) {
            $('#div_contrasena').addClass('has-error');
            $('#contrasena').focus();
        } else if ($(this).text() == 'Guardar' && $('#contrasena').val() != $('#confirmar_contrasena').val()) {
            $('#div_confirmar').addClass('has-error');
            $('#confirmar_contrasena').focus();
        } else if ($('#estatus').val() == 2) {
            $('#estatus').addClass('has-error');
            $('#estatus').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';

            if ($(this).text() == 'Guardar') {


                // obtener el ultimo codigo del status 
                var codigo = 1;
                var TotalRow = TUsuario.fnGetData().length;
                if (TotalRow > 0) {
                    var lastRow = TUsuario.fnGetData(TotalRow - 1);
                    var codigo = parseInt(lastRow[1]) + 1;
                }


                var $check_id_usuario = '<input type="checkbox" name="id_usuario[]" value="' + codigo + '" />';

                var $id_usuario = '<input type="hidden" id="id_usuario"  value="' + codigo + '" name="id_usuario">';
                $($id_usuario).prependTo($('#frmusuario'));
                $.post("../../controlador/Usuario.php", $("#frmusuario").serialize(), function(respuesta) {
                    if (respuesta == 1) {

                        // obtener el nombre del egrupo 
                        var grupo_usuario = $('#grupo_usuario').find(' option').filter(":selected").text();

                        // obtener el id del estado
                        var id_grupo = $('#grupo_usuario').find(' option').filter(":selected").val();

                        // obtener el nombre del egrupo 
                        var estatus = $('#estatus').find(' option').filter(":selected").text();

                        // obtener el id del estado
                        var id_estatus = $('#estatus').find(' option').filter(":selected").val();

                        window.parent.bootbox.alert("Registro con Exito", function() {

                            // Agregar los datos a la tabla
                            var newRow = TUsuario.fnAddData([$check_id_usuario, codigo, $('#usuario').val(), $('#nombre').val(), $('#apellido').val(), estatus, grupo_usuario, modificar, eliminar]);

                            // Agregar el id a la fila estado
                            var oSettings = TUsuario.fnSettings();
                            var nTr = oSettings.aoData[ newRow[0] ].nTr;
                            $('td', nTr)[5].setAttribute('id', id_grupo);
                            $('input[type="text"],input[type="password"]').val('');
                            $('#grupo_usuario,#estatus').select2('val', 0);
                            $('#estatus').select2('val', 2);
                            $('div,#grupo_usuario,#estatus').removeClass('has-error');
                        });
                    }
                });
            } else {

                if ($('#contrasena').val().length > 1 && ($('#contrasena').val().length < 6 || $('#contrasena').val().length > 20)) {
                    $('#div_contrasena').addClass('has-error');
                    $('#contrasena').focus();
                }else if( $('#contrasena').val() != $('#confirmar_contrasena').val()) {
                    $('#div_confirmar').addClass('has-error');
                    $('#confirmar_contrasena').focus();
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
                                $.post("../../controlador/Usuario.php", $("#frmusuario").serialize(), function(respuesta) {
                                    if (respuesta == 1) {

                                        // obtener la fila a modificar
                                        var fila = $("#fila").val();

                                        window.parent.bootbox.alert("Modificacion con Exito", function() {

                                            // obtener el nombre del estado 
                                            var grupo_usuario = $('#grupo_usuario').find(' option').filter(":selected").text();

                                            // obtener el id del estado
                                            var id_grupo_usuario = $('#grupo_usuario').find(' option').filter(":selected").val();

                                            // Modificar la fila 1 en la tabla 
                                            $("#tabla_usuario tbody tr:eq(" + fila + ")").find("td:eq(1)").html($('#usuario').val());
                                            $("#tabla_usuario tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#nombre').val());
                                            $("#tabla_usuario tbody tr:eq(" + fila + ")").find("td:eq(3)").html($('#apellido').val());
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
        $('#registro_usuario').slideUp(2000);
        $('#reporte_usuario').slideDown(2000);
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('input:password').val('');
        $('#grupo_usuario').select2('val', 0);
        $('#guardar').text('Guardar');
    });

    // modificar las funciones de modificar
    $('table#tabla_usuario').on('click', 'img.modificar', function() {

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_usuario = padre.children('td:eq(1)').text();
        var usuario = padre.children('td:eq(2)').text();
        var nombre = padre.children('td:eq(3)').text();
        var apellido = padre.children('td:eq(4)').text();
        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        $('#usuario').val(usuario);
        $('#nombre').val(nombre);
        $('#apellido').val(apellido);
        $('#registro_usuario').slideDown(2000);
        $('#reporte_usuario').slideUp(2000);

        $.post("../../controlador/Usuario.php", {id_usuario: id_usuario, accion: 'BuscarDatos'}, function(respuesta) {
            var datos = respuesta.split(";");
            $('#estatus').select2('val', datos[0]);
            $('#grupo_usuario').select2('val', datos[1]);


            // crear el campo fila y añadir la fila
            var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
            $($fila).prependTo($('#frmusuario'));

            var $id_usuario = '<input type="hidden" id="id_usuario"  value="' + id_usuario + '" name="id_usuario">';
            $($id_usuario).appendTo($('#frmusuario'));
        });
    });

    $('table#tabla_usuario').on('click', 'img.eliminar', function() {
        $('#id_usuario').remove();

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
                    var id_usuario = padre.children('td:eq(1)').text();
                    $.post("../../controlador/Usuario.php", {'accion': 'Eliminar', 'id_usuario': id_usuario}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TUsuario.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                            });
                        }
                    });
                }
            }
        });
    });
});
