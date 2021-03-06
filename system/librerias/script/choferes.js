$(document).ready(function() {
    var TChoferes = $('#tabla_choferes').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "15%"},
            {"sClass": "center", "sWidth": "70%"},
            {"sClass": "center", "sWidth": "8%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });
    
    
    /*************Izquido*****************/
    $('#imgcedula').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>La C&eacute;dula no puede estar en blanco<br/>'
    });
    
    $('#imgapellido').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>El Apellido no puede estar en blanco<br/>'
    });
    
    $('#imgplaca').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>La Placa no puede estar en blanco<br/>'
    });
    
    $('#imgcolor').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>El Color no puede estar en blanco<br/>'
    });
    
        
    
    /**************Derecho****************/
    $('#imgnombre').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>El Nombre no debe estar en blanco<br/>'
    });   
    
     $('#imgtelcel').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>La Teléfono Celular no debe estar en blanco<br/>'
    });
    
     $('#imgmodelo').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>El Modelo no debe estar en blanco<br/>'
    });
    
    
    
    
    /***********************************/
    $('#nacionalidad').select2({
        minimumResultsForSearch: -1
    }).on('change', function() {
        if ($(this).val() > 0) {
            $('#cedula').focus();
        }
    });
    $('#cod_telefono,#cod_celular')
        .select2()
        .on('change', function() {
            $('#cod_telefono,#cod_celular,#div_telefono,#div_celular').removeClass('has-error');
    });
    
    $('.modificar').tooltip({
        html: true,
        placement: 'top',
        title: 'Modificar'
    });
    $('.eliminar').tooltip({
        html: true,
        placement: 'top',
        title: 'Eliminar'
    });
    
    
    $('#cod_telefono,#cod_celular').select2();
    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre, #apellido,#color').validar(letra);
    var numero = '0123456789';
    $('#telefono, #celular, #cedula').validar(numero);
    var placa = '0123456789abcdefghijklmnopqrstuvwxyz';
    $('#placa,#modelo').validar(placa);
    var correo = '0123456789abcdefghijklmnopqrstuvwxyz_-.#$&*@';
    $('#email').validar(correo);
    $('#registrar').click(function() {
        $('#registro_choferes').slideDown(2000);
        $('#reporte_choferes').slideUp(2000);
    });
    $('.tooltip_ced').tooltip({
        html: true,
        placement: 'bottom',
        title: 'Click para ver opciones'
    });
    var $contextMenu = $("#contextMenu");
    var cedula = '';
    
    $("table#tabla_choferes").on("click", "span.sub-rayar", function(e) {
        $('.dropdown').hide();
        cedula = $(this).text().substr(2);
        $contextMenu.css({
            display: "block",
            left: e.pageX,
            top: e.pageY
        });
    });
    /**********Para ver los datos en una palnilla para imprimir aqui seria ver_datos_cheferes.php*****************/
    $contextMenu.on("click", "span", function() {
        var url = 'vista/registros/ver_datos_representante.php';
        parent.$.fancybox.open({
            'autoScale': false,
            height: '680px',
            'href': url + '?cedula=' + cedula,
            'type': 'iframe',
            'hideOnContentClick': false,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'openSpeed': 500,
            'closeSpeed': 500,
            'openEffect': 'elastic',
            'closeEffect': 'elastic',
            //'scrolling':'yes',
            overflow: scroll,
            'helpers': {overlay: {closeClick: false}}
        });
        $('.dropdown').hide();
    });
    /**********Generar el listado de reporte en PDF*****************/
    /**Los monta todos***/
    $('#todos').change(function() {
        var TotalRow = TChoferes.fnGetData().length;
        var nodes = TChoferes.fnGetNodes();
        if (TotalRow > 0) {
            if ($(this).is(':checked')) {
                $("input:checkbox[name='cedula[]']", nodes).prop('checked', true);
                $('#imprimir').fadeIn(500);
            } else {
                $("input:checkbox[name='cedula[]']", nodes).prop('checked', false);
                $('#imprimir').fadeOut(500);
            }
        }
    });
    /***Monta de uno***/
    $('table#tabla_choferes').on('change', 'input:checkbox[name="cedula[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TChoferes.fnGetNodes();
        var count = $("input:checkbox[name='cedula[]']:checked", nodes).length;
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
        var url = '../reportes/reporte_chofer.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="cedula[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TChoferes.fnGetNodes();
            $("input:checkbox[name='cedula[]']:checked", nodes).each(function() {
                var $chkbox = $(this);
                var $actualrow = $chkbox.closest('tr');
                var cedula = $actualrow.find('td:eq(1)').text();
                checkboxValues += cedula.substr(2) + ',';
            });
            checkboxValues = checkboxValues.substring(0, checkboxValues.length - 1);
            url = url + '?cedula=' + checkboxValues;
        }
        window.open(url);
    });
    /********Proceso de registro*************/
    $('#guardar').click(function() {
        var val_correo = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        if ($('#nacionalidad').val() == 0) {
            $('#nacionalidad').addClass('has-error');
        } else if ($('#cedula').val() === null || $('#cedula').val().length === 0 || $('#cedula').val().length < 7 || /^\s+$/.test($('#cedula').val())) {
            $('#div_cedula').addClass('has-error');
            $('#cedula').focus();
        } else if ($('#nombre').val() === null || $('#nombre').val().length === 0 || $('#nombre').val().length < 2 || /^\s+$/.test($('#nombre').val())) {
            $('#div_nombre').addClass('has-error');
            $('#nombre').focus();
        } else if ($('#apellido').val() === null || $('#apellido').val().length === 0 || $('#apellido').val().length < 2 || /^\s+$/.test($('#apellido').val())) {
            $('#div_apellido').addClass('has-error');
            $('#apellido').focus();
        } else if ($('#email').val().length > 0 && !val_correo.test($('#email').val())) {
            $('#div_email').addClass('has-error');
            $('#email').focus();
        } else if ($('#cod_telefono').val() > 0 && ($('#telefono').val().length < 7)) {
            $('#div_telefono').addClass('has-error');
            $('#telefono').focus();
        } else if ($('#cod_celular').val() == 0) {
            $('#cod_celular').addClass('has-error');
            $('#cod_celular').focus();
        } else if ($('#celular').val().length < 7) {
            $('#div_celular').addClass('has-error');
            $('#celular').focus();
        } else if ($('#placa').val() === null || $('#placa').val().length === 0 || $('#placa').val().length < 8 || /^\s+$/.test($('#placa').val())) {
            $('#div_placa').addClass('has-error');
            $('#placa').focus();
        } else if ($('#modelo').val() === null || $('#modelo').val().length === 0 || /^\s+$/.test($('#modelo').val())) {
            $('#div_modelo').addClass('has-error');
            $('#modelo').focus();
        } else if ($('#color').val() === null || $('#color').val().length === 0 || /^\s+$/.test($('#color').val())) {
            $('#div_color').addClass('has-error');
            $('#color').focus();
        } else {

            $('#accion').val($(this).text());
            var nombres = $('#nombre').val() + ' ' + $('#apellido').val();
            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            var cod_telefono = $('#cod_telefono').find(' option').filter(":selected").text();
            var cod_celular = $('#cod_celular').find(' option').filter(":selected").text();
            var telefonos = '';
            if(cod_telefono > 0){
                telefonos += cod_telefono + '-' + $('#telefono').val()
            }
            if(cod_celular > 0){
                 telefonos = cod_celular + '-' + $('#celular').val()
            }
            
            if ($(this).text() == 'Guardar') {

                $.post("../../controlador/Choferes.php", $("#frmchoferes").serialize(), function(respuesta) {
                    if (respuesta == 1) {
                        window.parent.bootbox.alert("Registro con Exito", function() {
// Agregar los datos a la tabla
                            var nacionalidad = $('#nacionalidad').find(' option').filter(":selected").text();
                            var cedula = nacionalidad + '-' + $('#cedula').val();
                            var $check_cedula = '<input type="checkbox" name="cedula[]" value="' + cedula + '" />';
                            var newRow = TChoferes.fnAddData([$check_cedula, cedula, nombres, telefonos, modificar, eliminar]);
                            // Agregar el id a la fila estado
                            var oSettings = TChoferes.fnSettings();
                            var nTr = oSettings.aoData[ newRow[0] ].nTr;
                            $('input[type="text"]').val('');
                            $('#cod_telefono,#cod_celular').select2('val', 0);
                            $('#nacionalidad').select2('val', 0);
                        });
                    } else if (respuesta == 13) {
                        window.parent.bootbox.alert("La Cédula se encuentra Registrada", function() {
                            $('#div_cedula').addClass('has-error');
                            $('#cedula').focus().select();
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
                            $.post("../../controlador/Choferes.php", $("#frmchoferes").serialize(), function(respuesta) {
                                if (respuesta == 1) {
                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();
                                    window.parent.bootbox.alert("Modificacion con Exito", function() {

                                        // Modificar la fila 1 en la tabla
                                        $("#tabla_choferes tbody tr:eq(" + fila + ")").find("td:eq(2)").html(nombres);
                                        $("#tabla_choferes tbody tr:eq(" + fila + ")").find("td:eq(3)").html(telefonos);
                                        $('input[type="text"]').val('');
                                        $('#cod_telefono,#cod_celular').select2('val', 0);
                                        $('#nacionalidad').select2('val', 0);
                                        
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
    /********Proceso de modificacion*************/
    $('table#tabla_choferes').on('click', 'img.modificar', function() {

// borra el campo fila
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var cedula_c = padre.children('td:eq(1)').text();
        var dat_cedula = cedula_c.split('-');
        var cedula = dat_cedula[1];
        // obtener la fila a modificar
        var fila = padre.index();
        $('#guardar').text('Modificar');
//        $('#cedula').val(cedula).prop('disabled',true);
        $('#cedula').val(cedula);
        $('#registro_choferes').slideDown(2000);
        $('#reporte_choferes').slideUp(2000);
        $.post("../../controlador/Choferes.php", {cedula: cedula, accion: 'BuscarDatos'}, function(respuesta) {
            var datos = respuesta.split(";");
            $('#nacionalidad').select2('val', datos[0]);
            $('#nombre').val(datos[1]);
            $('#apellido').val(datos[2]);
            $('#email').val(datos[3]);
            $('#cod_telefono').select2('val', datos[4]);
            $('#telefono').val(datos[5]);
            $('#cod_celular').select2('val', datos[6]);
            $('#celular').val(datos[7]);
            $('#placa').val(datos[8]);
            $('#modelo').val(datos[9]);
            $('#color').val(datos[10]);
            // crear el campo fila y añadir la fila
            var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
            $($fila).prependTo($('#frmchoferes'));
            
//            var $cedula = '<input type="hidden" id="cedula"  value="' + cedula + '" name="cedula">';
//            $($cedula).appendTo($('#frmchoferes'));
        });
    });
    
    
    /********Proceso de eliminacion por construir*************/
    // proceso de eliminacion
    $('table#tabla_choferes').on('click', 'img.eliminar', function() {
        $('#cedula').val(cedula);
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

                    var cedula = padre.children('td:eq(1)').text();
                    $.post("../../controlador/Choferes.php", {'accion': 'Eliminar', 'cedula': cedula}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TChoferes.fnDeleteRow(nRow);
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
            $('#registro_choferes').slideUp(2000);
            $('#reporte_choferes').slideDown(2000);
            $('input[type="text"]').val('');
            $('#cod_telefono,#cod_celular').select2('val', 0);
            $('#nacionalidad').select2('val', 0);
        });		
		
        $('#limpiar').click(function() {
            $('input[type="text"]').val('');
            $('#cod_telefono,#cod_celular').select2('val', 0);
            $('#nacionalidad').select2('val', 0);
            $('#guardar').text('Guardar');
        });		
    
});

