<<<<<<< HEAD

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


    $('#nacionalidad').select2();
    $('#estado').select2();
    $('#municipio').select2();
    $('#parroquia').select2();
    $('#estatus').select2();
    $('#nivel_inst').select2();
    $('#profesion').select2();
    $('#sexo').select2();
    $('#cod_telefono').select2();
    $('#cod_celular').select2();

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
    });

    $('#registrar').click(function() {
        $('#registro_erepresentante').slideDown(2000);
        $('#reporte_representante').slideUp(2000);
    });

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
                        $('#nacionalidad').select2('val', 0);
                        $('#sexo').select2('val', 0);
                        $('#cod_telefono').select2('val', 0);
                        $('#cod_celular').select2('val', 0);
                        $('textarea').val('');
                        $('#estado').select2('val', 0);
                        $('#municipio').select2('val', 0);
                        $('#parroquia').select2('val', 0);
                        $('#estatus').select2('val', 0);
                        $('#nivel_inst').select2('val', 0);
                        $('#profesion').select2('val', 0);

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
                                    $('$#nacionalidad').select2('val', 0);
                                    $('#sexo').select2('val', 0);
                                    $('#cod_telefono').select2('val', 0);
                                    $('#cod_celular').select2('val', 0);
                                    $('textarea').val('');
                                    $('#estado').select2('val', 0);
                                    $('#municipio').select2('val', 0);
                                    $('#parroquia').select2('val', 0);
                                    $('#estatus').select2('val', 0);
                                    $('#nivel_inst').select2('val', 0);
                                    $('#profesion').select2('val', 0);
                                });
                            }
                        });
                    }
                }
            });
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

    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_erepresentante').slideUp(2000);
        $('#reporte_representante').slideDown(2000);
        $('input:text').val('');
        $('textarea').val('');
        $('$#nacionalidad').select2('val', 0);
        $('#estado').select2('val', 0);
        $('#municipio').select2('val', 0);
        $('#parroquia').select2('val', 0);
        $('#estatus').select2('val', 0);
        $('#sexo').select2('val', 0);
        $('#cod_telefono').select2('val', 0);
        $('#cod_celular').select2('val', 0);
        $('#nivel_inst').select2('val', 0);
        $('#profesion').select2('val', 0);
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('textarea').val('');
        $('$#nacionalidad').select2('val', 0);
        $('#estado').select2('val', 0);
        $('#municipio').select2('val', 0);
        $('#parroquia').select2('val', 0);
        $('#estatus').select2('val', 0);
        $('#sexo').select2('val', 0);
        $('#cod_telefono').select2('val', 0);
        $('#cod_celular').select2('val', 0);
        $('#nivel_inst').select2('val', 0);
        $('#profesion').select2('val', 0);
        $('#guardar').text('Guardar');
    });



    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre').validar(letra);
    $('#apellido').validar(letra);

    var numero = '0123456789';
    $('#telefono').validar(numero);
    $('#celular').validar(numero);
    $('#cedula').validar(numero);
    $('#fuente_ingreso').validar(numero);


});


=======

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


    $('#nacionalidad').select2();
    $('#estado').select2();
    $('#municipio').select2();
    $('#parroquia').select2();
    $('#estatus').select2();
    $('#nivel_inst').select2();
    $('#profesion').select2();
    $('#sexo').select2();
    $('#cod_telefono').select2();
    $('#cod_celular').select2();

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
    });

    $('#registrar').click(function() {
        $('#registro_erepresentante').slideDown(2000);
        $('#reporte_representante').slideUp(2000);
    });

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
                        $('#nacionalidad').select2('val',1);
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
                                    $('#nacionalidad').select2('val',1);
                                });
                            }
                        });
                    }
                }
            });
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

    $('#salir').click(function() {        
        $('#registro_erepresentante').slideUp(2000);
        $('#reporte_representante').slideDown(2000);
        $('input:text').val('');
        $('textarea').val('');
        $('#estado,#municipio,#parroquia,#estatus,#sexo,#cod_telefono,#cod_celular,#nivel_inst,#profesion').select2('val', 0);
        $('#nacionalidad').select2('val',1);
        $('#guardar').text('Guardar');
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('textarea').val('');
        $('#estado,#municipio,#parroquia,#estatus,#sexo,#cod_telefono,#cod_celular,#nivel_inst,#profesion').select2('val', 0);
        $('#nacionalidad').select2('val',1);
        $('#guardar').text('Guardar');
    });



    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre').validar(letra);
    $('#apellido').validar(letra);

    var numero = '0123456789';
    $('#telefono').validar(numero);
    $('#celular').validar(numero);
    $('#cedula').validar(numero);
    $('#fuente_ingreso').validar(numero);


});


>>>>>>> 7fcf50fe4daf2bd28ce736001a25ed1613779293
