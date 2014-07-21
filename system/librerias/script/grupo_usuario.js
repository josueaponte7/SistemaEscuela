$(document).ready(function() {
    var TGrupousu = $('#tabla_grupo').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "10%"},
            {"sClass": "center", "sWidth": "20%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    $('#registrar').click(function() {
        $('#registro_grupo').slideDown(2000);
        $('#reporte_grupo').slideUp(2000);
    });
    
     $('#todos').change(function() {
        var TotalRow = TGrupousu.fnGetData().length;
        var nodes = TGrupousu.fnGetNodes();
        if(TotalRow > 0){
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_grupo[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_grupo[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });
        
    $('input:checkbox[name="id_grupo[]"]').change(function() {
        $('#todos').prop('checked',false);
        var nodes =  TGrupousu.fnGetNodes();
        var count = $("input:checkbox[name='id_grupo[]']:checked", nodes).length;
       if($(this).is(':checked')){
            $('#imprimir').fadeIn(500);
        }else{
            if(count == 0){
                $('#imprimir').fadeOut(500);
            }
        }
    });
    
    $('#imprimir').click(function() {
        var url = '../reportes/reporte_grupousuario.php';
        if($('#todos').is(':checked')){
            url = url+'?todos=1';
        }else if($('input:checkbox[name="id_grupo[]"]').is(':checked')){
            var checkboxValues = "";
            var nodes =  TGrupousu.fnGetNodes();
            $("input:checkbox[name='id_grupo[]']:checked", nodes).each(function() {
            var $chkbox    = $(this);
            var $actualrow = $chkbox.closest('tr');
            checkboxValues += $actualrow.find('td:eq(1)').text()+',';
        });
            checkboxValues = checkboxValues.substring(0, checkboxValues.length - 1);
            url = url+'?id='+checkboxValues;
        }
        window.open(url);
    });

    $('#guardar').click(function() {

        if ($('#nombre_grupo').val() === null || $('#nombre_grupo').val().length === 0 || /^\s+$/.test($('#nombre_grupo').val())) {
            $('#div_grupo').addClass('has-error');
            $('#nombre_grupo').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {
                $('#id_grupo').remove();

                // obtener el ultimo codigo del status 
                var codigo = 1;
                var TotalRow = TGrupousu.fnGetData().length;
                if (TotalRow > 0) {
                    var lastRow = TGrupousu.fnGetData(TotalRow - 1);
                    var codigo = parseInt(lastRow[1]) + 1;
                }
                
                var $check_grupo = '<input type="checkbox" name="id_grupo[]"  />';

                var $id_grupo = '<input type="hidden" id="id_grupo"  value="' + codigo + '" name="id_grupo">';
                $($id_grupo).prependTo($('#frmgrupo_usuario'));

                $.post("../../controlador/GrupoUsuario.php", $("#frmgrupo_usuario").serialize(), function(respuesta) {
                    if (respuesta == 1) {

                        window.parent.bootbox.alert("Registro con Exito", function() {
                            // Agregar los datos a la tabla
                            TGrupousu.fnAddData([$check_grupo, codigo, $('#nombre_grupo').val(), modificar, eliminar]);
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
                            $.post("../../controlador/GrupoUsuario.php", $("#frmgrupo_usuario").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_grupo tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#nombre_grupo').val());
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
        $('#registro_grupo').slideUp(2000);
        $('#reporte_grupo').slideDown(2000);
        $('#id_grupo').remove();
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('#id_grupo').remove();
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });

    $('table#tabla_grupo').on('click', 'img.modificar', function() {
        $('#id_grupo').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_grupo = padre.children('td:eq(1)').text();
        var nombre_grupo = padre.children('td:eq(2)').html();

        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        $('#nombre_grupo').val(nombre_grupo);
        $('#registro_grupo').slideDown(2000);
        $('#reporte_grupo').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmgrupo_usuario'));

        var $id_grupo = '<input type="hidden" id="id_grupo"  value="' + id_grupo + '" name="id_grupo">';
        $($id_grupo).appendTo($('#frmgrupo_usuario'));
    });

    $('table#tabla_grupo').on('click', 'img.eliminar', function() {
        $('#id_grupo').remove();
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
                    var id_grupo = padre.children('td:eq(1)').text();
                    $.post("../../controlador/GrupoUsuario.php", {'accion': 'Eliminar', 'id_grupo': id_grupo}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TGrupousu.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                            });


                        }
                    });
                }
            }
        });
    });

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre_grupo').validar(letra);

});


