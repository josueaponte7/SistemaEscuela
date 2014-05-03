<?php
session_start();
date_default_timezone_set('America/Caracas');


//$fecha = date($_SESSION['date_session']);
$fecha_i = date('2013-12-28 16:20');
$fecha_f = date('Y-m-d H:i');

$fecha1 = new DateTime($fecha_i);
$fecha2 = new DateTime($fecha_f);
$fecha  = $fecha1->diff($fecha2);

if($fecha->y == 0 && $fecha->m == 0 && $fecha->d == 0 && $fecha->h == 0 && $fecha->i < 30){
    echo 'entro';
}else{
    echo 'error';
}
echo '<br/>';
var_dump($fecha);
echo '<br/>';
$nombre_archivo = '20131228.txt';
if (file_exists($nombre_archivo)) {
    echo "Creacion del archivo <span style='color:#FF0000'>$nombre_archivo</span> fue:".date("d-m-Y h:i A ", filectime($nombre_archivo));
    echo '<br/>';
    echo "La ultima modificacion de <span style='color:#FF0000'>$nombre_archivo</span> fue: " . date("d-m-Y h:i A", filemtime($nombre_archivo));
    echo '<br/>';
    echo "El ultimo acceso a <span style='color:#FF0000'>$nombre_archivo</span> fue: " . date("d-m-Y h:i A", fileatime($nombre_archivo));
}
exit;
$finish = date("Y-m-d H:i");
$init   = "2013-12-27 23:10";
$diferencia = strtotime($finish) - strtotime($init);

echo $diferencia / 60;
exit;

function calculate_time_past($start_time, $end_time, $format = "s")
{
    $time_span = strtotime($end_time) - strtotime($start_time);
    if ($format == "s") { // is default format so dynamically calculate date format
        if ($time_span > 60) {
            $format = "i:s";
        }
        if ($time_span > 3600) {
            $format = "H:i:s";
        }
    }
    return gmdate($format, $time_span);
}

$start_time = "2013-12-27 12:00"; // 00:50:14 will work on its own 
$end_time   = "2013-12-27 23:00"; // 00:52:59 will also work instead 

echo calculate_time_past($start_time, $end_time) . "<br />"; // will output 02:45
echo calculate_time_past($start_time, $end_time, "H:i:s"); // will output 00:02:45 when format is overridden