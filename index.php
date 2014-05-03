<?php
$archivo_actual = basename($_SERVER['PHP_SELF']);
session_start();

$menu_activo = '';
$height      = '550px';
$heightifm   = '540px';
$pagina      = 'inicio';


$nosotros = 'NOSOTROS';
$usuario  = 0;
if ($usuario == 1) {
    $nosotros = 'REGISTROS';
}
if (isset($_SESSION['menu'])) {
    $menu_activo = $_SESSION['menu'];
}

if (isset($_SESSION['archivo_web']) && isset($_SESSION['dir'])) {
    $dir       = $_SESSION['dir'];
    $archivo   = $_SESSION['archivo_web'];
    $pagina    = 'web/' . $archivo;
    $height    = $_SESSION['height'];
    $heightifm = $_SESSION['heightifm'];
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Escuela</title>
        <link href="librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="librerias/css/bootstrap-theme.css" rel="stylesheet" media="screen"/>
        <link href="librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="librerias/css/jquery.toastmessage.css" rel="stylesheet" media="screen"/>
        <link href="librerias/css/estilos.css" type="text/css" rel="stylesheet" media="screen" />
        <link href="librerias/css/jquery.fancybox.css"  rel="stylesheet" type="text/css" media="all" >
<!--        <script src="librerias/js/jquery.1.10.js"></script>-->
        <script src="librerias/js/jquery.1.10.2.js"></script>
        <script src="librerias/js/bootstrap.js"></script>
        <script src="librerias/js/jquery.toastmessage.js"></script>
        <script type="text/javascript" src="system/librerias/js/validarcampos.js"></script>
        <script type="text/javascript" src="librerias/js/jquery.fancybox.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#usuario').focus();
                var menu_activo = "<?php echo $menu_activo; ?>";
                //$('#cargar').load();
                var pagina = "<?php echo $pagina ?>";

                var height = "<?php echo $height; ?>";
                var heightifm = "<?php echo $heightifm; ?>";
                pagina = 'web/' + pagina + '.php';
                $('#cuerpo').load(pagina);
                //$('#ifrmcuerpo').attr('src', pagina + '.php').css('height', heightifm);
                $('#cuerpo').css({'height': height});

                $('div#menu_boton ul > li > span').click(function() {

                    var $archivo = $(this).attr('id');
                    var pagina = 'web/' + $archivo + '.php';
                    //$('#ifrmcuerpo').attr('src', pagina);
                    $('#cuerpo').load(pagina);
                });
                $('#login p').click(function() {
                    $('#login_form').slideToggle(300);
                    $('#usuario').focus();
                });

                $('#cancelar').click(function() {
//                    $('#login_form').slideToggle(300);
                    $('#usuario').val('');
                    $('#contrasena').val('');
                    $('div').removeClass('has-error');
                });

                $('#entrar').click(function() {
                    if ($('#usuario').val() === null || $('#usuario').val().length === 0 || /^\s+$/.test($('#usuario').val())) {
                        $().toastmessage('showToast', {
                            text: 'El Campo usuario es requerido',
                            sticky: false,
                            stayTime: 2000,
                            type: 'error'
                        });
                        $('#div_usuario').addClass('has-error');
                        $('#usuario').focus();
                    } else if ($('#contrasena').val() === null || $('#contrasena').val().length === 0 || /^\s+$/.test($('#contrasena').val())) {
                        $().toastmessage('showToast', {
                            text: 'El Campo Contrase&ntilde;a es requerido',
                            sticky: false,
                            stayTime: 2000,
                            type: 'error'
                        });
                        $('#div_contrasena').addClass('has-error');
                        $('#contrasena').focus();
                    } else {
                        $.post("system/controlador/Usuario.php", $("#frmusuario").serialize(), function(respuesta) {
                            if (respuesta == 1) {
                                window.location = 'system/';
                                //window.location = 'system/';
                            } else {
                                $().toastmessage('showToast', {
                                    text: 'Usuario o Contrae&ntilde;a Incorrectos',
                                    sticky: false,
                                    stayTime: 2000,
                                    type: 'error'
                                });
                            }
                        });
                    }
                });

                $(document).on('keypress', function(e) {
                    if (e.keyCode == 13) {
                        $('#entrar').trigger('click');
                    }
                });
                $(document).on({
                    contextmenu: function() {
                        return false;
                    },
                    copy: function() {
                        return false;
                    },
                    paste:function (){
                        return false;
                    },
                    cut:function (){
                        return false;
                    }
                });
            });
        </script> 

        <style type="text/css">
            .container {
                width: 350px;
            }

            /* The white background content wrapper */
            .container > .content {
                background-color: #fff;
                padding: 20px;
                margin: 0 -20px; 
                -webkit-border-radius: 10px 10px 10px 10px;
                -moz-border-radius: 10px 10px 10px 10px;
                border-radius: 10px 10px 10px 10px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
                margin-top: 220px;
            }
            .login {
                margin-left: 65px;

            }
        </style>

        <style type="text/css">            
            .tab_sidebar-derecho {
                /*                border: 1px solid #999999;*/
                border-top: none;
                clear: both;
                float: left; 
                width: 760px;
                height: auto;
                background: transparent;
                position: absolute;
                margin-top: 10px;
            }
            iframe {
                width: 100%;
                height: 100%;
                overflow: hidden;
                border: none;
                background-color:transparent;
                display:block;
                margin: auto;
                /*;width: 100%;height: 100%;min-height: 550px;max-height: 900px;*/
            }
        </style>
    </head>
    <body id="img" onselectstart="return false;" ondragstart="return false;">
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="login login-form">
                        <h2>Iniciar Sesi&oacute;n</h2>
                        <form class="form-horizontal" id="frmusuario" role="form" autocomplete="off">
                            <div class="form-group ">
                                <div id="div_usuario" class='input-group col-sm-12'>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                    <input type="text" class="form-control input-sm letras" style="width: 230px;"  name="usuario" id="usuario" placeholder="Usuario">
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="div_contrasena" class="input-group col-sm-12">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock"></span>
                                    </span>
                                    <input style="width: 230px;" type="password" class="form-control input-sm letras" id="contrasena" name="contrasena" placeholder="Contrase&ntilde;a"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-62">
                                    <input type="hidden" name="accion" value="iniciar" id="accion" />
                                    <input type="button" id="entrar" class="btn btn-primary" style="margin-left: 50px; margin-top: 12px; float: left;" value="Entrar" />
                                    <input type="button" id="cancelar" class="btn btn-primary" style="margin-left: 10px; margin-top: 12px; float: left;" value="Cancelar" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>       
    </body>
</html>        