<?php

require_once '../../modelo/Inscripcion.php';
require_once './tcpdf/spa.php';
require_once './tcpdf/MyClass.php';


$todos  = TRUE;
$cedula = "";
if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];
    $todos  = FALSE;
    
}

$obj    = new Inscripcion();

$resultado = $obj->getDatosConst($cedula, $todos);

$pdf = new MyClass("P", "mm", "A4", true, 'UTF-8', false);

// Ciclo para crear los registros
for ($i = 0; $i < count($resultado); $i++) {

    $nombre       = $resultado[$i]['nombre'];
    $actividad    = $resultado[$i]['actividad'];
    $anio_escolar = $resultado[$i]['anio'];
    $pdf->setPrintHeader(true);
    
// salto de linea
    $pdf->Ln(50);
    
// Mostrar Cabecera de footer en las hoja
    $pdf->setPrintFooter(true);
    
// mostrar numero de paginas
    $pdf->SetAutoPageBreak(true);
    
//setear margenes 
    $pdf->SetMargins(15, 20, 15);
    
// añadimos la pagina
    $pdf->AddPage();

    date_default_timezone_set('America/Caracas');
    $dia   = date('d');
    $mes   = mes();
    $anio  = date('Y');
    $pdf->SetY(30);
    $pdf->SetFont('times', 'B', 15, '', 'false');
// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
    $pdf->MultiCell(180, 5, "REPUBLICA BOLIVARIANA DE VENEZUELA \n ESCUELA TÉCNICA ROBINSONIANA Y ZAMORANA PARA LA \nDIVERSIDAD FUNCIONAL SAN CARLOS \n T.E.L SAN CARLOS", 0, 'C', 0, 1, '', '', true);
    $pdf->Ln(15);
    
    $pdf->SetFont('times', 'B', 15, '', 'false');
    $pdf->MultiCell(180, 5, "CONSTANCIA DE ESTUDIO \n", 0, 'C', 0, 1, '', '', true);
    $pdf->Ln(5);
    
    $pdf->SetFont('times', '', 15, '', 'false');
    $texto = "Quien Suscribe, Director(a) de la Escuela Técnica Robinsoniana y Zamorana para la Diversidad Funcional San Carlos, T.E.L San Carlos hace constar que el (la) Alumno(a):<b>$nombre </b>, actualmente cursa estudios en nuestra institución, desarrollandose en la Actividad de:<b>$actividad</b> para el año Escolar <b>$anio_escolar</b>.";

    $pdf->writeHTMLCell(0, 0, '', '', $texto, 0, 1, 0, true, 'J', true);
    $pdf->Ln(5);
    $expide = "Se expide a petición de la parte interesada en Maracay, a los <b>$dia</b> días del mes de <b>$mes</b> del año <b>$anio</b>.";
    $pdf->writeHTMLCell(0, 0, '', '', $expide, 0, 1, 0, true, 'J', true);

    $pdf->Ln(35);
    $pdf->writeHTMLCell(0, 0, 80, '', 'Director(a).', 0, 1, 0, true, 'J', true);
}


$pdf->Output('constancia_estudio.pdf', 'I');

function mes()
{

    $mes_return = '';
    $mes        = date('m');
    if ($mes == '01') {
        $mes_return = "Enero";
    } else if ($mes == '02') {
        $mes_return = "Febrero";
    } else if ($mes == '03') {
        $mes_return = "Marzo";
    } else if ($mes == '04') {
        $mes_return = "Abril";
    } else if ($mes == '05') {
        $mes_return = "Mayo";
    } else if ($mes == '06') {
        $mes_return = "Junio";
    } else if ($mes == '07') {
        $mes_return = "Julio";
    } else if ($mes == '08') {
        $mes_return = "Agosto";
    } else if ($mes == '09') {
        $mes_return = "Septiembre";
    } else if ($mes == '10') {
        $mes_return = "Octubre";
    } else if ($mes == '11') {
        $mes_return = "Noviembre";
    } else if ($mes == '12') {
        $mes_return = "Diciembre";
    }
    return $mes_return;
}

