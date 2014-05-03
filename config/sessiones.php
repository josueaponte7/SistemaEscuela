<?php
session_start();
$id_sesion_antigua = session_id();

session_regenerate_id();

$id_sesion_nueva = session_id();

echo "Sesion Antigua: $id_sesion_antigua<br />";
echo "Sesion Nueva: $id_sesion_nueva<br />";

