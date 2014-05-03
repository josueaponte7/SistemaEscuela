<?php

session_start();
date_default_timezone_set('America/Caracas');
if (isset($_SESSION['id_session'])) {

    echo'Fin '.$finish       = date("Y-m-d H:i");
    echo '<br/>';
    echo'Inicio '.$init         = date($_SESSION['date_session']);
    echo '<br/>';
    $diferencia   = strtotime($init) - strtotime('now');
    $transcurrido = intval($diferencia / 60/60/24);
    echo $transcurrido . '<br/>';
    if ($transcurrido > 10) {
        echo "Caudoco la Session";
    } else {
        echo "Acceso Perimitido";
    }
} else {
    echo "Acceso Denegado";
}
