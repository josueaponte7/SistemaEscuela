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
    
    var letra = '1234567890';
    $('#cant_habitacion').validar(letra);
    
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
    $('#represent_nivel').select2();
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
        $('#fila').remove();
        var fila = $('table#tabla_inscripcion tbody tr').children('td:eq(1):contains("'+cedula+'")').index();
        
        var f   = new Date();
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
       
        $('input:checkbox').prop('checked',false);
        $('input:checkbox').prop('disabled',false);
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
   
                var datos    = respuesta.split(';');
                var anio_vi  = datos[0];
                
                $('#tipo_estudiante').val(datos[2]);
                //Datos inscripcion
                if(anio_vi == 'i'){
                    $('#fecha').val(datos[3]);
                   
                    $('#actividad').select2('val', datos[6]);
                    $('#area').val(datos[7]);
                    $('#guardar').text('Modificar');
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frminscripcion'));
                    $('#medio').select2('val', datos[12]);
                    $('#cedula_cho').val(datos[13]);
                    $('#cedula_cho').trigger('blur');
                }
      
                
                // datos representante
                $('#cedula_r').val(datos[8]);
                $('#nombre_r').val(datos[9]);
                $('#apellido_r').val(datos[10]);
                $('#parentesco').val(datos[11]);
                
            });
        }
    });
    
    $('#medio').change(function(){
         $('input:text[id$="cho"],#placa').val('');
        if($(this).val() !=0){
            if($(this).val() == 1){
                $('#cedula_cho').prop('disabled',true);
                $('input:text[id$="cho"],#placa').val('');
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
        var accion = $(this).text();
        $('#accion').val(accion);
        $('#cedula_r,#tipo_estudiante').prop('disabled', false);
        
        if (accion == 'Guardar') {
            $.post("../../controlador/Inscripcion.php", $('#frminscripcion').serialize(), function(respuesta) {
                $('#cedula_r,#tipo_estudiante').prop('disabled', true);
                if(respuesta == 1){
                    window.parent.bootbox.alert("Registro con Exito", function() {
                        var cedula = $('#cedula').find('option:selected').val();
                        var $check = '<input type="checkbox" name="cedula[]" value="' + cedula + '" />';
                        var dat_c = $('#cedula').find('option:selected').text();
                        var dat_n = dat_c.split(' ');

                        delete dat_n[0];
                        var nombre = dat_n.join(' ');
                        var tipo = $('#tipo_estudiante').val();
                        var anio = $('#anio_escolar').val();
                        var fecha = $('#fecha').val();
                        var actividad = $('#actividad').find('option:selected').text();

                        var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
                        var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';

                        TInscripcion.fnAddData([$check, cedula, nombre, tipo, anio, actividad, fecha, modificar, eliminar]);

                    });
                 }else{
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
                        $.post("../../controlador/Inscripcion.php", $("#frminscripcion").serialize(), function(respuesta) {
                            if (respuesta == 1) {
                                var actividad = $('#acitvidad').find('option:selected').text();
                                // obtener la fila a modificar
                                var fila = $("#fila").val();

                                window.parent.bootbox.alert("Modificacion con Exito", function() {
                                    // Modificar la fila 1 en la tabla 
                                    $("table#tabla_inscripcion tbody tr:eq(" + fila + ")").find("td:eq(24)").html(actividad);
                                    $('input[type="text"]').val('');

                                });

                            }
                        });
                    }
                }
            });
        }
    });
    
   
    var url ="../../controlador/Inscripcion.php";
   
    $("#SignupForm").formToWizard({
        next: 'Guardar y Seguir',
        prev: 'Atras',
        finalize: 'Finalizar',
        url: url,
        message:'Registro con Exito'
    });
    
     $('#cdt_generales.link').on('click',function() {
        var cedula = $('select#cedula').find('option:selected').val();
        cedula = cedula.substring(2);
        $('input:checkbox').prop('checked',false);
        $('input:checkbox').prop('disabled',false);
        $('fil_datos_genereles select').select2('val',0).prop('disabled',false);
        $.post(url,{cedula:cedula,'accion':'BuscarDG'},function(respuesta){
            
            if(respuesta != 0){
                var datos = respuesta.split(';');
                //alert(datos.length);
                if(datos[0] == 1){
                    $('#padre_f').prop('checked',true).trigger('change');
                }
                if(datos[1] == 2){
                    $('#madre_f').prop('checked',true).trigger('change');
                }
                if(datos[2] == 1){
                    $('#padre_pl').prop('checked',true).trigger('change');
                }
                if(datos[3] == 2){
                    $('#madre_pl').prop('checked',true).trigger('change');
                }
                if(datos[4] == 1){
                   $('#padre_al').prop('checked',true).trigger('change');
                }
                if(datos[5] == 2){
                    $('#madre_al').prop('checked',true).trigger('change');
                }
                if(datos[6] == 3){
                    $('#represent_al').prop('checked',true).trigger('change');
                }
                if(datos[7] == 1){
                    $('#padre_fd').prop('checked',true).trigger('change');
                }
                if(datos[8] == 2){
                    $('#madre_fd').prop('checked',true).trigger('change');
                }
                if(datos[9] == 3){
                    $('#represent_fd').prop('checked',true).trigger('change');
                }

                
                $('input:checkbox[name="dt_padres[padre_alf]"][value="'+datos[10]+'"]').prop('checked',true).trigger('change'); 
                $('input:checkbox[name="dt_padres[madre_alf]"][value="'+datos[11]+'"]').prop('checked',true).trigger('change'); 
                $('input:checkbox[name="dt_padres[represent_alf]"][value="'+datos[12]+'"]').prop('checked',true).trigger('change'); 

                $('#padre_nivel').select2('val',datos[13]);
                $('#madre_nivel').select2('val',datos[14]);
                $('#represent_nivel').select2('val',datos[15]);

                if (datos[16] == 1) {
                    $('#padre_set').prop('checked', true).trigger('change');
                }
                if (datos[17] == 2) {
                    $('#madre_set').prop('checked', true).trigger('change');
                }

                if (datos[18] == 1) {
                    $('#padre_see').prop('checked', true).trigger('change');
                }
                if (datos[19] == 2) {
                    $('#madre_see').prop('checked', true).trigger('change');
                }
                
                var datos_if = datos[20].split(',');
                for (var i = 0;i < datos_if.length;i++){
                    $('input:checkbox[name="id_ingreso[]"][value="'+datos_if[i]+'"]').prop('checked',true); 
                }
                
                // Programa Social
                var datos_ps = datos[21].split(',');
                for (var i = 0;i < datos_ps.length;i++){
                    $('input:checkbox[name="mision[]"][value="'+datos_ps[i]+'"]').prop('checked',true); 
                }
               
                // Datos Vivienda
                $('#ubicacion_vivienda').select2('val',datos[22]);
                $('#tipo_vivienda').select2('val',datos[23]);
                $('#estado_vivienda').select2('val',datos[24]);
                $('#cant_habitacion').val(datos[25]);
                $('#cama').select2('val',datos[26]);
                // Datos Tecnologico
                var datos_tec = datos[27].split(',');
                for (var i = 0;i < datos_tec.length;i++){
                    $('input:checkbox[name="tecnologia[]"][value="'+datos_tec[i]+'"]').prop('checked',true); 
                }
                
                // Datos Diversidad Funcional
                var datos_df = datos[28].split(',');
                for (var i = 0;i < datos_df.length;i++){
                    $('input:checkbox[name="diversidad[]"][value="'+datos_df[i]+'"]').prop('checked',true); 
                }

                // Datos Enfermedes
                var datos_de = datos[29].split(',');
                for (var i = 0;i < datos_de.length;i++){
                    $('input:checkbox[name="enfermedad[]"][value="'+datos_de[i]+'"]').prop('checked',true); 
                }
                
                // Datos Servicios
                var datos_ds = datos[30].split(',');
                for (var i = 0;i < datos_ds.length;i++){
                    $('input:checkbox[name="servicio[]"][value="'+datos_ds[i]+'"]').prop('checked',true); 
                }
                
                // Datos Destreza
                var datos_des = datos[31].split(',');
                for (var i = 0;i < datos_des.length;i++){
                    $('input:checkbox[name="destreza[]"][value="'+datos_des[i]+'"]').prop('checked',true); 
                }
                
                // Datos Alimentacion
                $('#alimentacion').select2('val',datos[32]);
                $('#alimentacion_regular').select2('val',datos[33]);
                
                 // Datos Ayuda
                var datos_day = datos[34].split(',');
                for (var i = 0;i < datos_day.length;i++){
                    $('input:checkbox[name="ayuda[]"][value="'+datos_day[i]+'"]').prop('checked',true); 
                }

            }
            
        });
        $(this).addClass('activo');
        $('#rest_generales').fadeIn(1000);
        $('#datos_repre').slideUp(1500);
        $('#main').slideDown(1500);
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


    $('input:checkbox[name^="dt_padres"][name$="_f]"]').change(function (){
        
        var id_repre = $(this).attr('id');
        
        var res = id_repre.split("_");
        var repre =  res[0];
        var repre_pl = repre+'_pl';
        var repre_al = repre+'_al';
        var repre_fd = repre+'_fd';
        var repre_set = repre+'_set';
        var repre_see = repre+'_see';
        if($(this).is(':checked')){
            $('#'+repre_pl+',#'+repre_al+',#'+repre_fd+',#'+repre_set+',#'+repre_see+'').prop('disabled',true).prop('checked',false);
        }else{
            $('#'+repre_pl+',#'+repre_al+',#'+repre_fd+',#'+repre_set+',#'+repre_see+'').prop('disabled',false);
        }
    });
    
    $('input:checkbox[name^="dt_padres"][name$="_alf]"]').change(function (){
        
        var id_repre    = $(this).attr('id');
        var res         = id_repre.split("_");
        var repre       = res[0];
        var sufijo      = res[1];
        var repre_alf   = repre + '_alf';
        var repre_anl   = repre + '_anl';
        var repre_nivel = repre + '_nivel';
        var repre_see   = repre + '_see';
        if ($(this).is(':checked')) {
            if (sufijo == 'alf') {
                $('#' + repre_anl).prop('disabled', true).prop('checked', false);
            }else{
               $('#' + repre_alf+',#'+repre_nivel+',#'+repre_see).prop('disabled', true).prop('checked', false);
            }
        } else {
            if (sufijo == 'alf') {
                $('#' + repre_anl).prop('disabled', false);
            }else{
               $('#' + repre_alf+',#'+repre_nivel+',#'+repre_see).prop('disabled', false);
            }
        }
    });
    
    $('table#tabla_inscripcion').on('click', 'img.modificar', function() {
        
        $('#registro_inscripcion').slideDown(2000);
        $('#reporte_inscripcion').slideUp(2000);
        
        $('#fila').remove();
        var padre = $(this).closest('tr');
        var cedula = padre.children('td:eq(1)').text();

        $('#cedula').select2('val',cedula);
        $('#cedula').trigger('change');
        // obtener la fila a modificar
        var fila = padre.index();

        $('#guardar').text('Modificar'); 
        
          var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
        $($fila).prependTo($('#frminscripcion'));
   });

});


