/* Created by jankoatwarpspeed.com */

(function($) {
    $.fn.formToWizard = function(options) {
        options = $.extend({  
            submitButton: "",
            url  :"",
            next:'Next',
            finalize:'Finalize',
            prev:'Prev',
            message :'',
            valor:''
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
            
            $("#"+stepName+'#cedula').remove();
            $("#"+stepName+'#accion').remove();
            
            $("#" + stepName + "commands").append("<button style='float:left;' type='button' id='" + stepName + "Prev' class='prev btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>"+options.prev+"</button>");
            $("#" + stepName + "Prev").on("click", function(e) {
                $("#" + stepName).hide();
                $("#step" + (i - 1)).show();
                $(submmitButtonName).hide();
                selectStep(i - 1);
            });
        }

        function createNextButton(i) {
            
            
            var stepName  = "step" + i;
 
            var texto     = options.next;
            var glyphicon = 'glyphicon-chevron-right';
            if(i ==  count - 1){
                texto = options.finalize;
                glyphicon = 'glyphicon-ok';
            }
            
            $("#" + stepName + "commands").append("<button style='float:right;' type='button' id='" + stepName + "Next' class='next btn btn-primary btn-sm'> "+texto+" <span class='glyphicon "+glyphicon+"'></span></button>");
            $("#" + stepName + "Next").on("click", function(e) {
                
                $("input:hidden#hcedula,input:hidden#haccion,input:hidden#hdt").remove();
                var dat_ced = $('#cedula').find('option:selected').val();
                
                var datos_cedula = dat_ced.split('-');
                
                var $accion = '<input type="hidden" name="accion" id="haccion" value="GuardarDT"/>';
                var $cedula = '<input type="hidden" name="cedula" id="hcedula" value="'+datos_cedula[1]+'"/>';
                var $dt     = '<input type="hidden" name="dt" id="hdt" value="dt'+i+'"/>';
                $("#"+stepName).append($accion,$cedula,$dt);
                $.post(options.url, $("#"+stepName).serialize(), function(respuesta) {
                    $("#"+stepName+'input:hidden#cedula').remove();
                    $("#"+stepName+'#accion').remove();
                   if (respuesta == 1) {
                        alert(options.message);
                        $('input[type="text"]').val('');
                    }
                });
                $("#" + stepName).hide();
                $("#step" + (i + 1)).show();  
                selectStep(i + 1);
                if (i == count - 1) {
                    //$("#step" + (count - 1)).hide();
                    //$("#step0").show();
                    //$(submmitButtonName).hide();
                    //selectStep(0);
                }
                
            });
        }
        function selectStep(i) {
            $("#steps li").removeClass("current");
            $("#stepDesc" + i).addClass("current");
        }

    }
})(jQuery); 