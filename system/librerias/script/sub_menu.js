$(document).ready(function() {

    var TSubMenu = $('#tabla_submenu').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "20%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });
    
 var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre_submenu').validar(letra);
    
     var ruta = 'abcdefghijklmnñopqrstuvwxyzáéíóú/-._';
    $('#url').validar(ruta);
    
    $('#estatus, #menu_comb').select2();

    $('#registrar').click(function() {
        $('#registro_submenu').slideDown(2000);
        $('#reporte_submenu').slideUp(2000);
    });    
     

    $('#guardar').click(function() {
        if ($('#menu_comb').val() == 0) {
            $('#menu_comb').addClass('has-error');
        } else if ($('#nombre_submenu').val() === null || $('#nombre_submenu').val().length === 0 || /^\s+$/.test($('#nombre_submenu').val())) {
            $('#div_subme').addClass('has-error');
            $('#nombre_submenu').focus();
        } else if ($('#url').val() === null || $('#url').val().length === 0 || /^\s+$/.test($('#url').val())) {
            $('#div_url').addClass('has-error');
            $('#url').focus();
        } else if ($('#estatus').val() == 2) {
            $('#estatus').addClass('has-error');
            $('#estatus').focus();
        } else {
            $('#accion').val($(this).text());
            
            // obtener el nombre del menu
            var menu_comb = $('#menu_comb').find(' option').filter(":selected").text();

            // obtener el id del menu
            var id_menu = $('#menu_comb').find(' option').filter(":selected").val();
            
            // obtener el nombre del estatus
            var estatus = $('#estatus').find(' option').filter(":selected").text();

            // obtener el id del estatus
            var id_estatus = $('#estatus').find(' option').filter(":selected").val();


            //imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {
                $('#id_submenu').remove();
                 // obtener el ultimo codigo del estado
                var codigo = 1;
                var TotalRow = TSubMenu.fnGetData().length;
                if(TotalRow > 0){
                var lastRow = TSubMenu.fnGetData(TotalRow - 1);
                var codigo = parseInt(lastRow[0]) + 1;
            }

                var $id_submenu = '<input type="hidden" id="id_submenu"  value="' + codigo + '" name="id_submenu">';
                $($id_submenu).prependTo($('#frmsubmenu'));
                
                $.post("../../controlador/SubMenu.php", $("#frmsubmenu").serialize(), function(respuesta) {
                    if (respuesta == 1) {                        
                        
                        window.parent.bootbox.alert("Registro con Exito", function() {
                            
                            var newRow = TSubMenu.fnAddData([codigo, menu_comb, $('#nombre_submenu').val(), estatus, modificar, eliminar]);
                            $('input[type="text"]').val('');
                            $('#menu_comb').select2('val', 0);
                            $('#estatus').select2('val', 2);
                            
                            var oSettings = TSubMenu.fnSettings();
                            var nTr = oSettings.aoData[ newRow[0] ].nTr;
                            $('td', nTr)[1].setAttribute('id', id_menu);
                            $('td', nTr)[3].setAttribute('id', id_estatus);
                            
                        });
                    } else if (respuesta == 13) {
                        window.parent.bootbox.alert("El SubMenu se encuentra Registrado", function() {
                            $('#div_subme').addClass('has-error');
                            $('#nombre_submenu').focus();
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

                            $.post("../../controlador/SubMenu.php", $("#frmsubmenu").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        
                                        TSubMenu.fnUpdate( menu_comb, parseInt(fila),1 );
                                        TSubMenu.fnUpdate( $('#nombre_submenu').val(), parseInt(fila), 2 );
                                        TSubMenu.fnUpdate( estatus, parseInt(fila), 3 );
                                        
                                        $('input[type="text"]').val('');
                                        $('#menu_comb').select2('val',0);
                                        $('#estatus').select2('val',2);
                                    });

                                }
                            });
                        }
                    }
                });
            }
        }

    });

    $('table#tabla_submenu').on('click', 'img.modificar', function() {
        $('#id_submenu').remove();

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_submenu = padre.children('td:eq(0)').text();
        var id_menu= padre.children('td:eq(1)').attr('id');
        var nombre_submenu= padre.children('td:eq(2)').html();
        var id_estatus= padre.children('td:eq(3)').attr('id');
        // obtener la fila a modificar
        var fila = padre.index();



        $('#guardar').text('Modificar'); 
        
        $('#id_submenu').select2('val', id_submenu);
        $('#id_menu').select2('val', id_menu);
        $('#nombre_submenu').val(nombre_submenu);
        $('#estatus').select2('val', id_estatus);
        $('#registro_submenu').slideDown(2000);
        $('#reporte_submenu').slideUp(2000);
        
        $.post("../../controlador/SubMenu.php", {id_submenu: id_submenu, accion: 'BuscarDatos'}, function(respuesta) {
            var datos = respuesta.split(";");
            
            
            $('#menu_comb').select2('val', datos[0]);
            $('#nombre_submenu').val(datos[1]);
            $('#url').val(datos[2]);
            $('#grupo_usuario').select2('val', datos[3]);

            
        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frmsubmenu'));

        var $id_submenu = '<input type="hidden" id="id_submenu"  value="' + id_submenu + '" name="id_submenu">';
        $($id_submenu).appendTo($('#frmsubmenu'));
        });

    });


    // modificar las funciones de eliminar
    $('table#tabla_submenu').on('click', 'img.eliminar', function() {
        $('#id_submenu').remove();
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
                    var id_submenu = padre.children('td:eq(0)').text();
                    $.post("../../controlador/SubMenu.php", {'accion': 'Eliminar', 'id_submenu': id_submenu}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TSubMenu.fnDeleteRow(nRow);

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
        $('#registro_submenu').slideUp(2000);
        $('#reporte_submenu').slideDown(2000);
        $('#id_menu').remove();
        $('#id_estatus').remove();
        $('input:text').val('');
        $('#estatus').select2('val', 2);
        $('#menu_comb').select2('val', 0);
    });


    $('#limpiar').click(function() {
        $('#id_menu').remove();
        $('#id_estatus').remove();
        $('input:text').val('');
        $('#estatus').select2('val', 2);
        $('#menu_comb').select2('val', 0);
        $('#guardar').text('Guardar');
    });

});