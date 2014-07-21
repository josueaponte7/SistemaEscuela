$(document).ready(function() {

    $(document).on("contextmenu", function(e) {
        e.preventDefault();
    });

    var TEstudiante = $('#tabla_estudiante').dataTable({
        "iDisplayLength": 5,
        "iDisplayStart": 0,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [5, 10, 20],
        "oLanguage": {"sUrl": "../../librerias/js/es.txt"},
        "aoColumns": [
            {"sClass": "center", "sWidth": "4%", "bSortable": false, "bSearchable": false},
            {"sClass": "center", "sWidth": "10%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sClass": "center", "sWidth": "5%"},
            {"sClass": "center", "sWidth": "30%"},
            {"sWidth": "2%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "2%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
        ]
    });

    var TTbl_Repre = $('#tbl_repre').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bInfo": false,
        "bFilter": false,
        "bSearchable": false,
        "bSort": false,
        "bStateSave": true,
        "bAutoWidth": false,
        "aoColumns": [
            {"sWidth": "4%", "sClass": "center"},
            {"sWidth": "15%", "sClass": "center"},
            {"sWidth": "45%", "sClass": "center"},
            {"sWidth": "20%", "sClass": "center"},
            {"sWidth": "2%", "sClass": "center"}
        ]
    });

    $('#nacionalidad,#sexo').select2({
        minimumResultsForSearch: -1
    });
    
    //$('.parentesco').select2();
    
    $('#estado, #municipio, #id_parroquia, #cod_telefono, #cod_celular').select2();
    $('#estatus').select2();
    $('#estatus').select2('val', '1');
    $('#estatus').select2('val', '1');
    $('#estatus').select2("enable", false);

    var letra = ' abcdefghijklmnñopqrstuvwxyzáéíóú';
    $('#nombre, #apellido').validar(letra);

    var numero = '0123456789';
    $('#telefono, #celular, #cedula').validar(numero);

    $('.tooltip_ced').tooltip({
        html: true,
        placement: 'bottom',
        title: 'Click para ver opciones'
    });

    $('.representante').tooltip({
        html: true,
        placement: 'bottom',
        title: 'Click  para ver opciones'
    });

    $('.modificar').tooltip({
        html: true,
        placement: 'top',
        title: 'Modificar'
    });
    $('.eliminar').tooltip({
        html: true,
        placement: 'top',
        title: 'Eliminar'
    });

    $('#registrar').click(function() {
        $('#registro_estudiante').slideDown(2000);
        $('#reporte_estudiante').slideUp(2000);
    });

    /***Combos **/
    $('#estado').change(function() {
        var id = $(this).val();
        $('#municipio').select2('val', 0);
        $('#municipio').find('option:gt(0)').remove().end();
        $('#id_parroquia').select2('val', 0);
        $('#id_parroquia').find('option:gt(0)').remove().end();

        $.post('../../controlador/Municipio.php', {estado: id, accion: 'buscarMun'}, function(respuesta) {
            var option = "";
            $.each(respuesta, function(i, obj) {
                option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
            });
            $('#municipio').append(option);
        }, 'json');
    });

    $('#municipio').change(function() {
        var id = $(this).val();
        $('#id_parroquia').select2('val', 0);
        $('#id_parroquia').find('option:gt(0)').remove().end();
        $.post('../../controlador/Parroquia.php', {id_municipio: id, accion: 'buscarParr'}, function(respuesta) {
            var option = "";
            $.each(respuesta, function(i, obj) {
                option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
            });
            $('#id_parroquia').append(option);
        }, 'json');
    });

    /****Calendario*****/
    $('#fech_naci').datepicker({
        language: "es",
        format: 'dd/mm/yyyy',
        startDate: "-18y",
        endDate: "-15y",
        autoclose: true
    }).on('changeDate', function(ev) {
        var edad = calcular_edad($(this).val());
        $('#edad').val(edad);
        $('#div_fech_naci').removeClass('has-error');
    });

    var $contextMenuEst = $("#contextMenuEst");
    var $contextMenuRep = $("#contextMenuRep");

    var $contextMenu = $contextMenuEst;
    var cedula = '';
    var url = '';
    
    $("table#tabla_estudiante").on("click", "span.sub-rayar", function(e) {
        $('.dropdown').hide();
        $contextMenu = $contextMenuEst;

        $('#fil').remove();
        var fil = $(this).closest('tr').index();
        var $fil = '<input type="hidden" id="fil"  value="' + fil + '" name="fil">';
        $($fil).prependTo($(this));

        cedula = $(this).text();
        if ($(this).hasClass("representante")) {
            $contextMenu = $contextMenuRep;
            cedula = $(this).attr('id');
        }
        $contextMenu.css({
            display: "block",
            left: e.pageX,
            top: e.pageY
        });
        return false;
    });

    $contextMenuEst.on("click", "span", function() {

        var accion = $(this).attr('id');
        url = 'vista/registros/ver_datos_alumnos.php';
        var width = '500px';
        if (accion == 'v_repre') {
            url = 'vista/registros/ver_representante.php';
        }
        parent.$.fancybox.open({
            'autoScale': false,
            //'width':width,
            'href': url + '?cedula=' + cedula,
            'type': 'iframe',
            'hideOnContentClick': false,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'openSpeed': 500,
            'closeSpeed': 500,
            'openEffect': 'elastic',
            'closeEffect': 'elastic',
            'helpers': {overlay: {closeClick: false}}
        });
        $('.dropdown').hide();
    });

    $contextMenuRep.on("click", "span", function() {
        var message = "Cedula:'" + cedula + "'\n"
        message += "Click:'" + $(this).attr('id') + "'";

        var accion = $(this).attr('id');
        url = 'vista/registros/ver_datos_representante.php';
        var width = '50%';
        if (accion == 'm_repre') {
            url = 'vista/registros/mod_representante.php';
            width = '58%';
        }
        parent.$.fancybox.open({
            'autoScale': false,
            //'width':width,
            'href': url + '?cedula=' + cedula,
            'type': 'iframe',
            'hideOnContentClick': false,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'openSpeed': 500,
            'closeSpeed': 500,
            'openEffect': 'elastic',
            'closeEffect': 'elastic',
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

    $('#asignar_rep').click(function() {
        parent.$.fancybox.open({
            'autoScale': false,
            'href': 'vista/registros/reporte_representante.php',
            'type': 'iframe',
            'hideOnContentClick': false,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'openSpeed': 500,
            'closeSpeed': 500,
            'openEffect': 'elastic',
            'closeEffect': 'elastic',
            'helpers': {overlay: {closeClick: false}}
        });
    });

    /**Los monta todos***/
    $('#todos').change(function() {
        var TotalRow = TEstudiante.fnGetData().length;
        var nodes = TEstudiante.fnGetNodes();
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
    $('input:checkbox[name="cedula[]"]').change(function() {
        $('#todos').prop('checked', false);
        var nodes = TEstudiante.fnGetNodes();
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
        var url = '../reportes/reporte_estudiante.php';
        if ($('#todos').is(':checked')) {
            url = url + '?todos=1';
        } else if ($('input:checkbox[name="cedula[]"]').is(':checked')) {
            var checkboxValues = "";
            var nodes = TEstudiante.fnGetNodes();
            $("input:checkbox[name='cedula[]']:checked", nodes).each(function() {
                var $chkbox = $(this);
                var $actualrow = $chkbox.closest('tr');
                var cedula = $actualrow.find('td:eq(1)').text();
                cedula = cedula.trim();
                checkboxValues += cedula.substr(2) + ',';
            });
            checkboxValues = checkboxValues.substring(0, checkboxValues.length - 1);
            url = url + '?cedula=' + checkboxValues;
        }
        window.open(url);
    });

    $('table#tbl_repre').on('change', 'input:checkbox[name="repre[]"]', function() {
        var este = $(this);
        var padre = este.closest('tr');
        var chk_counre = $('input:checkbox[name="repre[]"]:checked').length;
        alert(chk_counre);
        if (!este.is(':checked')) {
            window.parent.bootbox.confirm({
                        message: 'Si Desmarca esta opción Eliminara el representante<br/>¿Desea Continuar?',
                        buttons: {
                            'cancel': {
                                label: 'No',
                                className: 'btn-default'
                            },
                            'confirm': {
                                label: 'Si',
                                className: 'btn-danger'
                            }
                        },
                        callback: function(result) {
                            if (result) {
                                padre.remove();
                            }else{
                                este.prop('checked',true);
                            }
                        }
                    });
        }
    });

    /*****$('table#tbl_repre').on('change', 'input:radio[name="representant"]', function() {
        var $chkbox = $(this);
        $('input:checkbox[name="repre[]"]:checked').prop('disabled', false);
        $('input:radio[name="representant"]:checked').prop('checked', false);
        $(this).prop('checked', true);
        if ($(this).is(':checked')) {
            var $actualrow = $chkbox.closest('tr');
            var $clonedRow = $actualrow.children('td');
            $clonedRow.find('input:checkbox[name="repre[]"]:checked').prop('disabled', true);
        }
    });******/

    $('#guardar').click(function() {
        
       $('#representantes').remove();
        var checkboxValues = "";
        var selectValues = "";
        var radioValues = "";
        var nombre = "";
        $('input:checkbox[name="repre[]"]:checked').each(function() {
            var $chkbox = $(this);
            var $actualrow = $chkbox.closest('tr');
            var $clonedRow = $actualrow.find('td');
            var repre = $clonedRow.find("select").find('option:selected').val();
            var represen = $clonedRow.find("input:radio[name='representant']:checked").val();
            if (represen == 1) {
                nombre = $actualrow.find('td:eq(2)').text();
            }
            checkboxValues += $chkbox.val() + ';' + repre + ';' + represen + ",";
        });

//eliminamos la última coma.
        checkboxValues = checkboxValues.substring(0, checkboxValues.length - 1);
        var texto_salida = checkboxValues.replace(/;undefined/g, ";0");
        var $representantes = '<input type="hidden" id="representantes"  value="' + texto_salida + '" name="representantes">';
        $($representantes).appendTo($(this));

        var $cod_telefono = $('#cod_telefono').find('option').filter(':selected').val();
        var $cod_celular  = $('#cod_celular').find('option').filter(':selected').val();
        //window.parent.$("body").animate({scrollTop:0}, 'slow'); 
        var val_correo = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
        var mar_represen = $('input:checkbox[name="repre[]"]:checked').length;

        if ($('#nacionalidad').val() == 0) {
            /*********window parent para que la validacion llegue a su lugar********/
            window.parent.scrollTo(0, 300);
            $('#nacionalidad').addClass('has-error');
            //$('#nacionalidad').focus();
        } else if ($('#cedula').val() === null || $('#cedula').val().length < 6 || /^\s+$/.test($('#cedula').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_cedula').addClass('has-error');
            $('#cedula').focus();
        } else if ($('#nombre').val() === null || $('#nombre').val().length === 0 || /^\s+$/.test($('#nombre').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_nombre').addClass('has-error');
            $('#nombre').focus();
        } else if ($('#apellido').val() === null || $('#apellido').val().length === 0 || /^\s+$/.test($('#apellido').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_apellido').addClass('has-error');
            $('#apellido').focus();
        } else if ($('#sexo').val() == 0) {
            window.parent.scrollTo(0, 300);
            $('#sexo').addClass('has-error');
        } else if ($('#fech_naci').val() === null || $('#fech_naci').val().length === 0 || /^\s+$/.test($('#fech_naci').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_fech_naci').addClass('has-error');
            $('#fech_naci').focus();
        } else if ($cod_telefono > 0 && $('#telefono').val().length < 7) {
            window.parent.scrollTo(0, 300);
            $('#div_telefono').addClass('has-error');
            $('#telefono').focus();
        } else if ($cod_celular > 0 && $('#celular').val().length < 7) {
            window.parent.scrollTo(0, 600);
            $('#div_celular').addClass('has-error');
            $('#celular').focus();
        } else if ($('#email').val().length > 0 && !val_correo.test($('#email').val())) {
            window.parent.scrollTo(0, 300);
            $('#div_email').addClass('has-error');
            $('#email').focus();
        } else if ($('#lugar_naci').val() === null || $('#lugar_naci').val().length === 0 || /^\s+$/.test($('#lugar_naci').val())) {
            window.parent.scrollTo(0, 600);
            $('#div_lugar_naci').addClass('has-error');
            $('#lugar_naci').focus();
        } else if ($('#estado').val() == 0) {
            window.parent.scrollTo(0, 700);
            $('#estado').addClass('has-error');
        } else if ($('#municipio').val() == 0) {
            window.parent.scrollTo(0, 700);
            $('#municipio').addClass('has-error');
        } else if ($('#id_parroquia').val() == 0) {
            window.parent.scrollTo(0, 700);
            $('#id_parroquia').addClass('has-error');
        } else if ($('#calle').val() === null || $('#calle').val().length === 0 || /^\s+$/.test($('#calle').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_calle').addClass('has-error');
            $('#calle').focus();
        } else if ($('#casa').val() === null || $('#casa').val().length === 0 || /^\s+$/.test($('#casa').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_casa').addClass('has-error');
            $('#casa').focus();
        } else if ($('#barrio').val() === null || $('#barrio').val().length === 0 || /^\s+$/.test($('#barrio').val())) {
            window.parent.scrollTo(0, 700);
            $('#div_barrio').addClass('has-error');
            $('#barrio').focus();
        }else if(mar_represen ==0){
            window.parent.bootbox.alert("Debe asignar al menos un representante");
        } else {
            $('#accion').val($(this).text());
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';

            $('#estatus').select2("enable", true);
            $.post("../../controlador/Estudiante.php", $("#frmestudiante").serialize(), function(respuesta) {
                var estatus = $('#estatus').find('option').filter(":selected").text();
                $('#estatus').select2("enable", false);
                if (respuesta == 1) {
                    var nacionalidad = $('#nacionalidad').find('option').filter(":selected").text();
                    var cedula = nacionalidad + '-' + $('#cedula').val();
                    var $check_cedula = '<input type="checkbox" name="cedula[] " value="' + cedula + '" />';
                    window.parent.bootbox.alert("Registro con Exito", function() {
                        cedula = '<span class="sub-rayar tooltip_ced" data-original-title="" title="">' + cedula + '</span>';

                        var nombres = $('#nombre').val() + ' ' + $('#apellido').val();
                        TEstudiante.fnAddData([$check_cedula, cedula, nombres, estatus, nombre, modificar, eliminar]);
                        $('table#tbl_repre').css('display', 'none');
                        TTbl_Repre.fnClearTable();
                        $('input[type="text"]').val('');
                        $('select').select2('val', 0);
                        $('#municipio').find('option:gt(0)').remove().end();
                        $('#id_parroquia').find('option:gt(0)').remove().end();
                    });
                } else if (respuesta == 13) {
                    window.parent.bootbox.alert("La Cédula se encuentra Registrada", function() {
                        window.parent.scrollTo(0, 300);
                        $('#div_cedula').addClass('has-error');
                        $('#cedula').focus().select();
                    });
                } else {
                    window.parent.bootbox.alert("Ocurrio un error comuniquese con informatica");
                }
            });
        }
    });

    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_estudiante').slideUp(2000);
        $('#reporte_estudiante').slideDown(2000);
        $('input:text').val('');
        $('textarea').val('');
        $('#estado,#municipio,#id_parroquia,#estatus,#sexo,#cod_telefono,#cod_celular,#nivel_inst,#profesion').select2('val', 0);
        $('#nacionalidad').select2('val', 0);
    });

    $('#limpiar').click(function() {
        $('input:text').val('');
        $('textarea').val('');
        $('#estado,#municipio,#id_parroquia,#estatus,#sexo,#cod_telefono,#cod_celular,#nivel_inst,#profesion').select2('val', 0);
        $('#nacionalidad').select2('val', 0);
        $('#guardar').text('Guardar');
    });

});
