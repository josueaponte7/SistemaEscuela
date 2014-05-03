$(document).ready(function() {
    var TDatos = $('#tabla_datosge').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "10%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });
    
    $("#SignupForm").formToWizard({submitButton: 'SaveAccount'});

    $('#datos').select2();
    $('#cod_telefono').select2();
    $('#padre_nivel').select2();
    $('#madre_nivel').select2();
    $('#representante_nivel').select2();
    $('#ubiccaion_vivienda').select2();
    $('#tipo_vivienda').select2();
    $('#estado_vivienda').select2();
    $('#cama').select2();
    $('#alimentacion').select2();
    $('#alimentacion_regular').select2();
    
    $('#Tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('#guardar').click(function() {
        $.post("../../controlador/DatosGenerales.php", $("#frmdatosgenerales").serialize(), function(respuesta) {
            if (respuesta == 1) {
                alert('Registro con Exito');
                $('input[type="text"]').val('');
            }
        });
    });
    
    $('input:checkbox[name="represent_f"]').change(function (){
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
    
    $('input:checkbox[name="repre_alf"]').change(function (){
        var id_repre = $(this).attr('id');
        var res = id_repre.split("_");
        var repre =  res[0];
         var repre_alf = repre+'_alf';
        var repre_anl = repre+'_anl';
        if($(this).is(':checked')){
            $('input:checkbox[id="'+repre_anl+'"]').not('#'+repre_alf).prop('disabled',true).prop('checked',false);
        }else{
            $('input:checkbox[id^="'+repre_anl+'"]').not('#'+repre_alf).prop('disabled',false);
        }
    });
    
    $('input:checkbox[name="repre_anl"]').change(function (){
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
    });
    
    $('#registrar').click(function() {
        $('#registro_datosge').slideDown(2000);
        $('#reporte_datosge').slideUp(2000);
    });

    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_datosge').slideUp(2000);
        $('#reporte_datosge').slideDown(2000);
        $('input:text').val('');
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('#guardar').text('Guardar');
    });
    
});
