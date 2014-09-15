$(document).ready(function (){
    var TMenu = $('#tabla_menu').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20, 30, 40, 50],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "20%"},
            {"sClass": "center", "sWidth": "20%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "4%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });
    
    $('#grupo_usuario').select2();
     $('#menu_comb').select2();
    $('#sub_menu').select2();
    $('#estado').select2();
    $('#estatus').select2(); 
    
    $('#registrar').click(function() {
        $('#registro_perfil').slideDown(2000);
        $('#reporte_perfil').slideUp(2000);
    });
    
    $('#menu_comb').change(function() {
        var id = $(this).val();
        $('#sub_menu').select2('val', 0);
        $('#sub_menu').find('option:gt(0)').remove().end();
        $.post('../../controlador/SubMenu.php', {id_menu: id, accion: 'buscarSubMenu'}, function(respuesta) {
            var option = "";
            $.each(respuesta, function(i, obj) {
                option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
            });
            $('#sub_menu').append(option);
        }, 'json');
    });
    
    
   $('#guardar').click(function (){
        $.post( "../../controlador/Perfil.php", $("#frmperfil").serialize(),function (respuesta){
            if(respuesta == 1){
                alert('Registro con Exito') ;
                $('input[type="text"]').val('');
           }
        } );
    });
    
    
    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_perfil').slideUp(2000);
        $('#reporte_perfil').slideDown(2000);
        $('#id_estado').remove();
        $('input:text').val('');
        $('#estado').select2('val', 0);
    });


    $('#limpiar').click(function() {
        $('#grupo_usuario, #menus').select2('val', 0);
        $('#estatus').select2('val', 2);
        $('.checkbox').val('', 0);
        $('#guardar').text('Guardar');
    });
    
    
});

