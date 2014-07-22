/* Created by jankoatwarpspeed.com */

(function($) {
    $.fn.formToWizard = function(options) {
        options = $.extend({
            submitButton: "",
            url: "",
            next: 'Next',
            finalize: 'Finalize',
            prev: 'Prev',
            message: '',
            valor: ''
        }, options);

        var element = this;

        var steps = $(element).find("fieldset.paso");
        var count = steps.size();
        var submmitButtonName = "#" + options.submitButton;
        $(submmitButtonName).hide();
        // 2
        $(element).before("<ul id='steps'></ul>");

        steps.each(function(i) {
            //$(this).wrap("<div id='step" + i + "'></div>");
            $(this).append("<p id='step" + i + "commands'></p>");
            $(this).wrap("<form id='step" + i + "' name='step" + i + "'></form>");
            // 2
            var name = $(this).find("legend").html();
            $("#steps").append("<li id='stepDesc" + i + "' ><span>" + name + "</span></li>");

            if (i == 0) {
                createNextButton(i);
                selectStep(i);
            }
            else {
                $("#step" + i).hide();
                createPrevButton(i);
                createNextButton(i);
            }
        });

        function createPrevButton(i) {
            var stepName = "step" + i;

            $("#" + stepName + '#cedula').remove();
            $("#" + stepName + '#accion').remove();

            $("#" + stepName + "commands").append("<button style='float:left;' type='button' id='" + stepName + "Prev' class='prev btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>" + options.prev + "</button>");
            $("#" + stepName + "Prev").on("click", function(e) {
                $("#" + stepName).hide();
                $("#step" + (i - 1)).show();
                $(submmitButtonName).hide();
                selectStep(i - 1);
            });
        }

        function createNextButton(i) {


            var stepName = "step" + i;

            var texto = options.next;
            var glyphicon = 'glyphicon-chevron-right';
            if (i == count - 1) {
                texto = options.finalize;
                glyphicon = 'glyphicon-ok';
                $("#" + stepName + "commands").append("<button  type='button' style='margin-left:30%;' id='p_limpiar' class='btn btn-default btn-sm'>Limpiar</button>");
                $("#" + stepName + "commands").append("<button  type='button' style='margin-left:2%;'  id='p_salir' class='btn btn-default btn-sm'>Salir</button>");
            }

            $("#" + stepName + "commands").append("<button style='float:right;' type='button' id='" + stepName + "Next' class='next btn btn-primary btn-sm'> " + texto + " <span class='glyphicon " + glyphicon + "'></span></button>");
            $("#" + stepName + "Next").on("click", function(e) {

                $("input:hidden#hcedula,input:hidden#haccion,input:hidden#hdt").remove();
                var dat_ced = $('#cedula').find('option:selected').val();

                var datos_cedula = dat_ced.split('-');

                var $accion = '<input type="hidden" name="accion" id="haccion" value="GuardarDT"/>';
                var $cedula = '<input type="hidden" name="cedula" id="hcedula" value="' + datos_cedula[1] + '"/>';
                var $dt = '<input type="hidden" name="dt" id="hdt" value="dt' + i + '"/>';
                $("#" + stepName).append($accion, $cedula, $dt);
                var marcados = $('#' + stepName + ' input:checkbox:checked').length;
                var selecionados = $('#' + stepName + ' select').find('option:gt(0)').filter(':selected').length;

                if (marcados == 0 && selecionados == 0) {
                    window.parent.bootbox.confirm({
                        message: '¿No ha marcado ni seleccionado opciones desea continuar?',
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
                                $("#" + stepName).hide();
                                $("#step" + (i + 1)).show();
                                selectStep(i + 1);
                                if (i == count - 1) {
                                    $("#step" + (count - 1)).hide();
                                    $("#step0").show();
                                    $(submmitButtonName).hide();
                                    selectStep(0);
                                }
                            }
                        }
                    });
                } else {
                    var fin = count - 1;
                    if (i == fin) {

                    }
                    var msg
                    var $actividad = $('#actividad').find('option').filter(':selected').val();
                    var $actividad = $('#actividad').find('option').filter(':selected').val();
                    var $medio     = $('#medio').find('option').filter(':selected').val();
                    if ($actividad == 0) {
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
                         $('#h_id_actividad').remove();
                         $('#h_id_anio').remove();
                         var id_anio = $('#id_anio').val();
                         var area = $('#area').val();

                         var $id_actividad = '<input type="hidden" name="h_id_actividad" id="h_id_actividad" value="' + $actividad + '"/>';
                         var $id_anio      = '<input type="hidden" name="h_id_anio" id="h_id_anio" value="' + id_anio + '"/>';
                         var $area         = '<input type="hidden" name="h_area" id="h_area" value="' + area + '"/>';
                        $("#" + stepName).append($id_anio, $id_actividad, $area);
                        
                        window.parent.bootbox.confirm({
                            message: '¿Desea guardar la información?',
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
                                    
                                    $.post(options.url, $("#" + stepName).serialize(), function(respuesta) {
                                        $("#" + stepName + 'input:hidden#cedula').remove();
                                        $("#" + stepName + '#accion').remove();
                                        if (respuesta == 1) {
                                            window.parent.bootbox.alert("Datos guardados con Exito", function() {
                                                $("#" + stepName).hide();
                                                $("#step" + (i + 1)).show();
                                                selectStep(i + 1);
                                                if (i == count - 1) {
                                                    $("#step" + (count - 1)).hide();
                                                    $("#step0").show();
                                                    $(submmitButtonName).hide();
                                                    selectStep(0);
                                                }
                                            });
                                        } else {
                                            window.parent.bootbox.alert("<span style='color:#FF0000'>Ocurrio un error comuniquese co Informática</span>", function() {

                                            });
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        }
        function selectStep(i) {
            $("#steps li").removeClass("current");
            $("#stepDesc" + i).addClass("current");
        }

    };
})(jQuery); 