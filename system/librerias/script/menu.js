$(document).ready(function() {

    var TMenu = $('#tabla_menu').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "15%", "bSortable": false, "bSearchable": false},
            {"sClass": "center"},
            {"sClass": "center", "sWidth": "15%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });
    
    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre_menu').validar(letra);

    $('#estatus').select2();

    $('#registrar').click(function() {
        $('#registro_menu').slideDown(2000);
        $('#reporte_menu').slideUp(2000);
    });


    $('#guardar').click(function() {
         if ($('#nombre_menu').val() === null || $('#nombre_menu').val().length === 0 || /^\s+$/.test($('#nombre_menu').val())) {
            $('#div_menu').addClass('has-error');
            $('#nombre_menu').focus();
        } else if ($('#estatus').val() == 2) {
            $('#estatus').addClass('has-error');
            $('#estatus').focus();
        } else {
            $('#accion').val($(this).text());

            // obtener el nombre del estatus
            var estatus = $('#estatus').find(' option').filter(":selected").text();

            // obtener el id del estatus
            var id_estatus = $('#estatus').find(' option').filter(":selected").val();

            //imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {
                 $('#id_menu').remove();
                // obtener el ultimo codigo del estado
                var codigo = 1;
                var TotalRow = TMenu.fnGetData().length;
                if(TotalRow > 0){
                var lastRow = TMenu.fnGetData(TotalRow - 1);
                var codigo = parseInt(lastRow[0]) + 1;
            }
                
                
                var $id_menu = '<input type="hidden" id="id_menu"  value="' + codigo + '" name="id_menu">';
                $($id_menu).prependTo($('#frmmenu'));
                
                $.post("../../controlador/Menu.php", $("#frmmenu").serialize(), function(respuesta) {
                    if (respuesta == 1) {  
                        
                        window.parent.bootbox.alert("Registro con Exito", function() {
                            
                            var newRow = TMenu.fnAddData([codigo, $('#nombre_menu').val(), estatus, modificar, eliminar]);
                            $('input[type="text"]').val('');
                            $('#estatus').select2('val', 2);
                            
                            var oSettings = TMenu.fnSettings();
                            var nTr = oSettings.aoData[ newRow[0] ].nTr;
                            $('td', nTr)[2].setAttribute('id', id_estatus);
                            
                        });
                    } else if (respuesta == 13) {
                        window.parent.bootbox.alert("El Menu se encuentra Registrado", function() {
                            $('#div_menu').addClass('has-error');
                            $('#nombre_menu').focus();
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

                            $.post("../../controlador/Menu.php", $("#frmmenu").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
 
                                        TMenu.fnUpdate( $('#nombre_menu').val(), parseInt(fila), 1 );
                                        TMenu.fnUpdate( estatus, parseInt(fila), 2 );
                                        $('input[type="text"]').val('');
                                        $('#estatus').select2('val',2);
                                        $('#guardar').text('Guardar'); 
                                    });

                                }
                            });
                        }
                    }
                });
            }
        }

    });


    $('table#tabla_menu').on('click', 'img.modificar', function() {
        $('#id_menu').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_menu = padre.children('td:eq(0)').text();
        var id_estatus= padre.children('td:eq(2)').attr('id');
        var nombre_menu= padre.children('td:eq(1)').html();
        // obtener la fila a modificar
        var fila = padre.index();



        $('#guardar').text('Modificar');  
        
        $('#nombre_menu').val(nombre_menu);
        $('#estatus').select2('val', id_estatus);
        $('#registro_menu').slideDown(2000);
        $('#reporte_menu').slideUp(2000);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmmenu'));

        var $id_menu = '<input type="hidden" id="id_menu"  value="' + id_menu + '" name="id_menu">';
        $($id_menu).appendTo($('#frmmenu'));
    });


    // modificar las funciones de eliminar
    $('table#tabla_menu').on('click', 'img.eliminar', function() {
        $('#id_menu').remove();
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
                    var id_menu = padre.children('td:eq(0)').text();
                    $.post("../../controlador/Menu.php", {'accion': 'Eliminar', 'id_menu': id_menu}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TMenu.fnDeleteRow(nRow);

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
        $('#registro_menu').slideUp(2000);
        $('#reporte_menu').slideDown(2000);
        $('#id_estatus').remove();
        $('input:text').val('');
        $('#estatus').select2('val', 2);
    });


    $('#limpiar').click(function() {
        $('#estatus').select2('val', 2);
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });

});