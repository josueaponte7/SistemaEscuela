$(document).ready(function() {
    var TReinscripcion = $('#tabla_reinscripcion').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "10%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "20%"},
            {"sClass": "center", "sWidth": "20%"},            
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    var letra = '1234567890';
    $('#cant_habitacion,#cedula_r').validar(letra);
    
    $('#registrar').click(function() {
        $('#registro_reinscripcion').slideDown(2000);
        $('#reporte_reinscripcion').slideUp(2000);
   });  
    
    $('#cedula').select2();
    //$('#tipo_estudainte').select2();
    $('#anio_escolar').select2();
    $('#actividad').select2();
//    $('#parentesco').select2();
    $('#medio').select2();
  
    
    
        /**Los monta todos reporte***/
    $('#todos').change(function() {
        var TotalRow = TReinscripcion.fnGetData().length;
        var nodes    = TReinscripcion.fnGetNodes();
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

    /***Monta de uno del reporte***/
    $('table#tabla_reinscripcion').on('change', 'input:checkbox[name="cedula[]"]', function() {
        $('#todos').prop('checked', false);
        var nodes = TReinscripcion.fnGetNodes();
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
        var url = '../reportes/reporte_inscripcion.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="cedula[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TInscripcion.fnGetNodes();
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


    $('#cedula').change(function() {
        var cedula = $(this).val();
        //$('#fil_datos_genereles').fadeOut();
        //$('#rest_generales').trigger('click');
        $('#guardar').text('Re-Inscribir');
        $('#fila').remove();
        var fila = $('table#tabla_reinscripcion tbody tr').children('td:eq(1):contains("' + cedula + '")').index();

        var f = new Date();
        var dia = f.getDate();
        var mes = f.getMonth() + 1;
        var pad = '00';
        var dia = (pad + dia).slice(-pad.length);
        var mes = (pad + mes).slice(-pad.length);
        var fecha = dia + "-" + mes + "-" + f.getFullYear();
        $('input:text,textarea').val('');
        $('#actividad,#medio').select2('val', 0);
        $('#fecha').val(fecha);
        $('#anio_escolar').val(f.getFullYear());

        $('input:checkbox').prop('checked', false);
        $('input:checkbox').prop('disabled', false);
        if (cedula != 0) {
            $.post("../../controlador/Inscripcion.php", {cedula: cedula, 'accion': 'BuscarDatos'}, function(respuesta) {

                var datos = respuesta.split(';');
                var anio_vi = datos[0];
                
                $('#inscrito').val(datos[0]);
                $('#tipo_estudiante').val(datos[2]);
                
                //Datos inscripcion
                if (anio_vi == 'i') {
                    $('#fecha').val(datos[3]);
                    
                    $('#actividad').select2('val', datos[6]);
                    $('#area').val(datos[7]);
                    $('#guardar').text('Re-Inscribir');
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frmreinscripcion'));
                    $('#medio').select2('val', datos[12]);
                    if (datos[13] > 0) {
                        $('#cedula_cho').prop('disabled', false);
                        $('#cedula_cho').val(datos[13]);
                        $('#cedula_cho').trigger('blur');
                    } else {
                        $('#cedula_cho').prop('disabled', true);
                    }

                }
                var cedula_r = datos[8].substr(2);
                $('#cedula_r').val(cedula_r);
                $('#nombre_r').val(datos[9]);
                $('#apellido_r').val(datos[10]);
                $('#parentesco').val(datos[11]);

            });
        }
    });
    
    $('#cedula_r').change(function() {
        var este = $(this);
        if ($(this).val() != '') {
            
            $.post("../../controlador/Inscripcion.php", {cedula_r: $(this).val(), 'accion': 'BuscarRep'}, function(respuesta) {
                if (respuesta != 0) {
                    var datos = respuesta.split(';');
                   
                     $('#nombre_r').val(datos[0]);
                     $('#apellido_r').val(datos[1]);
                     $('#parentesco').val(datos[2]);

                } else {
                    window.parent.bootbox.alert("La C&eacute;dula no se encuentra registrada", function () {
                        este.parent('div').addClass('has-error');
                        este.focus();
                        $('#nombre_r,#apellido_r,#parentesco').val('');
                    });
                }
            });
        }
    });

    $('#medio').change(function() {
        $('input:text[id$="cho"],#placa').val('');
        $('#div_cedula_cho').removeClass('has-error');

        if ($(this).val() > 1) {
            $('#cedula_cho').prop('disabled', false);
            $('input:text[id$="cho"],#placa').val('');
        } else {
            $('#cedula_cho').prop('disabled', true);
        }

    });

    $('#cedula_cho').change(function() {
        var este = $(this);
        if ($(this).val() != '') {
            $('input:text[id$="cho"],#placa').not('#cedula_cho').val('');
            $.post("../../controlador/Choferes.php", {cedula: $(this).val(), 'accion': 'BuscarChofer'}, function(respuesta) {
                if (respuesta != 0) {
                    var datos = respuesta.split(';');
                    $('#nombre_cho').val(datos[0]);
                    $('#apellido_cho').val(datos[1]);
                    $('#placa').val(datos[2]);
                    $('#telefono_cho').val(datos[3]);

                } else {
                    window.parent.bootbox.alert("La C&eacute;dula no se encuentra registrada", function () {
                        este.parent('div').addClass('has-error');
                        este.focus();
                    });
                }
            });
        }
    });

    $('#guardar').click(function() {
        var accion = $(this).text();
        $('#accion').val(accion);
        //$('#cedula_r,#tipo_estudiante').prop('disabled', false);
        var $cedula = $('#cedula').find('option').filter(':selected').val();
        var $actividad = $('#actividad').find('option').filter(':selected').val();
        var $medio = $('#medio').find('option').filter(':selected').val();
        if($cedula == 0){
            $('#cedula').select2('focus');
            $('#cedula').addClass('has-error').focus();
        }else if ($actividad == 0) {
            $('#actividad').select2('focus');
            $('#actividad').addClass('has-error').focus();
        } else if ($('#area').val() === null || $('#area').val().length === 0 || /^\s+$/.test($('#area').val())) {
            $('#div_actividad').addClass('has-error');
            $('#area').focus();
        } else if ($medio == 0) {
            $('#medio').select2('focus');
            $('#medio').addClass('has-error').focus();
        } else if ($medio > 1 && ($('#cedula_cho').val() === null || $('#cedula_cho').val().length === 0 || /^\s+$/.test($('#cedula_cho').val()))) {
            $('#div_cedula_cho').addClass('has-error');
            $('#cedula_cho').focus();
        } else {
            if (accion == 'Re-Inscribir') {
                $('#fecha').prop('disabled', false);
                $.post("../../controlador/Inscripcion.php", $('#frmreinscripcion').serialize(), function(respuesta) {
                    $('#tipo_estudiante,#fecha').prop('disabled', true);
                    if (respuesta == 1) {                        
                        
                        window.parent.bootbox.alert("Re-Inscripci&oacute;n con Exito", function() {
                            setTimeout(function(){
                                window.location.href='reinscripcion.php?id=0';
                            });
                        });
                    } else {
                        
                        
                        window.parent.bootbox.alert("Ocurrio un error comuniquese con informatica", function() {
                            
                        });
                    }
                });
            }
        }
    });


// $('table#tabla_reinscripcion').on('click', 'img.modificar', function() {
//
//        $('#registro_reinscripcion').slideDown(2000);
//        $('#reporte_reinscripcion').slideUp(2000);
//
//        $('#fila').remove();
//        var padre = $(this).closest('tr');
//        var cedula = padre.children('td:eq(1)').text();
//
//        $('#cedula').select2('val', cedula);
////        $('#cedula').trigger('change');
//        // obtener la fila a modificar
//        var fila = padre.index();
//
//        $('#guardar').text('Modificar');
//
//        var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
//        $($fila).prependTo($('#frmreinscripcion'));
//    });
    
     $('#limpiar').click(function() {
        $('input:text').val('');
        $('select').select2('val', 0);
        $('textarea').val('');
        $('#guardar').text('Re-Inscribir');
    });

    $('#salir').click(function() {
        //$('#guardar').text('Inscribir');
        $('#registro_reinscripcion').slideUp(2000);
        $('#reporte_reinscripcion').slideDown(2000);
        $('input:text').val('');
        $('select').select2('val', 0);
        $('textarea').val('');
        
    });
   


//    $('input:checkbox[name^="dt_padres"][name$="_f]"]').change(function() {
//
//        var id_repre = $(this).attr('id');
//
//        var res = id_repre.split("_");
//        var repre = res[0];
//        var repre_pl = repre + '_pl';
//        var repre_al = repre + '_al';
//        var repre_fd = repre + '_fd';
//        var repre_set = repre + '_set';
//        var repre_see = repre + '_see';
//        if ($(this).is(':checked')) {
//            $('#' + repre_pl + ',#' + repre_al + ',#' + repre_fd + ',#' + repre_set + ',#' + repre_see + '').prop('disabled', true).prop('checked', false);
//        } else {
//            $('#' + repre_pl + ',#' + repre_al + ',#' + repre_fd + ',#' + repre_set + ',#' + repre_see + '').prop('disabled', false);
//        }
//    });

//    $('input:checkbox[name^="dt_padres"][name$="_alf]"]').change(function() {
//
//        var id_repre = $(this).attr('id');
//        var res = id_repre.split("_");
//        var repre = res[0];
//        var sufijo = res[1];
//        var repre_alf = repre + '_alf';
//        var repre_anl = repre + '_anl';
//        var repre_nivel = repre + '_nivel';
//        var repre_see = repre + '_see';
//        if ($(this).is(':checked')) {
//            if (sufijo == 'alf') {
//                $('#' + repre_anl).prop('disabled', true).prop('checked', false);
//            } else {
//                $('#' + repre_alf + ',#' + repre_nivel + ',#' + repre_see).prop('disabled', true).prop('checked', false);
//            }
//        } else {
//            if (sufijo == 'alf') {
//                $('#' + repre_anl).prop('disabled', false);
//            } else {
//                $('#' + repre_alf + ',#' + repre_nivel + ',#' + repre_see).prop('disabled', false);
//            }
//        }
//    });

   

});





