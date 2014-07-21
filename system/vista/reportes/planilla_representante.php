<?php

require_once './class.ezpdf.php';
require_once '../../modelo/Parroquia.php';
require_once '../../modelo/Seguridad.php';
require_once '../../modelo/Representante.php';


$obj_parro = new Parroquia();
$obj_repre = new Seguridad();
$obj_rep   = new Representante();

$campos['condicion'] = 1;
$cedula_condicion    = 're.cedula';

if (!isset($_GET['cedula'])) {
    
}
$cedula        = $_GET['cedula'];
$campos['sql'] = "SELECT 
                    CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = re.nacionalidad),re.cedula) AS cedula,
                    CONCAT_WS(' ',re.nombre,re.apellido) AS nombres,
                    re.email,
                    DATE_FORMAT(re.fech_naci,'%d-%m-%Y') AS fech_naci,
                    (YEAR(CURDATE())-YEAR(re.fech_naci))-(RIGHT(CURDATE(),5)<RIGHT(re.fech_naci,5)) AS edad,
                    re.lugar_naci,
                    CONCAT_WS(', ', 
                    CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = re.cod_telefono),re.telefono),
                    CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = re.cod_celular),re.celular)) AS telefonos,
                    e.nombre_estado,
                    m.nombre_municipio,
                    p.nombre_parroquia,
                    CONCAT_WS(' ',CONCAT('Calle ',re.calle),CONCAT('Casa o Apto nº' ,re.casa),IF(re.edificio!=NULL,CONCAT('Edificio',re.edificio),''),CONCAT('Barrio ',re.barrio)) AS direccion
                   FROM representante re
                   INNER JOIN parroquia AS p ON re.id_parroquia=p.id_parroquia
                   INNER JOIN municipio AS m ON p.id_municipio=m.id_municipio
                   INNER JOIN estado AS e ON m.id_estado=e.id_estado
                   WHERE re.cedula=" . $cedula;



$resultado  = $obj_rep->getRepresentantes($campos);


$title = "";
$pdf   = new Cezpdf('a4');
$pdf->selectFont('./fonts/Times-Roman.afm');
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
$txttit = "<b> Planilla de Representante</b>\n";
//$textos = "Ejemplo de PDF con PHP y MYSQL \n";

$pdf->ezText($txttit, 15, array('justification' => 'center'));
$pdf->ezText("\n", 4);
$pdf->addText(50, 700, 12, utf8_decode('<b>Cédula:.</b>'.$resultado[0]['cedula']));
$pdf->addText(200, 700, 12, utf8_decode('<b>Nombres: </b>'.$resultado[0]['nombres']));
$pdf->addText(50, 650, 12, utf8_decode('<b>Télefonos: </b>'.$resultado[0]['telefonos']));
$pdf->addText(300, 650, 12, utf8_decode('<b>Correo: </b>'.$resultado[0]['email']));
$pdf->addText(50, 600, 12, utf8_decode('<b>Fecha de Nacimiento: </b>'.$resultado[0]['fech_naci']));
$pdf->addText(300, 600, 12, utf8_decode('<b>Edad: </b>'.$resultado[0]['edad']));
$pdf->addText(50, 550, 12, utf8_decode('<b>Lugar de Nacimiento: </b>'.$resultado[0]['lugar_naci']));
$pdf->addText(50, 500, 12, utf8_decode('<b>Estado: </b>'.$resultado[0]['nombre_estado']));
$pdf->addText(300, 500, 12, utf8_decode('<b>Municipio: </b>'.$resultado[0]['nombre_municipio']));
$pdf->addText(50, 450, 12, utf8_decode('<b>Parroquia: </b>'.$resultado[0]['nombre_parroquia']));
$pdf->addText(50, 400, 12, utf8_decode('<b>Dirección: </b>'.$resultado[0]['direccion']));
$opciones['Content-Disposition'] = 'planilla_representante.pdf';
$pdf->ezStream($opciones);


