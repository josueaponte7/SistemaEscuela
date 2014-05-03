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

    $("#SignupForm").formToWizard({submitButton: 'SaveAccount'});

    $('#cdt_generales').click(function() {
        $(this).addClass('activo');
        $('#rdt_generales').fadeIn(1000);
        $('#datos_repre').slideUp(1500);
        $('#main').slideDown(1500);
    });

    $('#rdt_generales').click(function() {
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


    $('#cedula').select2();
    //$('#tipo_estudainte').select2();
    //$('#anio_escolar').select2();
    $('#actividad').select2();
    $('#cod_telefono').select2();
    $('#medio').select2();
    $('#padre_nivel').select2();
    $('#madre_nivel').select2();
    $('#representante_nivel').select2();
    $('#ubiccaion_vivienda').select2();
    $('#tipo_vivienda').select2();
    $('#estado_vivienda').select2();
    $('#cama').select2();
    $('#alimentacion').select2();
    $('#alimentacion_regular').select2();


     $('#cedula').change(function() {
        var  cedula = $(this).val();
        $.post("../../controlador/Inscripcion.php", {cedula:cedula,'accion':'BuscarDatos'}, function(respuesta) {
            var datos = respuesta.split(';');
            $('#cedula_r').val(datos[1]);
            $('#nombre_r').val(datos[2]);
            $('#apellido_r').val(datos[3]);
            $('#parentesco').val(datos[4]);
            $('#id_tipo').val(datos[5]);
            $('#tipo_estudiate').val(datos[6]);
        });
    });
    
    $('#cedula_cho').blur(function() {
        $.post("../../controlador/Choferes.php",{cedula:$(this).val(),'accion':'BuscarChofer'}, function(respuesta) {
             var datos = respuesta.split(';');
            $('#nombre_cho').val(datos[0]);
            $('#apellido_cho').val(datos[1]);
            $('#placa').val(datos[2]);
            $('#telefono_cho').val(datos[3]);
        });
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
    /****Calendario*****/
    $('#fecha').datepicker({
        language: "es",
        format: 'dd/mm/yyyy',
        startDate: "-60y",
        endDate: "-15y",
        autoclose: true
    });

    $('#registrar').click(function() {
        $('#registro_inscripcion').slideDown(2000);
        $('#reporte_inscripcion').slideUp(2000);
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


});


