$(document).ready(function() {
    var TDocente = $('#tabla_docente').dataTable({
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
    
     $('#imgfechaNac').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>La Fecha Nacimiento no puede estar en blanco<br/>'
    });
    
     $('#imgtelcel').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>El Teléfono Celular no puede estar en blanco<br/>'
    });
    
     $('#imgestado').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>El Estado no puede estar en blanco<br/>'
    });
    
     $('#imgparroquia').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>La Parroquia no puede estar en blanco<br/>'
    });
    
     $('#imgcasa').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>Casa o Apto no puede estar en blanco<br/>'
    });
    
     $('#imgbarrio').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>Barrio o Urb no puede estar en blanco<br/>'
    });
    
    $('#imgestatus').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>El Estatus no puede estar en blanco<br/>'
    });
    
    
    /**************Derecho****************/
    $('#imgnombre').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>El Nombre no debe estar en blanco<br/>'
    });
    
    $('#imgsexo').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>El Sexo no debe estar en blanco<br/>'
    });
    
      $('#imglugarNac').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>El Lugar de Nacimiento no debe estar en blanco<br/>'
    });
    
     $('#imgminicipio').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>El Municipio no debe estar en blanco<br/>'
    });
    
      $('#imgcalle').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>La Calle no debe estar en blanco<br/>'
    });
    
      $('#imgactividad').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>La Actividad no debe estar en blanco<br/>'
    });
    
    
    
    
    
    /************************************/
    $('#nacionalidad').select2({
        minimumResultsForSearch: -1
    });

    $('#estado, #municipio, #parroquia, #estatus, #actividad, #sexo, #cod_telefono,#cod_celular ').select2();

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre, #apellido').validar(letra);
    ;

    var numero = '0123456789';
    $('#telefono, #celular, #cedula').validar(numero);
    
    var correo = '0123456789abcdefghijklmnopqrstuvwxyz_-.#$&*@';
    $('#email').validar(correo);
    
    
    $('#registrar').click(function() {
        $('#registro_docente').slideDown(2000);
        $('#reporte_docente').slideUp(2000);
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
    
    $('.tooltip_ced').tooltip({
        html: true,
        placement: 'bottom',
        title: 'Click para ver opciones'
    });

    var $contextMenu = $("#contextMenu");
    var cedula = '';

    $("table#tabla_docente").on("click", "span.sub-rayar", function(e) {
        $('.dropdown').hide();
        cedula = $(this).text().substr(2);
        $contextMenu.css({
            display: "block",
            left: e.pageX,
            top: e.pageY
        });
    });

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


    /**Los monta todos***/
    $('#todos').change(function() {
        var TotalRow = TDocente.fnGetData().length;
        var nodes = TDocente.fnGetNodes();
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
    $('table#tabla_docente').on('change', 'input:checkbox[name="cedula[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TDocente.fnGetNodes();
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
        var url = '../reportes/reporte_docente.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="cedula[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TDocente.fnGetNodes();
            $("input:checkbox[name='cedula[]']:checked", nodes).each(function() {
                var $chkbox = $(this);
                var $actualrow = $chkbox.closest('tr');
                var cedula = $actualrow.find('td:eq(1)').text()
                checkboxValues += cedula.substr(2) + ',';
            });
            checkboxValues = checkboxValues.substring(0, checkboxValues.length - 1);
            url = url + '?cedula=' + checkboxValues;
        }
        window.open(url);
    });

    /***Combos **/
    $('#estado').change(function() {
        var id = $(this).val();
        $('#municipio,#parroquia').select2('val', 0);
        $('#municipio,#parroquia').find('option:gt(0)').remove().end();
        if (id > 0) {
            $.post('../../controlador/Municipio.php', {id_estado: id, accion: 'buscarMun'}, function(respuesta) {
                var option = "";
                $.each(respuesta, function(i, obj) {
                    option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
                });
                $('#municipio').append(option);
            }, 'json');
        }
    });

    $('#municipio').change(function() {
        var id = $(this).val();
        $('#parroquia').select2('val', 0);
        $('#parroquia').find('option:gt(0)').remove().end();
        $.post('../../controlador/Parroquia.php', {id_municipio: id, accion: 'buscarParr'}, function(respuesta) {
            var option = "";
            $.each(respuesta, function(i, obj) {
                option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
            });
            $('#parroquia').append(option);
        }, 'json');
    });

    /****Calendario*****/
    $('#fech_naci').datepicker({
        language: "es",
        format: 'dd/mm/yyyy',
        startDate: "-60y",
        endDate: "-20y",
        autoclose: true
    }).on('changeDate', function(ev) {
        var edad = calcular_edad($(this).val());
        $('#edad').val(edad);
        $('#div_fech_naci').removeClass('has-error');

    });

    /********Proceso de registro**************/
    $('#guardar').click(function() {
        var val_correo = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        
        var $cod_telefono = $('#cod_telefono').find('option').filter(':selected').val();
  
        //window.parent.$("body").animate({scrollTop:0}, 'slow'); 
        if ($('#nacionalidad').val() == 0) {
            /*********window parent para que la validacion llegue a su lugar********/
            window.parent.scrollTo(0, 300);
            $('#nacionalidad').addClass('has-error');
            //$('#nacionalidad').focus();
        } else if ($('#cedula').val() === null || $('#cedula').val().length === 0 || $('#cedula').val().length < 7  || /^\s+$/.test($('#cedula').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_cedula').addClass('has-error');
            $('#cedula').focus();
        } else if ($('#nombre').val() === null || $('#nombre').val().length === 0 || $('#nombre').val().length < 2 || /^\s+$/.test($('#nombre').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_nombre').addClass('has-error');
            $('#nombre').focus();
        } else if ($('#apellido').val() === null || $('#apellido').val().length === 0 || $('#apellido').val().length < 2 || /^\s+$/.test($('#apellido').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_apellido').addClass('has-error');
            $('#apellido').focus();
        } else if ($('#sexo').val() == 0) {
            window.parent.scrollTo(0, 300);
            $('#sexo').addClass('has-error');
        } else if ($('#fech_naci').val() === null || $('#fech_naci').val().length === 0 || /^\s+$/.test($('#fech_naci').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_fech_naci').addClass('has-error');
            $('#fech_naci').focus();
        } else if ($('#email').val().length > 0 && !val_correo.test($('#email').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_email').addClass('has-error');
            $('#email').focus();
        } else if ($('#cod_telefono').val() > 0 && $('#telefono').val().length < 7) {
            window.parent.scrollTo(0, 300);
            $('#div_telefono').addClass('has-error');
            $('#telefono').focus();
        } else if ($('#cod_celular').val() == 0) {
            window.parent.scrollTo(0, 600);
            $('#cod_celular').addClass('has-error');
            $('#cod_celular').focus();
        } else if ($('#celular').val().length < 7 ) {
            window.parent.scrollTo(0, 600);
            $('#div_celular').addClass('has-error');
            $('#celular').focus();
        } else if ($('#lugar_naci').val() === null || $('#lugar_naci').val().length === 0 || $('#lugar_naci').val().length < 5 || /^\s+$/.test($('#lugar_naci').val())) {
            window.parent.scrollTo(0, 600);
            $('#div_lugar_naci').addClass('has-error');
            $('#lugar_naci').focus();
        } else if ($('#estado').val() == 0) {
            window.parent.scrollTo(0, 700);
            $('#estado').addClass('has-error');
        } else if ($('#municipio').val() == 0) {
            window.parent.scrollTo(0, 700);
            $('#municipio').addClass('has-error');
        } else if ($('#parroquia').val() == 0) {
            window.parent.scrollTo(0, 700);
            $('#parroquia').addClass('has-error');
        } else if ($('#calle').val() === null || $('#calle').val().length === 0 || $('#calle').val().length < 1 || /^\s+$/.test($('#calle').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_calle').addClass('has-error');
            $('#calle').focus();
        } else if ($('#casa').val() === null || $('#casa').val().length === 0 || $('#casa').val().length < 2 || /^\s+$/.test($('#casa').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_casa').addClass('has-error');
            $('#casa').focus();
        } else if ($('#edificio').val().length > 0   && $('#edificio').val().length < 2 ) {
            window.parent.scrollTo(0, 700);
            $('#div_edificio').addClass('has-error');
            $('#edificio').focus();
        }else if ($('#barrio').val() === null || $('#barrio').val().length === 0 || $('#barrio').val().length < 5 || /^\s+$/.test($('#barrio').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_barrio').addClass('has-error');
            $('#barrio').focus();
        } else if ($('#estatus').val() == 0) {
            $('#estatus').addClass('has-error');
            window.parent.scrollTo(0, 700);
        } else if ($('#actividad').val() == 0) {
            $('#actividad').addClass('has-error');
            window.parent.scrollTo(0, 700);
        } else {
            $('#accion').val($(this).text());
            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';

            if ($(this).text() == 'Guardar') {
                

                $.post("../../controlador/Docente.php", $("#frmdocente").serialize(), function(respuesta) {
                    if (respuesta == 1) {

                        // obtener el nombre del sexo
                        /*var sexo = $('#sexo').find(' option').filter(":selected").text();

                        // obtener el nombre del estado 
                        var estado = $('#estado').find(' option').filter(":selected").text();

                        // obtener el nombre del municipio
                        var municipio = $('#municipio').find(' option').filter(":selected").text();

                        // obtener el nombre del parroquia
                        var parroquia = $('#parroquia').find(' option').filter(":selected").text();

                        // obtener el nombre del estatus
                        var estatus = $('#estatus').find(' option').filter(":selected").text();*/

                        // obtener el nombre de la actividad
//                        var actividad = $('#actividad').find(' option').filter(":selected").text();
//                        // obtener el id de la actividad
//                        var id_actividad = $('#actividad').find(' option').filter(":selected").val();

                        var actividad = $('#actividad').find('option:selected').text();

                        window.parent.bootbox.alert("Registro con Exito", function() {
                            // Agregar los datos a la tabla
                            var nacionalidad = $('#nacionalidad').find(' option').filter(":selected").text();
                            var cedula = nacionalidad + '-' + $('#cedula').val();                            
                            
                            var nacionalidad = $('#nacionalidad').find(' option').filter(":selected").text();
                            var cedula = nacionalidad + '-' + $('#cedula').val();
                            var nombres = $('#nombre').val() + ' ' + $('#apellido').val();
                            
                            var $check_cedula = '<input type="checkbox" name="cedula[]" value="' + cedula + '" />';                            
                            
                            var newRow = TDocente.fnAddData([$check_cedula, cedula, $('#nombre').val(), $('#apellido').val(), actividad, modificar, eliminar]);

                            // Agregar el id a la fila estado
                            var oSettings = TDocente.fnSettings();
                            var nTr = oSettings.aoData[ newRow[0] ].nTr;
//                            $('td', nTr)[4].setAttribute('id', id_actividad);
                            $('#actividad').select2('val', 0);
                            $('div,#actividad').removeClass('has-error');

                            $('input:text').val('');
                            $('textarea').val('');
                            $('#estado,#municipio,#parroquia,#estatus,#sexo,#cod_telefono,#cod_celular').select2('val', 0);
                            $('#municipio,#parroquia').find('option:gt(0)').remove().end();
                            $('#nacionalidad').select2('val', 0);
                        });
                    } else if (respuesta == 13) {
                        window.parent.bootbox.alert("La Cédula se encuentra Registrada", function() {
                            window.parent.scrollTo(0, 300);
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
                            $.post("../../controlador/Docente.php", $("#frmdocente").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {

                                        // obtener el nombre de la actividad
//                                      var actividad = $('#actividad').find(' option').filter(":selected").text();

//                                        // obtener el id de la actividad
//                                        var id_actividad = $('#actividad').find(' option').filter(":selected").val();
                                        // obtener el nombre de la actividad
                                        var actividad = $('#actividad').find(' option').filter(":selected").text();
//
//                                        // obtener el id de la actividad
                                        var id_actividad = $('#actividad').find(' option').filter(":selected").val();
                                        //var actividad = $('#actividad').find('option:selected').text();

                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_docente tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#nombre').val());
                                        $("#tabla_docente tbody tr:eq(" + fila + ")").find("td:eq(3)").html($('#apellido').val());
                                        //$("#tabla_docente tbody tr:eq(" + fila + ")").find("td.eq(4)").html(actividad);

                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_docente tbody tr:eq(" + fila + ")").find("td:eq(4)").html(actividad);
                                        $("#tabla_docente tbody tr:eq(" + fila + ")").find("td:eq(4)").attr('id', id_actividad);

                                        $('input[type="text"]').val('');
                                        $('textarea').val('');
                                        $('#estado,#municipio,#parroquia,#estatus,#sexo,#cod_telefono,#cod_celular,#actividad').select2('val', 0);
                                        $('#municipio,#parroquia').find('option:gt(0)').remove().end();
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

    /*********Proceso de modificacion**********/
    $('table#tabla_docente').on('click', 'img.modificar', function() {

        // borra el campo fila
        $('#fila').remove();
        var padre      = $(this).closest('tr');
        var cedula_c   = padre.children('td:eq(1)').text();
        var dat_cedula = cedula_c.split('-');
        var cedula     = dat_cedula[1];
        var nombre     = padre.children('td:eq(2)').html();
        var apellido   = padre.children('td:eq(3)').html();

        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar');

//        $('#cedula').val(cedula).prop('disabled',true);
        $('#cedula').val(cedula);
        $('#nombre').val(nombre);
        $('#apellido').val(apellido);
        $('#registro_docente').slideDown(2000);
        $('#reporte_docente').slideUp(2000);

        $.post("../../controlador/Docente.php", {cedula: cedula, accion: 'BuscarDatos'}, function(respuesta) {
            var datos = respuesta.split(";");

            $('#sexo').select2('val', datos[0]);
            $('#fech_naci').val(datos[1]);
            $('#edad').val(datos[2]);
            $('#email').val(datos[3]);
            $('#cod_telefono').select2('val', datos[4]);
            $('#telefono').val(datos[5]);
            $('#cod_celular').select2('val', datos[6]);
            $('#celular').val(datos[7]);
            $('#lugar_naci').val(datos[8]);
            $('#estado').select2('val', datos[9]);
            var id_mun = datos[10];
            var id_parr = datos[11];
            $('#municipio').find('option:gt(0)').remove().end();

            $.post('../../controlador/Municipio.php', {id_estado: datos[9], accion: 'buscarMun'}, function(respuesta) {
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
            $('#calle').val(datos[12]);
            $('#casa').val(datos[13]);
            $('#edificio').val(datos[14]);
            $('#barrio').val(datos[15]);
            $('#estatus').select2('val', datos[16]);
            $('#actividad').select2('val', datos[17]);
            $('#nacionalidad').select2('val', datos[18]);

            // crear el campo fila y añadir la fila
            var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
            $($fila).prependTo($('#frmdocente'));

//            var $cedula = '<input type="hidden" id="cedula"  value="' + cedula + '" name="cedula">';
//            $($cedula).appendTo($('#frmdocente'));
        });
    });

// proceso de eliminacion
    $('table#tabla_docente').on('click', 'img.eliminar', function() {
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
                    $.post("../../controlador/Docente.php", {'accion': 'Eliminar', 'cedula': cedula}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TDocente.fnDeleteRow(nRow);

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
        $('#registro_docente').slideUp(2000);
        $('#reporte_docente').slideDown(2000);
        $('#limpiar').trigger('click');
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('textarea').val('');        
        $('select').select2('val', 0);
        $('select,div').removeClass('has-error');
        $('#municipio,#parroquia').find('option:gt(0)').remove().end();
        $('#nacionalidad').select2('val', 0);
        $('#guardar').text('Guardar');
    });

});

