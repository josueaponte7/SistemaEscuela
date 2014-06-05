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
        
        $('#actividad').select2('val',0);
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
                var anio_vi = datos[0];
                
                $('#tipo_estudiante').val(datos[2]);
                //Datos inscripcion
                if(anio_vi == 'i'){
                    $('#fecha').val(datos[3]);
                   
                    $('#actividad').select2('val', datos[6]);
                    $('#area').val(datos[7]);
                    $('#guardar').text('Modificar');
                    var $fila = '<input type="hidden" id="fila"  value="' + fila + '" name="fila">';
                    $($fila).prependTo($('#frminscripcion'));
                }
                $('#tipo_estudiante').val(dat_ex[2]);
                // datos representante
                var dat_repre = datos[1].split(';');
   
                $('#madre_f,#madre_pl').prop('disabled',false);
                $('#padre_f,#padre_pl').prop('disabled',false);
                
                $('#cedula_r').val(dat_repre[0]);
                $('#nombre_r').val(dat_repre[1]);
                $('#apellido_r').val(dat_repre[2]);
                $('#parentesco').val(dat_repre[3]);
                
                // datos medio trasporte y chofer
                var dat_medio = datos[2].split(';');
                $('#medio').select2('val', dat_medio[0]);
                $('#cedula_cho').val(dat_medio[1]);
                $('#cedula_cho').trigger('blur');
                
                var dat_represents = datos[3].split(';');
                if (dat_repre[3] == 'Madre' || dat_represents[0] == 1 || dat_represents[1] == 1) {
                    $('#madre_f,#madre_pl').prop('disabled', true);
                }
                if (dat_repre[3] == 'Padre' || dat_represents[0] == 2 || dat_represents[1] == 2) {
                    $('#padre_f,#padre_pl').prop('disabled', true);
                }   
                
                var datg_padres = datos[4].split(';');

                if(datg_padres[0] == 1){
                    $('#padre_f').prop('checked',true);
                }
                if(datg_padres[1] == 1){
                    $('#madre_f').prop('checked',true);
                }
                if(datg_padres[2] == 1){
                    $('#padre_pl').prop('checked',true);
                }
                if(datg_padres[3] == 1){
                    $('#madre_pl').prop('checked',true);
                }
                if(datg_padres[4] == 1){
                    $('#padre_al').prop('checked',true);
                }
                if(datg_padres[5] == 1){
                    $('#madre_al').prop('checked',true);
                }
                if(datg_padres[6] == 1){
                    $('#represent_al').prop('checked',true);
                }
                if(datg_padres[7] == 1){
                    $('#padre_fd').prop('checked',datg_padres[8]);
                }
                if(datg_padres[8] == 1){
                    $('#madre_fd').prop('checked',datg_padres[8]);
                }
                if(datg_padres[9] == 1){
                    $('#represent_fd').prop('checked',datg_padres[8]);
                }

                if(datg_padres[10] == 'ps'){
                    $('#padre_alf').prop('checked',datg_padres[8]);
                    $('#padre_anl').prop('disabled',true);
                }else if(datg_padres[10] == 'pn'){
                   $('#padre_anl').prop('checked',datg_padres[8]);
                   $('#padre_alf').prop('disabled',true); 
                }
                if(datg_padres[11] == 'ms'){
                    $('#madre_alf').prop('checked',datg_padres[8]);
                    $('#madre_anl').prop('disabled',true);
                }else if(datg_padres[11] == 'mn'){
                    $('#madre_anl').prop('checked',datg_padres[8]);
                    $('#madre_alf').prop('disabled',true); 
                }
                if(datg_padres[12] == 'rs'){
                    $('#represent_alf').prop('checked',datg_padres[8]);
                    $('#represent_anl').prop('disabled',true);
                }else if(datg_padres[12] == 'rn'){
                    $('#represent_anl').prop('checked',datg_padres[8]);
                    $('#represent_alf').prop('disabled',true); 
                }
                var np = datg_padres[13];
                var nm = datg_padres[14];
                var nr = datg_padres[15];
                if(datg_padres[13] == ''){
                    np = 0;
                }
                if(datg_padres[14] == ''){
                    nm = 0;
                }
                if(datg_padres[15] == ''){
                    nr = 0;
                }
                $('#padre_nivel').select2('val',np );
                $('#madre_nivel').select2('val',nm );
                $('#representante_nivel').select2('val',nr );
                
                if(datg_padres[16] == 1){
                    $('#padre_set').prop('checked',true);
                }
                if(datg_padres[17] == 1){
                    $('#madre_set').prop('checked',true);
                }
                if(datg_padres[18] == 1){
                    $('#padre_see').prop('checked',true);
                }
                if(datg_padres[19] == 1){
                    $('#madre_see').prop('checked',true);
                }
                
                var dtg_if = datos[5].split(',');
                for(var i=0;i<dtg_if.length;i++){
                    $('input:checkbox[name="ingreso[]"][value="'+dtg_if[i]+'"]').prop('checked',true);
                }
                var dtg_ips = datos[6].split(',');
                for(var i=0;i<dtg_ips.length;i++){
                    $('input:checkbox[name="mision[]"][value="'+dtg_ips[i]+'"]').prop('checked',true);
                }
                
               var dtg_v = datos[7].split(';');
               var ub = dtg_v[0];
               var tv = dtg_v[1];
               var ev = dtg_v[2];
               var ca = dtg_v[4];
               if(dtg_v[0] == ''){
                   ub = 0;
               }
               if(dtg_v[1] == ''){
                   tv = 0;
               }
               if(dtg_v[0] == ''){
                   ev = 0;
               }
               if(dtg_v[0] == ''){
                   ca = 0;
               }
               $('#ubicacion_vivienda').select2('val',ub);
               $('#tipo_vivienda').select2('val',tv);
               $('#estado_vivienda').select2('val',ev);
               $('#cant_habitacion').val(dtg_v[3]);
               $('#cama').select2('val',ca);
    
               var dtg_t = datos[8].split(',');
               for(var i=0;i<dtg_t.length;i++){
                   $('input:checkbox[name="tecnologia[]"][value="'+dtg_t[i]+'"]').prop('checked',true);
               }
               
               var dtg_d = datos[9].split(',');
               for(var i=0;i<dtg_d.length;i++){
                   $('input:checkbox[name="diversidad[]"][value="'+dtg_d[i]+'"]').prop('checked',true);
               }
               var dtg_e = datos[10].split(',');
               for(var i=0;i<dtg_e.length;i++){
                   $('input:checkbox[name="enfermedad[]"][value="'+dtg_e[i]+'"]').prop('checked',true);
               }
               
               var dtg_s = datos[10].split(',');
               for(var i=0;i<dtg_s.length;i++){
                   $('input:checkbox[name="servicio[]"][value="'+dtg_s[i]+'"]').prop('checked',true);
               }
               
               var dtg_dz = datos[11].split(',');
               for(var i=0;i<dtg_dz.length;i++){
                   $('input:checkbox[name="destreza[]"][value="'+dtg_dz[i]+'"]').prop('checked',true);
               }
               
               var dtg_a = datos[13].split(',');
               var aa = dtg_a[0];
               var ar = dtg_a[1];
               if(dtg_a[0] == ''){
                   aa = 0;
               }
               if(dtg_a[1] == ''){
                   ar = 0;
               }
              $('#alimentacion').select2('val',aa);
               $('#alimentacion_regular').select2('val',ar);

               var dtg_ay = datos[14].split(',');
               for(var i=0;i<dtg_ay.length;i++){
                   $('input:checkbox[name="ayuda[]"][value="'+dtg_ay[i]+'"]').prop('checked',true);
               }
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
    
    $('#cdt_generales.link').on('click',function() {
        $(this).addClass('activo');
        $('#rest_generales').fadeIn(1000);
        $('#datos_repre').slideUp(1500);
        $('#main').slideDown(1500);
    });
    var url ="../../controlador/Inscripcion.php";
   
    $("#SignupForm").formToWizard({
        next: 'Guardar y Seguir',
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
        
        var id_repre  = $(this).attr('id');
        var res       = id_repre.split("_");
        var repre     = res[0];
        var sufijo    = res[1];
        var repre_alf = repre + '_alf';
        var repre_anl = repre + '_anl';
        var repre_nivel = repre + '_nivel';
        var repre_see = repre + '_see';
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


