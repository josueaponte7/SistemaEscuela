<?php
session_start();
$nombres = '';
if (!isset($_SESSION['id_usuario'])) {
    header('location:../');
} else {
    $nombres = $_SESSION['nombres'];
}
$menu_activo = '';
$height      = '700px';
$heightifm   = '800px';
$pagina      = 'titulo_pagina';
$abrir       = 'registros';
$abrir_reg   = 'in';
$abrir_pro   = '';
$abrir_rep   = '';
$abrir_conf  = '';

$nosotros = 'NOSOTROS';
$usuario  = 0;
if ($usuario == 1) {
    $nosotros = 'REGISTROS';
}
if (isset($_SESSION['menu'])) {
    $menu_activo = $_SESSION['menu'];
}

if (isset($_SESSION['archivo_sys']) && isset($_SESSION['dir_sys'])) {
    $dir       = $_SESSION['dir_sys'];
    $archivo   = $_SESSION['archivo_sys'];
    $pagina    = 'vista/' . $dir . '/' . $archivo;
    $height    = $_SESSION['height'];
    $heightifm = $_SESSION['heightifm'];
    $abrir     = $_SESSION['abrir'];
    if ($abrir == 'registros') {
        $abrir_reg  = 'in';
        $abrir_pro  = '';
        $abrir_rep  = '';
        $abrir_conf = '';
    } else if ($abrir == 'procesos') {
        $abrir_reg  = '';
        $abrir_pro  = 'in';
        $abrir_rep  = '';
        $abrir_conf = '';
    } else if ($abrir == 'reportes') {
        $abrir_reg  = '';
        $abrir_pro  = '';
        $abrir_rep  = 'in';
        $abrir_conf = '';
    } else if ($abrir == 'configuracion') {
        $abrir_reg  = '';
        $abrir_pro  = '';
        $abrir_rep  = '';
        $abrir_conf = 'in';
    }
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Escuela</title> 
        <link rel="shortcut icon" href="imagenes/favicon.ico"/>
        <link href="librerias/css/bootstrap.css" rel="stylesheet" media="screen"/>
        <link href="librerias/css/estilos.css" type="text/css" rel="stylesheet" media="screen" />
        <link href="librerias/css/jquery.fancybox.css"  rel="stylesheet" type="text/css" media="all" >
        <script src="librerias/js/jquery.1.10.js"></script>
        <script type="text/javascript" src="librerias/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="librerias/js/bootbox.min.js"></script>
        <script type="text/javascript" src="librerias/js/jquery.fancybox.js"></script>
        <script type="text/javascript" src="librerias/js/collapse.js"></script>
        <script type="text/javascript" src="librerias/js/transition.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var menu_activo = "<?php echo $menu_activo; ?>";
                //$('#cargar').load();
                var pagina = "<?php echo $pagina ?>";

                var height = "<?php echo $height; ?>";
                var heightifm = "<?php echo $heightifm; ?>";

                $('#ifrmcuerpo').attr('src', pagina + '.php').css('height', heightifm);
                $('#cuerpo').css({'height': height});

                $('div.contenido_men_izq ul > li').click(function() {
                    var $id = $(this).attr('id');
                    var ruta = $id.split("_");
                    var total = ruta.length;
                    var dir = ruta[0];
                    var archivo = ruta[1];
                    if (total == 3) {
                        var archivo = ruta[1] + '_' + ruta[2];
                    }

//                    $(this).animate({
//                        width: "150"
//                    });

                    var url = './vista/' + dir + '/' + archivo + '.php';
                    if (archivo == 'estudiante') {
                        var height = '1220px';
                        var heightifm = '1120px';
                    } else if (archivo == 'representante') {
                        var height = '1200px';
                        var heightifm = '1100px';
                    } else if (archivo == 'docente') {
                        var height = '1100px';
                        var heightifm = '995px';

                    } else if (archivo == 'choferes') {
                        var height = '770px';
                        var heightifm = '720px';

                    } else if (archivo == 'servicio_salud') {
                        var height = '770px';
                        var heightifm = '720px';

                    } else if (archivo == 'usuario' || archivo == 'preinscripcion') {
                        var height = '700px';
                        var heightifm = '540px';

                    }
                    else if (archivo == 'programa_social') {
                        var height = '880px';
                        var heightifm = '830px';

                    } else if (archivo == 'status_estudiante' || archivo == 'status_representante' || archivo == 'grupo_usuario'
                            || archivo == 'estado' || archivo == 'municipio' || archivo == 'parroquia'
                            || archivo == 'status_docente' || archivo == 'status_chofer' || archivo == 'tipo_servicio' || archivo == 'actividad'
                            || archivo == 'tipo_enfermedades' || archivo == 'anio_escolar') {
                        var height = '700px';
                        var heightifm = '540px';
                    } else if (archivo == 'inscripcion') {
                        var height = '1460px';
                        var heightifm = '1360px';
                    }

                    $('#ifrmcuerpo').attr('src', url);
                    $('#cuerpo').css('height', height);
                    $('#ifrmcuerpo').css('height', heightifm);
                    //$('#cargar').load(url);

                });

                $('#' + menu_activo).css({'background-color': '#6AD8F3', 'color': '#FFFFFF', 'width': '150px'});
                $('.contenido_men_izq ul > li ').click(function() {
                    var $id = $(this).attr('id');
                    $('.contenido_men_izq ul > li ').css({'background-color': '#FFFFFF', 'color': '#1B57A3'});
                    $('#' + $id).css({'background-color': '#6AD8F3', 'color': '#FFFFFF', 'width': '150px'});
                });

                $('#cerrar').click(function() {

                    window.parent.bootbox.confirm({
                        message: '&iquest;Desea Cerrar la Sesi&oacute;n?',
                        buttons: {
                            'cancel': {
                                label: 'Cancelar',
                                className: 'btn-default'
                            },
                            'confirm': {
                                label: 'Aceptar',
                                className: 'btn-primary'
                            }
                        },
                        callback: function(result) {
                            if (result) {
                                window.location = 'controlador/Usuario.php';
                            }
                        }
                    });
                });

//                /*Para los link del menu de arriba*/
//                $('div#menu_boton ul > li > span').click(function() {
//                    
//                    var $archivo = $(this).attr('id');
//                    var pagina = 'web/'+$archivo+'.php';
//                    //$('#ifrmcuerpo').attr('src', pagina);
//                    $('#cuerpo').load(pagina);
//                });


            });
        </script> 

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
                width: 103%;
                height: 100%;
                overflow: hidden;
                border: none;
                background-color:transparent;
                display:block;
                margin: auto;                
            }
            .menu_izquierdo{
                cursor: pointer;
            }
            .contenido_men_izq ul li{
                width: 80%;
                cursor: pointer
            }
        </style>

    </head>
    <body id="img">
        <div id="contenedor">
            <img style="float: left;margin-left: 80px;margin-top: 15px;" alt="" src="imagenes/logo.png"/>
            <span id="cerrar">Cerrar Sesi&oacute;n</span>
            <span style="float: right;margin-right: 1%;font-weight: bold">Bienvenido(a), <?php echo ucwords($nombres); ?></span>
            <div id="menu">
                <img src="imagenes/bg_menu_b.png" style="width: 910px;"/>
                <img src="imagenes/bg_menu_t.png" style="margin-top: -33px; z-index: 0; height: 50px; width: 882px;"/>
                <div id="menu_boton">
                    <ul>
                        <li>
                            <span data-toggle="collapse" data-parent="#accordion" href="#registros">REGISTROS</span>
                        </li>
                        <li>
                            <span data-toggle="collapse" data-parent="#accordion" href="#procesos">PROCESOS</span>
                        </li>
                        <!--                        <li>
                                                    <span id="">REPORTES</span>
                                                </li>-->
                        <li>
                            <span data-toggle="collapse" data-parent="#accordion" href="#reportes">REPORTES</span>
                        </li>
                        <li>
                            <span data-toggle="collapse" data-parent="#accordion" href="#configuracion">CONFIGURACI&Oacute;N</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="cuerpo">
                <div id="sidebar-izquierdo">
                    <div class="menu_izquierdo panel-title" data-toggle="collapse" data-parent="#accordion" href="#registros" style="margin-top: 40px;">Registros</div>
                    <div id="registros" class="panel-collapse collapse <?php echo $abrir_reg ?>">
                        <div class="panel-body">
                            <div class="contenido_men_izq">
                                <ul  style="list-style-type:none;">
                                    <li id="registros_representante">Representantes</li>
                                    <li id="registros_estudiante" >Estudiantes</li>                                   
                                    <li id="registros_docente">Docentes</li>
                                    <li id="registros_choferes">Choferes</li>
                                    <li id="registros_servicio_salud">Servicios de Salud</li>
                                    <!--                                    <li id="registros_datos_generales" >Datos Generales</li>-->
                                </ul>
                            </div>
                        </div>
                    </div>  
                    <div class="menu_izquierdo panel-title" data-toggle="collapse" data-parent="#accordion" href="#procesos" style="margin-top: 8px;">Procesos</div>
                    <div id="procesos" class="panel-collapse collapse <?php echo $abrir_pro ?>">
                        <div class="panel-body">
                            <div class="contenido_men_izq">
                                <ul  style="list-style-type:none;">
                                    <li id="procesos_preinscripcion">Pre-Inscripci&oacute;n</li>
                                    <li id="procesos_inscripcion">Inscripci&oacute;n</li>                                   
                                </ul>
                            </div> 
                        </div>
                    </div>
                    <div class="menu_izquierdo panel-title" data-toggle="collapse" data-parent="#accordion" href="#reportes" style="margin-top: 8px;">Reportes</div>
                    <div id="reportes" class="panel-collapse collapse <?php echo $abrir_rep ?>">
                        <div class="panel-body">
                            <div class="contenido_men_izq">
                                <ul  style="list-style-type:none;">
                                    <li id="">Estudiante</li>                                                
                                    <li id="">Docente</li>
                                    <li id="">Actividad</li>
                                    <li id="">Estado</li>
                                    <li id="">Municipio</li>  
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="menu_izquierdo panel-title" data-toggle="collapse" data-parent="#accordion" href="#configuracion" style="margin-top: 8px;">Configuraci&oacute;n</div>
                    <div id="configuracion" class="panel-collapse collapse <?php echo $abrir_conf ?>">
                        <div class="panel-body">
                            <div class="contenido_men_izq">
                                <ul  style="list-style-type:none;">
                                    <li id="configuracion_usuario">Usuarios</li>
                                    <li id="configuracion_status_representante">Status de Representantes</li>
                                    <li id="configuracion_status_estudiante">Status de Estudiantes</li>                                    
                                    <li id="configuracion_status_docente">Status de Docentes</li>
                                    <li id="configuracion_status_chofer">Status de Choferes</li>
                                    <li id="configuracion_grupo_usuario">Grupos de Usuarios</li>     
                                    <li id="configuracion_programa_social">Programas Sociales</li>                                     
                                    <li id="configuracion_actividad">Actividades</li>
                                    <li id="configuracion_anio_escolar">A&ntilde;o Escolar</li>
                                    <li id="configuracion_tipo_enfermedades">Tipo de Enfermedades</li>
                                    <li id="configuracion_tipo_servicio">Tipos de Servicio P&uacute;blico</li>
                                    <li id="configuracion_estado">Estados</li>
                                    <li id="configuracion_municipio">Municipios</li>
                                    <li id="configuracion_parroquia">Parroquias</li>                                         
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sidebar-derecho" style="padding: 35px 25px 0 0">                                    
                    <iframe  align="middle" id="ifrmcuerpo" name="ifrmcuerpo"  frameborder="0" scrolling="no"></iframe>
                </div>
            </div>
            <div id="pie">
                <img src="imagenes/bg_footer.jpg" style="height: 100px; width: 1027px; float: left;"/>
                <div id="borde_negro">
                    <!--                    <div id="contenido1">
                                            <a href="#">
                                                <img src="imagenes/logo_f.png"/>
                                            </a>
                                            <div id="menu_contenido1">
                                                <ul style="list-style-type:none;">
                                                    <li>
                                                        <a href="#">nosotros</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">noticias</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">galerias</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">contactenos</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">iniciar sesi&oacute;n</a>
                                                    </li>                                
                                                </ul>
                                            </div>
                                        </div>-->
                    <!--                    <div id="contenido2">
                                            <h1 style="color: #fff;">cont&aacute;ctenos</h1>
                                            <form role="form" autocomplete="off">
                                                <div class="form-group">
                                                    <input type="text" class="form-control input-sm" id="nombre_contacto" name="nombre_contacto" placeholder="Nombre y Apellido">
                                                </div>
                                                <div class="form-group">
                                                    <input type="email" class="form-control input-sm" id="email_contacto" name="email_contacto" placeholder="Correo Electronico">
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control input-sm" rows="5" id="mensaje_contacto" name="mensaje_contacto" placeholder="Mensaje"></textarea>
                                                </div>
                                                <input type="button" style="background-image: url('imagenes/boton_enviar.png');" value="Enviar"  name="enviar" id="enviar"/>
                                                <span class="requiere">*</span>
                                            </form>
                                        </div>-->
                    <div id="contenido3" >
                        <!--                        <h1 style="color: #fff;">estamos en las redes sociales</h1>
                                                <img style="margin-left: 100px;" alt="" src="imagenes/facebook.png"/>
                                                <img alt="" src="imagenes/twitter.png"/>
                                                <h1 style="color: #fff; width: 350px; height: 5px; float: left; margin-left: -22px;">
                                                    llame a nuestros
                                                    <i style="font-family: Arial,'OpenSans',Tahoma,Geneva,sans-serif; font-size: 11px;">tel&eacute;fonos:</i>
                                                </h1>
                                                <div id="telf">
                                                    <span style="margin-left: 76px;"> (0243) 235.56.72</span>
                                                </div>-->
                        <div class="derechos">
                            Copyright &COPY; 2014 Escuela T&eacute;cnica Robinsoniana y Zamorana para la Diversidad Funcional San Carlos
                            <br>
                            Desarrollado por
                            <a href="#">Grupo 6</a>
                        </div>
                    </div>
                </div>  
            </div>
            <!--            <div id="separacion_pie"></div>-->
        </div>        
    </body>
</html>        