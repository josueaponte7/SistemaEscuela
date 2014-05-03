$(document).ready(function() {
    var TChoferes = $('#tabla_choferes').dataTable({
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
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });    
    
    $('#nacionalidad').select2();
    $('#cod_telefono').select2();
    $('#cod_celular').select2();
    
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
                var cedula = $actualrow.find('td:eq(1)').text()
                checkboxValues += cedula.substr(2) + ',';
            });
            checkboxValues = checkboxValues.substring(0, checkboxValues.length - 1);
            url = url + '?cedula=' + checkboxValues;
        }
        window.open(url);
    });
    
    $('#guardar').click(function() {        
            $('#accion').val($(this).text());
            // Imagenes de modificar y eliminar
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
            if ($(this).text() == 'Guardar') {
                // obtener el ultimo codigo del status 
                var ToltalRow = TChoferes.fnGetData().length;
                var lastRow = TChoferes.fnGetData(ToltalRow - 1);
                var cedula = parseInt(lastRow[1]) + 1;                
                var $check_cedula = '<input type="checkbox" name="cedula[]" value="' + cedula + '" />';
                $.post("../../controlador/Choferes.php", $("#frmchoferes").serialize(), function(respuesta) {
                    if (respuesta == 1) {                        
                      
                      
                        window.parent.bootbox.alert("Registro con Exito", function() {
                            // Agregar los datos a la tabla
                            var nacionalidad = $('#nacionalidad').find(' option').filter(":selected").text();
                            var cedula = nacionalidad + '-' + $('#cedula').val();
                            var newRow = TChoferes.fnAddData([$check_cedula, cedula,
                                $('#nombre').val(), $('#apellido').val(), modificar, eliminar]);
                            // Agregar el id a la fila estado
                            var oSettings = TChoferes.fnSettings();
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
                            $.post("../../controlador/Choferes.php", $("#frmchoferes").serialize(), function(respuesta) {
                                if (respuesta == 1) {
                                    // obtener la fila a modificar
                                    var fila = $("#fila").val();
                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                      
                                        // Modificar la fila 1 en la tabla 
                                        $("#tabla_docente tbody tr:eq(" + fila + ")").find("td:eq(1)").html($('#cedula').val());
                                        $("#tabla_docente tbody tr:eq(" + fila + ")").find("td:eq(2)").html($('#nombre').val());
                                        $("#tabla_docente tbody tr:eq(" + fila + ")").find("td:eq(3)").html($('#apellido').val());
                                       
                                        $('input[type="text"]').val('');
                                    });
                                }
                            });
                        }
                    }
                });
            }        
    });
        
    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_choferes').slideUp(2000);
        $('#reporte_choferes').slideDown(2000);
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });
    
    
    
});
