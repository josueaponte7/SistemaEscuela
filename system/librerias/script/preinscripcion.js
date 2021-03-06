$(document).ready(function() {
    var TPreinscrip = $('#tabla_preinscrip').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "8%"},
            {"sClass": "center", "sWidth": "10%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "8%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "35%"}
        ]
    });

    $('#cedula').select2({'width': '250'});

    $('.tooltip_ced').tooltip({
        html: true,
        placement: 'bottom',
        title: 'Click para ver opciones'
    });

    var $contextMenu = $("#contextMenu");
    var cedula = '';
    //var url = '';

    $("table#tabla_preinscrip").on("click", "span.sub-rayar", function(e) {
        $('.dropdown').hide();
        cedula = $(this).text().substr(2);
        $contextMenu.css({
            display: "block",
            left: e.pageX,
            top: e.pageY
        });
        return false;
    });

    $contextMenu.on("click", "span", function() {
        var url = 'vista/procesos/ver_datos_preinscripcion.php';
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

    $(document).keyup(function(event) {
        if (event.which == 27) {// Tecla escape
            $('.dropdown').hide();
        }
    });

    $(document).click(function() {
        $('.dropdown').hide();
    });

    $('#registrar').click(function() {
        $('#registro_preinscrip').slideDown(2000);
        $('#reporte_preinscrip').slideUp(2000);
    });

    /**Los monta todos***/
    $('#todos').on('change', function() {
        var TotalRow = TPreinscrip.fnGetData().length;
        var nodes = TPreinscrip.fnGetNodes();
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
    $('table#tabla_preinscrip').on('change', 'input:checkbox[name="cedula[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TPreinscrip.fnGetNodes();
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
        var url = '../reportes/reporte_preinscripcion.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="cedula[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TPreinscrip.fnGetNodes();
            $("input:checkbox[name='cedula[]']:checked", nodes).each(function() {
                var $chkbox = $(this);
                var $actualrow = $chkbox.closest('tr');
                var cedula = $actualrow.find('td:eq(2)').text();
                checkboxValues += cedula.substr(2) + ',';
            });
            checkboxValues = checkboxValues.substring(0, checkboxValues.length - 1);
            url = url + '?cedula=' + checkboxValues;
        }
        window.open(url);
    });

    $('#cedula').change(function() {
        var cedula = $(this).val();
        if (cedula != 0) {
            $.post("../../controlador/Preinscripcion.php", {cedula: cedula, accion: 'Buscar'}, function(respuesta) {
                if (respuesta != 0) {
                    var datos = respuesta.split(';');
                    $('#num_registro').val(datos[0]);
                    $('#nombre').val(datos[1]);
                    $('#fech_naci').val(datos[2]);
                    $('#edad').val(datos[4]);
                    $('#sexo').val(datos[3]);
                    $('#telefono').val(datos[5]);
                    $('#celular').val(datos[6]);
                } else {

                }
            });
        }
    });

    $('#guardar').click(function() {

        $('#accion').val($(this).text());
        // Imagenes de modificar y eliminar
        // var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';

        if ($(this).text() == 'Guardar') {
            // obtener el ultimo codigo del status 

            var telefonos = $('#telefono').val() + ' ' + $('#celular').val();
            var nombres = $('#nombre').val();
            

            $('#num_registro').attr('disabled', false);
            $.post("../../controlador/Preinscripcion.php", $("#formpreinscripcion").serialize(), function(respuesta) {
                $('#num_registro').attr('disabled', true);
                if (respuesta == 1) {

                    window.parent.bootbox.alert("Registro con Exito", function() {
                        setTimeout(function(){
                            window.location.href='preinscripcion.php?id=0';
                        });
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
                        $.post("../../controlador/Preinscripcion.php", $("#formpreinscripcion").serialize(), function(respuesta) {
                            if (respuesta == 1) {
                                // obtener la fila a modificar
                                var fila = $("#fila").val();
                                window.parent.bootbox.alert("Modificacion con Exito", function() {

                                    /**********Modificar la fila 1 en la tabla esto creo que no va***************/
                                    /*$("#tabla_preinscrip tbody tr:eq(" + fila + ")").find("td:eq(1)").html($('#cedula').val());
                                     $("#tabla_preinscrip tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#nombre').val());
                                     $("#tabla_preinscrip tbody tr:eq(" + fila + ")").find("td:eq(3)").html($('#fech_naci').val());
                                     $("#tabla_preinscrip tbody tr:eq(" + fila + ")").find("td:eq(3)").html($('#edad').val());
                                     $("#tabla_preinscrip tbody tr:eq(" + fila + ")").find("td:eq(3)").html($('#sexo').val());
                                     $("#tabla_preinscrip tbody tr:eq(" + fila + ")").find("td:eq(3)").html($('#telefono').val());
                                     $("#tabla_preinscrip tbody tr:eq(" + fila + ")").find("td:eq(3)").html($('#celular').val());*/
                                    $('input:text').val('');
                                    $('#datos').select2('val', 0);

                                });
                            }
                        });
                    }
                }
            });
        }
    });
    ;

    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_preinscrip').slideUp(2000);
        $('#reporte_preinscrip').slideDown(2000);
        $('input:text').val('');
        $('select').select2('val', 0);
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('#guardar').text('Guardar');
        $('select').select2('val', 0);
    });

});

function padLeft(nr, n, str) {
    return Array(n - String(nr).length + 1).join(str || '0') + nr;
}
//or as a Number prototype method:
Number.prototype.padLeft = function(n, str) {
    return Array(n - String(this).length + 1).join(str || '0') + this;
}