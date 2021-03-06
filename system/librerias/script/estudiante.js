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
            {"sWidth": "20%", "sClass": "center"},
            {"sWidth": "2%", "sClass": "center"}
        ]
    });
    
    
    /*************Izquido*****************/
    $('#imgcedula').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>La C&eacute;dula no puede estar en blanco<br/>'
    });
    
    $('#imgapellido').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>El Apellido no puede estar en blanco<br/>'
    });
    
     $('#imgfechaNac').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>La Fecha Nacimiento no puede estar en blanco<br/>'
    });
    
     $('#imgestado').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>El Estado no puede estar en blanco<br/>'
    });
    
     $('#imgparroquia').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>La Parroquia no puede estar en blanco<br/>'
    });
    
     $('#imgcasa').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>Casa o Apto no puede estar en blanco<br/>'
    });
    
     $('#imgbarrio').tooltip({
        html: true,
        placement: 'right',
        style: 'margin-left:1550px;',
        title: '<br/>Barrio o Urb no puede estar en blanco<br/>'
    });
    
    
    /**************Derecho****************/
    $('#imgnombre').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>El Nombre no debe estar en blanco<br/>'
    });
    
    $('#imgsexo').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>El Sexo no debe estar en blanco<br/>'
    });
    
      $('#imglugarNac').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>El Lugar de Nacimiento no debe estar en blanco<br/>'
    });
    
     $('#imgminicipio').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>El Municipio no debe estar en blanco<br/>'
    });
    
      $('#imgcalle').tooltip({
        html: true,
        placement: 'left',
        title: '<br/>La Calle no debe estar en blanco<br/>'
    });
    
    

    /****************************************/
    $('#nacionalidad,#sexo').select2({
        minimumResultsForSearch: -1
    });

    $('#estado, #municipio, #id_parroquia, #cod_telefono, #cod_celular').select2();
    $('#estatus').select2();
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
        /*var message = "Cedula:'" + cedula + "'\n"
         message += "Click:'" + $(this).attr('id') + "'";*/

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


    $('table#tbl_repre tbody').on("click", 'tr td span.datos', function() {
        //alert($(this).text());
    });

    $('table#tbl_repre tbody').on("change", "tr td input:radio[name='representant']", function() {
        $('table#tbl_repre tbody tr').css('color', '#000000');
        $(this).closest('tr').css('color', '#FF0000');
    });
    
    /**Los monta todos***/
    $('#todos').on('change',function() {
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
    $('table#tabla_estudiante').on('change', 'input:checkbox[name="cedula[]"]', function() {
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
        if (!este.is(':checked')) {
            window.parent.bootbox.confirm({
                message: '¿Desea Eliminar el Representante?',
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
                    } else {
                        este.prop('checked', true);
                    }
                }
            });
        }
    });


     
    $('table#tbl_repre').on('change','input:checkbox[name="representant"]', function() {
        var nodes      = TTbl_Repre.fnGetNodes();
        var $chkbox    = $(this);
        var $actualrow = $chkbox.closest('tr');
        $('input:checkbox[name="representant"]', nodes).not($(this)).prop('checked', false);
        $('table#tbl_repre tbody tr').css('color','#000000');
        $actualrow.css('color','#FF0000');
    });

    $('#guardar').click(function() {

        $('#representantes').remove();
        var checkboxValues = "";
        var selectValues = "";
        var radioValues = "";
        var nombre = "";
        var ced_repre = "";
        $('input:checkbox[name="repre[]"]:checked').each(function() {
            var $chkbox = $(this);
            var $actualrow = $chkbox.closest('tr');
            var $clonedRow = $actualrow.find('td');
            var repre = $clonedRow.eq('4').attr('id');
            var represen = $clonedRow.find("input:checkbox[name='representant']:checked").val();
            if (represen == 1) {
                ced_repre = $actualrow.find('td:eq(1)').text();
                nombre    = $actualrow.find('td:eq(2)').text();
            }
            checkboxValues += $chkbox.val() + ';' + repre + ';' + represen + ",";
        });

//eliminamos la última coma.
        checkboxValues = checkboxValues.substring(0, checkboxValues.length - 1);
        var texto_salida = checkboxValues.replace(/;undefined/g, ";0");
        var $representantes = '<input type="hidden" id="representantes"  value="' + texto_salida + '" name="representantes">';
        $($representantes).appendTo($(this));

        var $cod_telefono = $('#cod_telefono').find('option').filter(':selected').val();
        var $cod_celular = $('#cod_celular').find('option').filter(':selected').val();
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
        } else if (mar_represen == 0) {
            window.parent.bootbox.alert("Debe asignar al menos un representante");
        } else {
            $('#accion').val($(this).text());
            var estatus = $('#estatus').find('option').filter(":selected").text();
            var modificar = '<img class="modificar" src="../../imagenes/edit.png" title="Modificar" style="cursor: pointer"  width="18" height="18" alt="Modificar"/>';
            var eliminar = '<img class="eliminar" src="../../imagenes/delete.png" title="Eliminar" style="cursor: pointer"  width="18" height="18"  alt="Eliminar"/>';
           
           var nombres = $('#nombre').val() + ' ' + $('#apellido').val(); 
           
            if ($(this).text() == 'Guardar') {
                
                $('#estatus').select2("enable", true);
                $.post("../../controlador/Estudiante.php", $("#frmestudiante").serialize(), function(respuesta) {

                    $('#estatus').select2("enable", false);
                    if (respuesta == 1) {
                        
                        var nacionalidad = $('#nacionalidad').find('option').filter(":selected").text();
                        var cedula = nacionalidad + '-' + $('#cedula').val();
                        var $check_cedula = '<input type="checkbox" name="cedula[]" value="' + cedula + '" />';

                        window.parent.bootbox.alert("Registro con Exito", function() {
                            cedula = '<span class="sub-rayar tooltip_ced" data-original-title="" title="">' + cedula + '</span>';
                            
                            var represe = '<span id="'+ced_repre+'" class="sub-rayar representante" data-original-title="" title="">'+nombre+'</span>';
                            
                            
                            TEstudiante.fnAddData([$check_cedula, cedula, nombres, estatus, represe, modificar, eliminar]);

                            $('table#tbl_repre').css('display', 'none');
                            TTbl_Repre.fnClearTable();
                            setTimeout(function(){window.parent.location.reload();},1000);
                            $('input[type="text"]').val('');
                            $('textarea').val('');
                            $('select').not('#estatus').select2('val', 0);
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
                            $('#estatus').select2("enable", true);
                            $.post("../../controlador/Estudiante.php", $("#frmestudiante").serialize(), function(respuesta) {
                                $('#estatus').select2("enable", false);
                                if (respuesta == 1) {

                                    // obtener la fila a modificar
                                    var fila = parseInt($('#fila').val());

                                    window.parent.bootbox.alert("Modificacion con Exito", function() {
                                        setTimeout(function(){
                                            window.location.href=self.location+'?id=0';
                                        });
                                    });

                                }
                            });
                        }
                    }
                });

            }
        }
    });
    $('table#tabla_estudiante').on('click', 'img.modificar', function() {
        // borra el campo fila

        $('#fila').remove();
        var padre = $(this).closest('tr');
        var cedula_c = padre.children('td:eq(1)').text();
        cedula_c = cedula_c.trim();
        //var nac = cedula_c.substring(0, 1);
        //var cedula = cedula_c.substring(2);
        var dat_cedula = cedula_c.split('-');
        var cedula = dat_cedula[1];

        // obtener la fila a modificar
        var rowIndex = TEstudiante.fnGetPosition(padre[0]);

        // crear el campo fila y añadir la fila
        var $fila = '<input type="hidden" id="fila"  value="' + rowIndex + '" name="fila">';
        $($fila).prependTo($('#frmestudiante'));

        $.post("../../controlador/Estudiante.php", {cedula: cedula, accion: 'Buscar'}, function(respuesta) {
//            var nac_v = 0;
//            if (nac = 'V') {
//                nac_v = 1;
//            } else {
//                nac_v = 2;
//            }
            var datos = respuesta.split(';');    
            //$('#nacionalidad').select2('val', nac_v);
            $('#nacionalidad').select2('val', datos[0]);
            $('#cedula').val(cedula);
            $('#nombre').val(datos[1]);
            $('#apellido').val(datos[2]);
            $('#sexo').select2('val', datos[3]);
            $('#fech_naci').val(datos[4]);
            $('#edad').val(datos[5]);

            $('#cod_telefono').select2('val', datos[6]);
            $('#telefono').val(datos[7]);
            $('#cod_celular').select2('val', datos[8]);
            $('#celular').val(datos[9]);

            $('#email').val(datos[10]);
            $('#estatus').select2('val', datos[11]);
            $('#lugar_naci').val(datos[12]);
            $('#estado').select2('val', datos[13]);

            $.post('../../controlador/Municipio.php', {estado: datos[13], accion: 'buscarMun'}, function(respuesta) {
                var option = "";
                $.each(respuesta, function(i, obj) {
                    option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
                });
                $('#municipio').append(option);
                $('#municipio').select2('val', datos[14]);
            }, 'json');

            $.post('../../controlador/Parroquia.php', {id_municipio: datos[14], accion: 'buscarParr'}, function(respuesta) {
                var option = "";
                $.each(respuesta, function(i, obj) {
                    option += "<option value=" + obj.codigo + ">" + obj.descripcion + "</option>";
                });

                $('#id_parroquia').append(option);
                $('#id_parroquia').select2('val', datos[15]);
            }, 'json');

            $('#calle').val(datos[16]);
            $('#casa').val(datos[17]);
            $('#edicifio').val(datos[18]);
            $('#barrio').val(datos[19]);

            $.post("../../controlador/Estudiante.php", {cedula: cedula, accion: 'BuscarRep'}, function(res_rep) {
                $.each(res_rep, function(i, clave) {
                    var checkbox = '<input type="checkbox" name="repre[]" value="' + clave.cedula + '" checked/>';
                    var marcado = '';
                    if (clave.representante > 0) {
                        var marcado = 'checked';
                    }
                    var radio = '<input  type="checkbox" class="representant" name="representant" value="1" ' + marcado + '/>';

                    var newRow = TTbl_Repre.fnAddData([checkbox, clave.cedula, clave.nombres, clave.telefonos, clave.parentesco, radio]);

                    var oSettings = TTbl_Repre.fnSettings();
                    var nTr = oSettings.aoData[ newRow[0] ].nTr;
                    $('td', nTr)[4].setAttribute('id', clave.id_parentesco);

                    if (clave.representante > 0) {
                        nTr.setAttribute('style', 'color:#FF0000');
                    }
                });
                $('table#tbl_repre').css('display', 'block');
            }, 'json');

            $('#guardar').text('Modificar');
            $('#registro_estudiante').slideDown(2000);
            $('#reporte_estudiante').slideUp(2000);
            ///$('#limpiar').trigger('click');

        });

    });

    // modificar las funciones de eliminar
    $('table#tabla_estudiante').on('click', 'img.eliminar', function() {
        $('#cedula').val(cedula);
        var padre = $(this).closest('tr');

        // obtener la fila clickeada
        var nRow = $(this).parents('tr')[0];

        window.parent.bootbox.confirm({
            message: '¿Desea Eliminar el Registro?',
            buttons: {
                'cancel': {
                    label: 'Cancelar',
                    className: 'btn-default'
                },
                'confirm': {
                    label: 'Eliminar',
                    className: 'btn-danger'
                }
            },
            callback: function(result) {
                if (result) {

                    var cedula = padre.children('td:eq(1)').find('span').text();
                    $.post("../../controlador/Estudiante.php", {'accion': 'Eliminar', 'cedula': cedula}, function(respuesta) {
                        if (respuesta == 1) {

                            window.parent.bootbox.alert("Eliminacion con Exito", function() {
                                //borra la fila de la tabla
                                TEstudiante.fnDeleteRow(nRow);

                                $('input[type="text"]').val('');
                            });


                        }
                    });
                }
            }
        });

    });

    $('#salir').click(function() {
        $('#guardar').text('Guardar');
        $('#registro_estudiante').slideUp(2000);
        $('#reporte_estudiante').slideDown(2000);
        $('select').removeClass('has-error');
        $('#limpiar').trigger('click');
    });

    $('#limpiar').click(function() {
        TTbl_Repre.fnClearTable();
        $('table#tbl_repre').css('display', 'none');
        $('input:text').val('');
        $('textarea').val('');
        $('select').removeClass('has-error');
        $('select').not('#estatus').select2('val', 0);
        $('#guardar').text('Guardar');
    });

});
