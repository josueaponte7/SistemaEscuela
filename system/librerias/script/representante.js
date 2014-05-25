$(document).ready(function() {
    var TRepresentante = $('#tabla_representante').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "3%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "10%"},
            {"sClass": "center", "sWidth": "35%"},
            {"sClass": "center", "sWidth": "35%"},
            {"sClass": "center", "sWidth": "10"},
            {"sWidth": "2%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "2%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    $('#nacionalidad').select2({
        minimumResultsForSearch: -1
    });

    $('#estado, #municipio, #parroquia, #estatus, #nivel_inst, #profesion, #sexo, #cod_telefono, #cod_celular').select2();

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre, #apellido').validar(letra);

    var numero = '0123456789';
    $('#telefono, #celular, #cedula, #fuente_ingreso').validar(numero);

    $('.tooltip_ced').tooltip({
        html: true,
        placement: 'bottom',
        title: 'Click para ver opciones'
    });

    var $contextMenu = $("#contextMenu");
    var cedula = '';

    $("table#tabla_representante").on("click", "span.sub-rayar", function(e) {
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

    $('#registrar').click(function() {
        $('#registro_erepresentante').slideDown(2000);
        $('#reporte_representante').slideUp(2000);
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

    /****Calendario*****/
    $('#fech_naci').datepicker({
        language: "es",
        format: 'dd/mm/yyyy',
        startDate: "-75y",
        endDate: "-28y",
        autoclose: true
    }).on('changeDate', function(ev) {
        var edad = calcular_edad($(this).val());
        $('#edad').val(edad);
        $('#div_fech_naci').removeClass('has-error');
    });

    /**Los monta todos***/
    $('#todos').change(function() {
        var TotalRow = TRepresentante.fnGetData().length;
        var nodes = TRepresentante.fnGetNodes();
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
    $('table#tabla_representante').on('change', 'input:checkbox[name="cedula[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TRepresentante.fnGetNodes();
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
        var url = '../reportes/listado_representante.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="cedula[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TRepresentante.fnGetNodes();
            $("input:checkbox[name='cedula[]']:checked", nodes).each(function() {
                var $chkbox = $(this);
                var $actualrow = $chkbox.closest('tr');
                var cedulas = $actualrow.find('td:eq(1)').text()
                checkboxValues += cedulas.substr(2) + ',';

            });
            checkboxValues = checkboxValues.substring(0, checkboxValues.length - 1);
            url = url + '?cedulas=' + checkboxValues;
        }
        window.open(url);
    });

    $('#guardar').click(function() {
        //window.parent.$("body").animate({scrollTop:0}, 'slow'); 
        if ($('#nacionalidad').val() == 0) {
            /*********window parent para que la validacion llegue a su lugar********/
            window.parent.scrollTo(0, 300);
            $('#nacionalidad').addClass('has-error');
            //$('#nacionalidad').focus();
        } else if ($('#cedula').val() === null || $('#cedula').val().length === 0 || /^\s+$/.test($('#cedula').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_cedula').addClass('has-error');
            $('#cedula').focus();
        } else if ($('#nombre').val() === null || $('#nombre').val().length === 0 || /^\s+$/.test($('#nombre').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_nombre').addClass('has-error');
            $('#nombre').focus();
        } else if ($('#apellido').val() === null || $('#apellido').val().length === 0 || /^\s+$/.test($('#apellido').val())) {
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
        } else if ($('#cod_telefono').val() == 0) {
            window.parent.scrollTo(0, 300);
            $('#cod_telefono').addClass('has-error');
            $('#cod_telefono').focus();
        } else if ($('#telefono').val() === null || $('#telefono').val().length === 0 || /^\s+$/.test($('#telefono').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_telefono').addClass('has-error');
            $('#telefono').focus();
        } else if ($('#cod_celular').val() == 0) {
            window.parent.scrollTo(0, 600);
            $('#cod_celular').addClass('has-error');
            $('#cod_celular').focus();
        } else if ($('#celular').val() === null || $('#celular').val().length === 0 || /^\s+$/.test($('#celular').val())) {
            window.parent.scrollTo(0, 600);
            $('#div_celular').addClass('has-error');
            $('#celular').focus();
        } else if ($('#lugar_naci').val() === null || $('#lugar_naci').val().length === 0 || /^\s+$/.test($('#lugar_naci').val())) {
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
        } else if ($('#calle').val() === null || $('#calle').val().length === 0 || /^\s+$/.test($('#calle').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_calle').addClass('has-error');
            $('#calle').focus();
        } else if ($('#casa').val() === null || $('#casa').val().length === 0 || /^\s+$/.test($('#casa').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_casa').addClass('has-error');
            $('#casa').focus();
        } else if ($('#edificio').val() === null || $('#edificio').val().length === 0 || /^\s+$/.test($('#edificio').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_edificio').addClass('has-error');
            $('#edificio').focus();
        } else if ($('#barrio').val() === null || $('#barrio').val().length === 0 || /^\s+$/.test($('#barrio').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_barrio').addClass('has-error');
            $('#barrio').focus();
        } else if ($('#estatus').val() == 0) {
            $('#estatus').addClass('has-error');
            window.parent.scrollTo(0, 700);
        } else if ($('#antecedente').val() === null || $('#antecedente').val().length === 0 || /^\s+$/.test($('#antecedente').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_antecedente').addClass('has-error');
            $('#antecedente').focus();
        } else if ($('#nivel_inst').val() == 0) {
            $('#nivel_inst').addClass('has-error');
            window.parent.scrollTo(0, 700);
        } else if ($('#profesion').val() == 0) {
            $('#profesion').addClass('has-error');
            window.parent.scrollTo(0, 700);
        } else if ($('#fuente_ingreso').val() === null || $('#fuente_ingreso').val().length === 0 || /^\s+$/.test($('#fuente_ingreso').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_fuente_ingreso').addClass('has-error');
            $('#fuente_ingreso').focus();
        } else if ($('#email').val() === null || $('#email').val().length === 0 || /^\s+$/.test($('#email').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_email').addClass('has-error');
            $('#email').focus();
        } else {
            $('#accion').val($(this).text());

            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';

            var cod_telefono = $('#cod_telefono').find(' option').filter(":selected").text();
            var cod_celular = $('#cod_celular').find(' option').filter(":selected").text();
            var telefonos = cod_telefono + '-' + $('#telefono').val() + ', ' + cod_celular + '-' + $('#celular').val();

            if ($(this).text() == 'Guardar') {
                // obtener el ultimo codigo del status 
                var ToltalRow = TRepresentante.fnGetData().length;
                var lastRow = TRepresentante.fnGetData(ToltalRow - 1);
                var cedula = parseInt(lastRow[1]) + 1;

//            var $check_cedula = '<input type="checkbox" name="cedula[]" value="' + cedula + '" />';
                $.post("../../controlador/Representante.php", $("#frmrepresentante").serialize(), function(respuesta) {
                    if (respuesta == 1) {

                        //obtener el nombre de la estatus
                        var estatus = $('#estatus').find(' option').filter(":selected").text();
                        // obtener el id de la actividad
                        var id_estatus = $('#estatus').find(' option').filter(":selected").val();

                        window.parent.bootbox.alert("Registro con Exito", function() {

                            var nacionalidad = $('#nacionalidad').find(' option').filter(":selected").text();
                            var cedula = nacionalidad + '-' + $('#cedula').val();
                            var nombres = $('#nombre').val() + ' ' + $('#apellido').val();
                            var $check_cedula = '<input type="checkbox" name="cedula[]" value="' + cedula + '" />';

//                    alert('Registro con Exito');
                            var newRow = TRepresentante.fnAddData([$check_cedula, cedula, nombres, telefonos, estatus, modificar, eliminar]);


                            // Agregar el id a la fila estado
                            var oSettings = TRepresentante.fnSettings();
                            var nTr = oSettings.aoData[ newRow[0] ].nTr;
                            $('td', nTr)[4].setAttribute('id', id_estatus);

                            $('input[type="text"]').val('');
                            $('textarea').val('');
                            $('#estado,#municipio,#parroquia,#estatus,#sexo,#cod_telefono,#cod_celular,#nivel_inst,#profesion').select2('val', 0);
                            $('#nacionalidad').select2('val', 1);
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
                            $.post("../../controlador/Representante.php", $("#frmrepresentante").serialize(), function(respuesta) {
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {

                                        // obtener el nombre de la actividad
//                                      var actividad = $('#actividad').find(' option').filter(":selected").text();

//                                        // obtener el id de la actividad
//                                        var id_actividad = $('#actividad').find(' option').filter(":selected").val();
                                        // obtener el nombre de la actividad
                                        var estatus = $('#estatus').find(' option').filter(":selected").text();
//
//                                        // obtener el id de la actividad
                                        var id_estatus = $('#estatus').find(' option').filter(":selected").val();
                                        //var actividad = $('#actividad').find('option:selected').text();

                                        // Modificar la fila 1 en la tabla                                       
                                        $("#tabla_representante tbody tr:eq(" + fila + ")").find("td:eq(3)").html(telefonos);
                                        //$("#tabla_docente tbody tr:eq(" + fila + ")").find("td.eq(4)").html(actividad);

                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_representante tbody tr:eq(" + fila + ")").find("td:eq(4)").html(estatus);
                                        $("#tabla_representante tbody tr:eq(" + fila + ")").find("td:eq(4)").attr('id', id_estatus);

                                        $('input[type="text"]').val('');
                                        $('textarea').val('');
                                        $('#estado,#municipio,#parroquia,#estatus,#sexo,#cod_telefono,#cod_celular,#nivel_inst,#profesion').select2('val', 0);
                                        $('#nacionalidad').select2('val', 1);
                                    });
                                }
                            });
                        }
                    }
                });
            }
        }
    });


    $('table#tabla_representante').on('click', 'img.modificar', function() {

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
        $('#registro_erepresentante').slideDown(2000);
        $('#reporte_representante').slideUp(2000);

        $.post("../../controlador/Representante.php", {cedula: cedula, accion: 'BuscarDatos'}, function(respuesta) {
            var datos = respuesta.split(";");
            $('#nacionalidad').select2('val', datos[0]);
            $('#nombre').val(datos[1]);
            $('#apellido').val(datos[2]);
            $('#sexo').select2('val', datos[3]);
            $('#fech_naci').val(datos[4]);
            $('#edad').val(datos[5]);
            $('#cod_telefono').select2('val', datos[6]);
            $('#telefono').val(datos[7]);
            $('#cod_celular').select2('val', datos[8]);
            $('#celular').val(datos[9]);
            $('#lugar_naci').val(datos[10]);
            $('#estado').select2('val', datos[11]);
            var id_mun = datos[12];
            var id_parr = datos[13];
            $('#municipio').find('option:gt(0)').remove().end();

            $.post('../../controlador/Municipio.php', {id_estado: datos[11], accion: 'buscarMun'}, function(respuesta) {
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
            $('#calle').val(datos[14]);
            $('#casa').val(datos[15]);
            $('#edificio').val(datos[16]);
            $('#barrio').val(datos[17]);
            $('#estatus').select2('val', datos[18]);
            $('#antecedente').val(datos[19]);
            $('#nivel_inst').select2('val', datos[20]);
            $('#profesion').select2('val', datos[21]);
            $('#fuente_ingreso').val(datos[22]);
            $('#email').val(datos[23]);

            // crear el campo fila y añadir la fila
            var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
            $($fila).prependTo($('#frmrepresentante'));

            var $cedula = '<input type="hidden" id="cedula"  value="' + cedula + '" name="cedula">';
            $($cedula).appendTo($('#frmrepresentante'));
        });
    });

    // modificar las funciones de eliminar
    $('table#tabla_representante').on('click', 'img.eliminar', function() {
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
                    $.post("../../controlador/Representante.php", {'accion': 'Eliminar', 'cedula': cedula}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TRepresentante.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                            });


                        }
                    });
                }
            }
        });

    });

    $('#salir').click(function() {
        $('#registro_erepresentante').slideUp(2000);
        $('#reporte_representante').slideDown(2000);
        $('input:text').val('');
        $('textarea').val('');
        $('#estado,#municipio,#parroquia,#estatus,#sexo,#cod_telefono,#cod_celular,#nivel_inst,#profesion').select2('val', 0);
        $('#nacionalidad').select2('val', 0);
        $('#guardar').text('Guardar');
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('textarea').val('');
        $('#estado,#municipio,#parroquia,#estatus,#sexo,#cod_telefono,#cod_celular,#nivel_inst,#profesion').select2('val', 0);
        $('#nacionalidad').select2('val', 0);
        $('#guardar').text('Guardar');
    });
});
