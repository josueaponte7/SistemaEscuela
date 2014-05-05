$(document).ready(function() {
    var TInscripcion = $('#tabla_inscripcion').dataTable({
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
            {"sClass": "center", "sWidth": "20%"},
            {"sClass": "center", "sWidth": "20%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    $('#registrar').click(function() {
        $('#registro_inscripcion').slideDown(2000);
        $('#reporte_inscripcion').slideUp(2000);
    });

    $('#cedula').select2();
    //$('#tipo_estudainte').select2();
    //$('#anio_escolar').select2();
    $('#actividad').select2();
    $('#cod_telefono').select2();
    $('#medio').select2();
    $('#padre_nivel').select2();
    $('#madre_nivel').select2();
    $('#representante_nivel').select2();
    $('#ubicacion_vivienda').select2();
    $('#tipo_vivienda').select2();
    $('#estado_vivienda').select2();
    $('#cama').select2();
    $('#alimentacion').select2();
    $('#alimentacion_regular').select2();


    $('#cedula').change(function() {
        var cedula = $(this).val();
        $('#fil_datos_genereles').fadeOut();
        $('#rest_generales').trigger('click');
        $('#guardar').text('Guardar');
        
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
        
        
        if (cedula != 0) {
            $.post("../../controlador/Inscripcion.php", {cedula: cedula, 'accion': 'BuscarDatos'}, function(respuesta) {
                $().toastmessage('showToast', {
                    text: 'Activado Modulo de Datos Generales',
                    sticky: false,
                    stayTime: 3000,
                    position : 'top-right',
                    type: 'notice'
                });
                 
                $('#cdt_generales').css('color','#FF0000');
                $('#fil_datos_genereles').fadeIn();
                 
                var datos = respuesta.split(';');
                $('#madre_f,#madre_pl').prop('disabled',false);
                $('#padre_f,#padre_pl').prop('disabled',false);
                
                $('#cedula_r').val(datos[1]);
                $('#nombre_r').val(datos[2]);
                $('#apellido_r').val(datos[3]);
                $('#parentesco').val(datos[4]);
                 $('#tipo_estudiate').val(datos[7]);
                 
                if (datos[0] == 1) {
                    
                    $('#id_tipo').val(datos[5]);
                    $('#fecha').val(datos[8]);
                    $('#actividad').select2('val', datos[10]);
                    $('#area').val(datos[11]);
                    $('#medio').select2('val', datos[12]);
                    $('#cedula_cho').val(datos[13]);
                    $('#cedula_cho').trigger('blur');
                    $('#guardar').text('Modificar')
                    if(datos[4] == 'Madre' || datos[14] == 1 || datos[15] == 1){
                        $('#madre_f,#madre_pl').prop('disabled',true);
                    }
                    if(datos[4] == 'Padre' || datos[14] == 2 || datos[15] == 2){
                        $('#padre_f,#padre_pl').prop('disabled',true);
                    }
                    if(datos[16] == 1){
                        $('#existedt').val(1);
                    }
                }

            });
        }
    });
    
    $('#medio').change(function(){
        if($(this).val() !=0){
            if($(this).val() == 1){
                $('#cedula_cho').prop('disabled',true);
            }else{
                $('#cedula_cho').prop('disabled',false);
            }
        }
    });
    
    $('#cedula_cho').blur(function() {
        if ($(this).val()!= '') {
            $.post("../../controlador/Choferes.php", {cedula: $(this).val(), 'accion': 'BuscarChofer'}, function(respuesta) {
                var datos = respuesta.split(';');
                $('#nombre_cho').val(datos[0]);
                $('#apellido_cho').val(datos[1]);
                $('#placa').val(datos[2]);
                $('#telefono_cho').val(datos[3]);
            });
        }
    });
    
    $('#guardar').click(function(){
        $('#cedula_r').prop('disabled',false);
        $.post("../../controlador/Inscripcion.php", $('#frminscripcion').serialize(), function(respuesta) {
           $('#cedula_r').prop('disabled',true);
           if(respuesta == 1){
                alert("Registro con exito");
           }
        });
    });
    
    $('#cdt_generales.link').on('click',function() {
        $(this).addClass('activo');
        $('#rest_generales').fadeIn(1000);
        $('#datos_repre').slideUp(1500);
        $('#main').slideDown(1500);
    });
    var url ="../../controlador/Inscripcion.php";
   
    $("#SignupForm").formToWizard({
        next: 'Siguiente',
        prev: 'Atras',
        finalize: 'Finalizar',
        url: url,
        message:'Registro con Exito'
    });
    
    $('#rest_generales').click(function() {
        var count = $('#main').find("fieldset.paso").length;

        $('#SignupForm').find('form').css('display', 'none');
        $("#step0").show();
        $("#steps li").removeClass("current");
        $("#stepDesc0").addClass("current");

        $(this).fadeOut(1000);
        $('#cdt_generales').removeClass('activo');
        $('#datos_repre').slideDown(1500);
        $('#main').slideUp(1500);
    });

    
    
    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_inscripcion').slideUp(2000);
        $('#reporte_inscripcion').slideDown(2000);
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });


    $('input:checkbox[name="representante_f[]"]').change(function (){
        var id_repre = $(this).attr('id');
        var res = id_repre.split("_");
        var repre =  res[0];
        var repre_alf = repre+'_alf';
        var repre_anl = repre+'_anl';
        if($(this).is(':checked')){
            $('input:checkbox[id^="'+repre+'"]').not('#'+id_repre+',#'+repre_alf+',#'+repre_anl+'').prop('disabled',true).prop('checked',false);
        }else{
            $('input:checkbox[id^="'+repre+'"]').not('#'+id_repre).prop('disabled',false);
        }
    });
    
    $('input:checkbox[name="representante_a[]"]').change(function (){
        
        var id_repre = $(this).attr('id');
        var res = id_repre.split("_");
        
        var repre =  res[0];
        
        var repre_alf = repre+'_alf';
        var repre_anl = repre+'_anl';

        if ($(this).is(':checked')) {
            if (res[1] == 'alf') {
                $('input:checkbox#' + repre_anl).prop('disabled', true).prop('checked', false);
            }else{
               $('input:checkbox#' + repre_alf).prop('disabled', true).prop('checked', false);
            }
        } else {
            if (res[1] == 'alf') {
                $('input:checkbox#' + repre_anl).prop('disabled', false);
            }else{
               $('input:checkbox#' + repre_alf).prop('disabled', false);
            }
        }
    });
    
    /*$('input:checkbox[name="representante_a[]"]').change(function (){
        var id_repre = $(this).attr('id');
        var res = id_repre.split("_");
        var repre =  res[0];
         var repre_alf = repre+'_alf';
        var repre_anl = repre+'_anl';
        if($(this).is(':checked')){
            $('input:checkbox[id="'+repre_alf+'"]').not('#'+repre_anl).prop('disabled',true).prop('checked',false);
            $('select[id="'+repre+'_nivel"]').prop('disabled',true).val(0);
        }else{
            $('input:checkbox[id^="'+repre_alf+'"]').not('#'+repre_anl).prop('disabled',false);
             $('select[id="'+repre+'_nivel"]').prop('disabled',false);
        }
    });*/

});


