<?php 
$archivo_actual = basename($_SERVER['PHP_SELF']);
?>
<html>
    <head>
        <title>Inicio de Sesi&oacute;n</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" href="librerias/css/bootstrap.css">
        <link rel="stylesheet" href="librerias/css/bootstrap-theme.css">
        <link rel="stylesheet" href="librerias/css/jquery.toastmessage.css">
        <script type="text/javascript" src="librerias/js/jquery.1.10.2.js"></script>
        <script type="text/javascript" src="librerias/js/bootstrap.js"></script>
        <script type="text/javascript" src="librerias/js/jquery.toastmessage.js"></script>
        <style type="text/css">
            /* Override some defaults */
            html, body {
                background-color: #eee;
            }
            body {
                padding-top: 100px; 
            }
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
            }
            .login-form {
                margin-left: 65px;
            }
        </style>
        <script>
            $(document).ready(function() {
                $('input:text,input:password').on({
                    keypress: function() {
                        $(this).parent('div').removeClass('has-error');
                    }
                });
                $('#ingresar').click(function() {
                    if ($('#usuario').val() == '') {
                        $().toastmessage('showToast', {
                            text: 'El Campo usuario es requerido',
                            sticky: false,
                            stayTime: 2000,
                            type: 'error'
                        });

                        $('#usuario').focus();
                        $('#div_usuario').addClass('has-error');
                    } else if ($('#clave').val() == '') {
                        $().toastmessage('showToast', {
                            text: 'El Campo clave es requerido',
                            sticky: false,
                            stayTime: 2000,
                            type: 'error'
                        });
                        $('#clave').focus();
                        $('#div_clave').addClass('has-error');
                    }else{
                        $.post('validar_usuario.php',$('#frm_usuario').serialize(),function(response){
                            if(response == 1){
                                location.replace('valida_sesion.php');
                                //window.location= 'valida_sesion.php'
                            }
                        });
                    }
                });

            });
        </script>
    </head>
    <body>
        <br/>
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="login-form">
                        <h2>Inicio de Sesi&oacute;n</h2>
                        <form class="form-horizontal" id="frm_usuario" role="form" autocomplete="off">
                            <div class="form-group ">
                                <div id="div_usuario" class='input-group col-sm-12'>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>
                                    <input type="text" class="form-control input-sm" style="width: 230px;"  name="usuario" id="usuario" placeholder="Usuario">
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="div_clave" class="input-group col-sm-12">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock"></span>
                                    </span>
                                    <input style="width: 230px;" type="password" class="form-control input-sm" id="clave" name="clave" placeholder="Clave"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-62 col-sm-12">
                                    <input type="button" class="btn btn-primary btn-sm" id="ingresar" value="Ingresar"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
</body>
</html>
