$(document).ready(function() {
    var TServiciosalud = $('#tabla_salud').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "10%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });


    $('#tiposervicio').select2();
    $('#estado').select2();
    $('#municipio').select2();
    $('#parroquia').select2();
    $('#cod_telefono').select2();
        
    $('#registrar').click(function() {
        $('#registro_salud').slideDown(2000);
        $('#reporte_salud').slideUp(2000);
    });
    
    
    /***Combos **/

    $('#estado').change(function() {
        var id = $(this).val();
        $('#municipio').find('option:gt(0)').remove().end();
        $.post('../../controlador/Municipio.php', {id_estado: id, accion: 'buscarMun'}, function(respuesta) {
            var option = "";
            $.each(respuesta, function(i, obj) {
                option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
            });
            $('#municipio').append(option);
        }, 'json');
    });

    $('#municipio').change(function() {
        var id = $(this).val();
        $('#parroquia').find('option:gt(0)').remove().end();
        $.post('../../controlador/Parroquia.php', {id_municipio: id, accion: 'buscarParr'}, function(respuesta) {
            var option = "";
            $.each(respuesta, function(i, obj) {
                option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
            });
            $('#parroquia').append(option);
        }, 'json');
    });

    /**Los monta todos***/
    $('#todos').change(function() {
        var TotalRow = TServiciosalud.fnGetData().length;
        var nodes = TServiciosalud.fnGetNodes();
        if (TotalRow > 0) {
            if ($(this).is(':checked')) {
                $("input:checkbox[name='id_servicio[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='id_servicio[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });

    /***Monta de uno***/
    $('table#tabla_salud').on('change', 'input:checkbox[name="id_servicio[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TServiciosalud.fnGetNodes();
        var count = $("input:checkbox[name='id_servicio[]']:checked", nodes).length;
        if ($(this).is(':checked')) {
            $('#imprimir').fadeIn(500);
        } else {
            if (count == 0) {
                $('#imprimir').fadeOut(500);
            }
        }
    });

    /****Imprimi el reporte***/
    $('#imprimir').click(function() {
        var url = '../reportes/reporte_servicosalud.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="id_servicio[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TServiciosalud.fnGetNodes();
            $("input:checkbox[name='id_servicio[]']:checked", nodes).each(function() {
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
         if ($('#servicio').val() === null || $('#servicio').val().length === 0 || /^\s+$/.test($('#servicio').val())) {
            $('#div_servicio').addClass('has-error');
            $('#servicio').focus();
        } else  if ($('#tiposervicio').val() == 0) {
            $('#tiposervicio').addClass('has-error');
        } else if($('#estado').val() == 0){
            $('#estado').addClass('has-error');
        }else if($('#municipio').val() == 0){
            $('#municipio').addClass('has-error');
        }else if($('#parroquia').val() == 0){
            $('#parroquia').addClass('has-error');
        }else if($('#cod_telefono').val() == 0){
            $('#cod_telefono').addClass('has-error');
        }
            
        
        $('#accion').val($(this).text());
        // Imagenes de modificar y eliminar
        var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
        var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
        
        var cod_telefono  = $('#cod_telefono').find(' option').filter(":selected").text();
            
        var telefono     = cod_telefono + '-' + $('#telefono').val();
        
        if ($(this).text() == 'Guardar') {
            // obtener el ultimo codigo del status 
            var codigo = 1;
            var TotalRow = TServiciosalud.fnGetData().length;
            var lastRow = TServiciosalud.fnGetData(TotalRow - 1);
            if (TotalRow > 0) {
                var codigo = parseInt(lastRow[1]) + 1;
            }

            // obtener el nombre del egrupo 
            var tiposervicio = $('#tiposervicio').find(' option').filter(":selected").text();

            var $check_servicio = '<input type="checkbox" name="id_servicio[]" value="' + codigo + '" />';

            var $id_servicio = '<input type="hidden" id="id_servicio"  value="' + codigo + '" name="id_servicio">';
            $($id_servicio).prependTo($('#frmservicio_salud'));

            $.post("../../controlador/ServicioSalud.php", $("#frmservicio_salud").serialize(), function(respuesta) {
                if (respuesta == 1) {


                    window.parent.bootbox.alert("Registro con Exito", function() {
                        // Agregar los datos a la tabla
                        var newRow = TServiciosalud.fnAddData([$check_servicio, codigo, $('#servicio').val(), tiposervicio, telefono, modificar, eliminar]);
                        // Agregar el id a la fila estado
                        var oSettings = TServiciosalud.fnSettings();
                        var nTr = oSettings.aoData[ newRow[0] ].nTr;
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
                        $.post("../../controlador/ServicioSalud.php", $("#frmservicio_salud").serialize(), function(respuesta) {
                            if (respuesta == 1) {
                                // obtener la fila a modificar
                                var fila = $("#fila").val();
                                window.parent.bootbox.alert("Modificacion con Exito", function() {

                                    // Modificar la fila 1 en la tabla 
                                    
                                    var tiposervicio    = $('#tiposervicio').find(' option').filter(":selected").text();
                                    var id_tiposervicio = $('#tiposervicio').find(' option').filter(":selected").val(); 
                                   
                                    
                                    
                                    $("#tabla_salud tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#servicio').val());
                                    $("#tabla_salud tbody tr:eq(" + fila + ")").find("td:eq(3)").html(tiposervicio);
                                    $("#tabla_salud tbody tr:eq(" + fila + ")").find("td:eq(3)").attr('id', id_tiposervicio);
                                    $("#tabla_salud tbody tr:eq(" + fila + ")").find("td:eq(4)").html(telefono);

                                    $('input[type="text"]').val('');
                                });
                            }
                        });
                    }
                }
            });
        }
    });

    $('table#tabla_salud').on('click', 'img.modificar', function() {

        // borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var id_servicio = padre.children('td:eq(1)').text(); 
        var servicio = padre.children('td:eq(2)').html();   
        var tiposervicio = padre.children('td:eq(3)').html();
        var telefono = padre.children('td:eq(4)').html();


        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');
        
        
//        $('#cedula').val(cedula).prop('disabled',true);
        $('#servicio').val(servicio);
        $('#tiposervicio').val(tiposervicio);
        $('#telefono').val(telefono);
        $('#registro_salud').slideDown(2000);
        $('#reporte_salud').slideUp(2000);

        $.post("../../controlador/ServicioSalud.php", {id_servicio: id_servicio, accion: 'BuscarDatos'}, function(respuesta) {
            var datos = respuesta.split(";");
            
            $('#servicio').select2('val', datos[0]);            
            $('#cod_telefono').select2('val', datos[1]);
            $('#telefono').val(datos[2]);
            $('#estado').select2('val', datos[3]);
            var id_mun = datos[4];
            var id_parr = datos[5];
            $('#municipio').find('option:gt(0)').remove().end();
            
            $.post('../../controlador/Municipio.php', {id_estado: datos[3], accion: 'buscarMun'}, function(respuesta) {
                var option = "";
                $.each(respuesta, function(i, obj) {
                    option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
                });
                $('#municipio').append(option);
                $('#municipio').select2('val', id_mun);
            }, 'json');

            $('#parroquia').find('option:gt(0)').remove().end();
            $.post('../../controlador/Parroquia.php', {id_municipio: id_mun, accion: 'buscarParr'}, function(respuesta) {
                var option = "";
                $.each(respuesta, function(i, obj) {
                    option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
                });
                $('#parroquia').append(option);
                $('#parroquia').select2('val', id_parr);
            }, 'json');
              $('#tiposervicio').select2('val', datos[6]);

            // crear el campo fila y añadir la fila
            var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
            $($fila).prependTo($('#frmservicio_salud'));

            var $id_servicio = '<input type="hidden" id="id_servicio"  value="' + id_servicio + '" name="id_servicio">';
            $($id_servicio).appendTo($('#frmservicio_salud'));
        });
    });


    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_salud').slideUp(2000);
        $('#reporte_salud').slideDown(2000);
        $('input:text').val('');
        $('#tiposervicio').select2('val', 0);
        $('#estado').select2('val', 0);
        $('#municipio').select2('val', 0);
        $('#parroquia').select2('val', 0);
        $('#cod_telefono').select2('val', 0);
        
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('#tiposervicio').select2('val', 0);
        $('#estado').select2('val', 0);
        $('#municipio').select2('val', 0);
        $('#parroquia').select2('val', 0);
        $('#cod_telefono').select2('val', 0);
        $('#guardar').text('Guardar');
    });
    
    var numero = '0123456789';
    $('#telefono').validar(numero);
    $('#celular').validar(numero);
    $('#cedula').validar(numero);

});
