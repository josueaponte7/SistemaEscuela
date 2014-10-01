<?php
session_start();
$nombres = '';

if (!isset($_SESSION['id_usuario'])) {
    header('location:../');
} else {
    $nombres    = $_SESSION['nombres'];
    $grupo      = $_SESSION['id_grupo'];
    
}


$menu_activo = '';
$height      = '700px';
$heightifm   = '800px';
$pagina      = 'titulo_pagina';
$abrir       = 'registros';
$abrir_reg   = 'in';
$abrir_pro   = '';
$abrir_rep   = '';
$abrir_mant  = '';
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
    } else if ($abrir == 'mantenimiento') {
        $abrir_reg  = '';
        $abrir_pro  = '';
        $abrir_rep  = '';
        $abrir_mant = 'in';
        $abrir_conf = '';
    } else if ($abrir == 'configuracion') {
        $abrir_reg  = '';
        $abrir_pro  = '';
        $abrir_rep  = '';
        $abrir_conf = 'in';
    }
}
if ($grupo == 2) {
    $abrir_conf = 'in';
} else if ($grupo == 3) {
    $abrir_rep = 'in';
}
$_SESSION['v_registro'] = 'none';
$_SESSION['v_table']    = 'block';
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
                    var clase = $(this).attr('class');      
                    if (total == 3) {
                        var archivo = ruta[1] + '_' + ruta[2];
                    }
                    var url = './vista/' + dir + '/' + archivo + '.php?id=1';
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

                    } else if (archivo == 'usuario' || archivo == 'preinscripcion' || archivo == 'menu' || archivo == 'sub_menu' || archivo == 'perfil') {
                        var height = '700px';
                        var heightifm = '540px';

                    }
                    else if (archivo == 'programa_social' || archivo == 'profesion') {
                        var height = '880px';
                        var heightifm = '830px';

                    } else if (archivo == 'status_estudiante' || archivo == 'status_representante' || archivo == 'grupo_usuario'
                            || archivo == 'estado' || archivo == 'municipio' || archivo == 'parroquia'
                            || archivo == 'status_docente' || archivo == 'status_chofer' || archivo == 'tipo_servicio' || archivo == 'actividad'
                            || archivo == 'tipo_enfermedades' || archivo == 'anio_escolar') {
                        var height = '700px';
                        var heightifm = '540px';
                    } else if (archivo == 'inscripcion') {
                        var height = '1820px';
                        var heightifm = '1720px';
                    }
                    if (clase == 'reporte') {
                        var url = 'vista/reportes/' + $id + '.php?todos=1';
                        window.open(url);
                    } else {
                        $('#ifrmcuerpo').attr('src', url);
                        $('#cuerpo').css('height', height);
                        $('#ifrmcuerpo').css('height', heightifm);
                    }

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
                        <?php
                        if ($grupo == 1) {
                            ?>
                            <li>
                                <span data-toggle="collapse" data-parent="#accordion" href="#registros">REGISTROS</span>
                            </li>
                            <?php
                        }
                        if ($grupo == 1) {
                            ?>
                            <li>
                                <span data-toggle="collapse" data-parent="#accordion" href="#procesos">PROCESOS</span>
                            </li>
                            <?php
                        }
                        if ($grupo == 1 || $grupo == 3) {
                            ?>

                            <li>
                                <span data-toggle="collapse" data-parent="#accordion" href="#reportes">REPORTES</span>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <span data-toggle="collapse" data-parent="#accordion" href="#mantenimiento">MANTENIMIENTO</span>
                        </li>
                        <?php
                        if ($grupo == 2) {
                            ?>
                            <li>
                                <span data-toggle="collapse" data-parent="#accordion" href="#configuracion">CONFIGURACI&Oacute;N</span>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div id="cuerpo">
                <div id="sidebar-izquierdo">
                    <?php
                    if ($grupo == 1) {
                        ?>
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
                                    </ul>
                                </div>
                            </div>
                        </div>  
                        <?php
                    }
                    if ($grupo == 1) {
                        ?>
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
                        <?php
                    }
                    if ($grupo == 1 || $grupo == 3) {
                        ?>

                        <div class="menu_izquierdo panel-title" data-toggle="collapse" data-parent="#accordion" href="#reportes" style="margin-top: 8px;">Reportes</div>
                        <div id="reportes" class="panel-collapse collapse <?php echo $abrir_rep ?>">
                            <div class="panel-body">
                                <div class="contenido_men_izq">
                                    <ul  style="list-style-type:none;">
                                        <li id="reporte_inscripcion" class="reporte">Inscripci&oacute;n</li>
                                        <li id="reporte_preinscripcion" class="reporte">Pre-Inscripci&oacute;n</li> 
                                        <li id="reporte_estudiante" class="reporte">Estudiante</li>                                                
                                        <li id="reporte_docente" class="reporte">Docente</li>
                                        <li id="listado_representante" class="reporte">Representantes</li> 
                                        <li id="reporte_chofer" class="reporte">Choferes</li> 
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="menu_izquierdo panel-title" data-toggle="collapse" data-parent="#accordion" href="#mantenimiento" style="margin-top: 8px;">Mantenimiento</div>
                    <div id="mantenimiento" class="panel-collapse collapse <?php echo $abrir_mant ?>">
                        <div class="panel-body">
                            <div class="contenido_men_izq">
                                <ul  style="list-style-type:none;">
                                    <li id="mantenimiento_status_representante">Status de Representantes</li>
                                    <li id="mantenimiento_status_estudiante">Status de Estudiantes</li>                                    
                                    <li id="mantenimiento_status_docente">Status de Docentes</li>
                                    <li id="mantenimiento_status_chofer">Status de Choferes</li>     
                                    <li id="mantenimiento_programa_social">Programas Sociales</li>
                                    <li id="mantenimiento_profesion">Profesi&oacute;n</li>
                                    <li id="mantenimiento_actividad">Actividades</li>
                                    <li id="mantenimiento_anio_escolar">A&ntilde;o Escolar</li>
                                    <li id="mantenimiento_tipo_enfermedades">Tipo de Enfermedades</li>
                                    <li id="mantenimiento_tipo_servicio">Tipos de Servicio P&uacute;blico</li>
                                    <li id="mantenimiento_estado">Estados</li>
                                    <li id="mantenimiento_municipio">Municipios</li>
                                    <li id="mantenimiento_parroquia">Parroquias</li>  
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($grupo == 2) {
                        ?>
                        <div class="menu_izquierdo panel-title" data-toggle="collapse" data-parent="#accordion" href="#configuracion" style="margin-top: 8px;">Configuraci&oacute;n</div>
                        <div id="configuracion" class="panel-collapse collapse <?php echo $abrir_conf ?>">
                            <div class="panel-body">
                                <div class="contenido_men_izq">
                                    <ul  style="list-style-type:none;">
                                        <li id="configuracion_grupo_usuario">Grupos de Usuarios</li> 
                                        <li id="configuracion_usuario">Usuarios</li>
                                        <li id="configuracion_menu">Men&uacute;</li>
                                        <li id="configuracion_sub_menu">Sub Men&uacute;</li>
                                        <li id="configuracion_perfil">Perfil</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div id="sidebar-derecho" style="padding: 35px 25px 0 0">                                    
                    <iframe  align="middle" id="ifrmcuerpo" name="ifrmcuerpo"  frameborder="0" scrolling="no"></iframe>
                </div>
            </div>
            <div id="pie">
                <img src="imagenes/bg_footer.jpg" style="height: 100px; width: 1027px; float: left;"/>
                <div id="borde_negro"> 
                    <div id="contenido3" >
                        <div class="derechos">
                            Copyright &COPY; 2014 Escuela T&eacute;cnica Robinsoniana y Zamorana para la Diversidad Funcional San Carlos
                            <br>
                            Desarrollado por
                            <a href="#">Grupo 6</a>
                        </div>
                    </div>
                </div>  
            </div>
        </div>        
    </body>
</html>        