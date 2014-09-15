<?php

require_once '../../modelo/Usuario.php';
require_once './class.ezpdf.php';

$condicion = 1;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $condicion = " u.id_usuario IN($id)";
}

$obj_usuario = new Usuario();

$d_usuar['sql'] = "SELECT 
                    u.id_usuario,
                    u.usuario, 
                    u.nombre, 
                    u.apellido, 
                    u.activo, 
                    u.id_grupo,
                    gp.nombre_grupo
                    FROM usuario u 
                    INNER JOIN grupo_usuario gp ON u.id_grupo=gp.id_grupo
                    WHERE $condicion
                    ORDER BY u.id_usuario";

$resul_usuario     = $obj_usuario->getUsuario($d_usuar);

for ($i = 0; $i < count($resul_usuario); $i++) {
    $arr['id_usuario']      =  $resul_usuario[$i]['id_usuario'];
    $arr1['usuario'] =  utf8_decode($resul_usuario[$i]['usuario']);
    
    $dtx    = array_merge($arr, $arr1);
    $data[] = $dtx;
}


$titles = array(
    'id_usuario'     => utf8_decode('<b>ID</b>'),
    'usuario' => utf8_decode('<b>Usuario</b>')
);


$title = "";
$pdf   = new Cezpdf('a4');
$pdf->selectFont('./fonts/Helvetica.afm');
$pdf->ezSetCmMargins(3, 1.65, 1.5, 1.5); // margenes
$pdf->ezStartPageNumbers(300, 5, 6, 'center', 'Pag:{PAGENUM} de {TOTALPAGENUM}', 1);

$all = $pdf->openObject();
$pdf->saveState();
$pdf->setStrokeColor(0, 0, 0, 1);
$pdf->addJpegFromFile('imagenes/top.jpg',25,760,540,'center');
$pdf->addJpegFromFile('imagenes/pie.jpg', 25, 12, 540);

date_default_timezone_set('America/Caracas');
$pdf->addText(25, 35, 6, "Fecha:" . date("d/m/Y"));
$pdf->addText(75, 35, 6, "Hora:" . date("h:i A"));

$pdf->restoreState();
$pdf->closeObject();
$pdf->addObject($all, 'all');

$txttit = "<b>REPORTE DE USUARIOS </b>\n";
//$textos = "Ejemplo de PDF con PHP y MYSQL \n";

$pdf->ezText($txttit, 10, array('justification' => 'center'));
$pdf->ezText("\n", 4);
//$pdf->ezText($textos, 10, array('justification' => 'center'));
//

$options = array(
    'shadeCol'     => array(0.9, 0.9, 0.9), // color de sombra (r, g, b)
    'shadeCol2'    => array(0, 0, 0.4),
    'ShowLines'    => 1, //
    'ShowHeadings' => 0, //
    'shaded'       => 1, // otra linea
    'lineCol'      => array(0.7, 0.7, 0.7), // color linea
    'fontSize'     => 10,
    'textCol'      => array(0.1, 0.1, 0.1), //color texto
    'rowGap'       => 2, // separacion de filas y letras
    'xOrientation' => 'center',
    /****Para cambiar el tamaño de la tabla******/
    'width'        => 300,
    'cols' =>
    array(
        'id_usuario' => array('width' => 80, 'justification' => 'left'))
);
$pdf->ezTable($data, $titles, "" . utf8_decode($title), $options);
$pdf->ezStream();