////$fecha_actual = $resultado[0]['fecha_actual'];
//
//$nombre       = $resultado[0]['nombre'];
//$actividad    = $resultado[0]['actividad'];
//$anio_escolar = $resultado[0]['anio'];
//$title     = "";
//$pdf       = new Cezpdf('a4');
//$pdf->selectFont('./fonts/Times-Roman.afm');
//$pdf->ezSetCmMargins(3, 1.65, 1.5, 1.5); // margenes
//$pdf->ezStartPageNumbers(300, 5, 6, 'center', 'Pag:{PAGENUM} de {TOTALPAGENUM}', 1);
//
//$all = $pdf->openObject();
//$pdf->saveState();
//$pdf->setStrokeColor(0, 0, 0, 1);
//$pdf->addJpegFromFile('imagenes/top.jpg', 25, 760, 540, 'center');
//$pdf->addJpegFromFile('imagenes/pie.jpg', 25, 12, 540);
//
//date_default_timezone_set('America/Caracas');
//$pdf->addText(25, 35, 6, "Fecha:" . date("d/m/Y"));
//$pdf->addText(75, 35, 6, "Hora:" . date("h:i A"));
//$dia = date('d');
//$mes = mes();
//
//$anio   = date('Y');
//$pdf->restoreState();
//$pdf->closeObject();
//$pdf->addObject($all, 'all');
//$txttit = utf8_decode("<b> REPUBLICA BOLIVARIANA DE VENEZUELA
//ESCUELA TÉCNICA ROBINSONIANA Y ZAMORANA PARA LA DIVERSIDAD FUNCIONAL SAN CARLOS
//T.E.L SAN CARLOS.</b>");
////$textos = "Ejemplo de PDF con PHP y MYSQL \n";
//$pdf->ezText($txttit, 15, array('justification' => 'center'));
//$pdf->ezText("\n", 4);
//
//$txttit = utf8_decode("<b> CONSTANCIA DE ESTUDIOS </b>\n");
////$textos = "Ejemplo de PDF con PHP y MYSQL \n";
//$pdf->ezText($txttit, 15, array('justification' => 'center'));
//$pdf->ezText("\n", 4);
//
//$pdf->addObject($all, 'all');
//$txttit = utf8_decode("Quien Suscribe, Director(a) de la Escuela Técnica Robinsoniana y Zamorana para la Diversidad Funcional San Carlos, T.E.L San Carlos hace constar que el (la) Alumno(a):<b>$nombre </b>, actualmente cursa estudios en nuestra institución, desarrollandose en la Actividad de:<b>$actividad</b> para el anio Escolar <b>$anio_escolar</b>.");
//
////$textos = "Ejemplo de PDF con PHP y MYSQL \n";
//$pdf->ezText($txttit, 15, array('justification' => 'justifice'));
//$pdf->ezText("\n", 2);
//
//$pdf->addObject($all, 'all');
//$txttit = utf8_decode("Se expide a petición de la parte interesada en Maracay, a los <b>$dia</b> días del mes de <b>$mes</b> del año <b>$anio</b>.");
//
////$textos = "Ejemplo de PDF con PHP y MYSQL \n";
//$pdf->ezText($txttit, 15, array('justification' => 'justifice'));
//$pdf->ezText("\n", 2);
//
//$pdf->addObject($all, 'all');
//$txttit = "Director(a).\n";
//
////$textos = "Ejemplo de PDF con PHP y MYSQL \n";
//$pdf->ezText($txttit, 15, array('justification' => 'center'));
//$pdf->ezText("\n", 2);
//
//$opciones['Content-Disposition'] = 'constancia_estudio.pdf';
//$pdf->ezStream($opciones);

//function mes()
//{
//
//    $mes_return = '';
//    $mes        = date('m');
//    if ($mes == '01') {
//        $mes_return = "Enero";
//    } else if ($mes == '02') {
//        $mes_return = "Febrero";
//    } else if ($mes == '03') {
//        $mes_return = "Marzo";
//    } else if ($mes == '04') {
//        $mes_return = "Abril";
//    } else if ($mes == '05') {
//        $mes_return = "Mayo";
//    } else if ($mes == '06') {
//        $mes_return = "Junio";
//    } else if ($mes == '07') {
//        $mes_return = "Julio";
//    } else if ($mes == '08') {
//        $mes_return = "Agosto";
//    } else if ($mes == '09') {
//        $mes_return = "Septiembre";
//    } else if ($mes == '10') {
//        $mes_return = "Octubre";
//    } else if ($mes == '11') {
//        $mes_return = "Noviembre";
//    } else if ($mes == '12') {
//        $mes_return = "Diciembre";
//    }
//    return $mes_return;
//}
