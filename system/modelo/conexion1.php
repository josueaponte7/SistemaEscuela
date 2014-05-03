<?php

$mysqli = new mysqli("localhost", "root", "", "escuela");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

/* Create table doesn't return a resultset */
if ($mysqli->query("INSERT  INTO datos (cedula, nombre, apellido, id_sexo, id_sector, fecha_nac, fecha_registro) VALUES (13575773, 'Maria', 'Perez', 1, 2, 1978-04-25, NOW())") === TRUE) {
    printf("Table myCity successfully created.\n");
}

$mysqli->close();
?>

