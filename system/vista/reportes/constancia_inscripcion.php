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
    $pdf->MultiCell(180, 5, "CONSTANCIA DE INSCRIPCIÓN \n", 0, 'C', 0, 1, '', '', true);
    $pdf->Ln(5);
    
    $pdf->SetFont('times', '', 15, '', 'false');
    $texto = "Quien Suscribe, Director(a) de la Escuela Técnica Robinsoniana y Zamorana para la Diversidad Funcional San Carlos, T.E.L San Carlos hace constar que el (la) Alumno(a):<b>$nombre </b> ha sido inscrito(a) en la Actividad de:<b>$actividad</b> para el año Escolar <b>$anio_escolar</b>.";

    $pdf->writeHTMLCell(0, 0, '', '', $texto, 0, 1, 0, true, 'J', true);
    $pdf->Ln(5);
    $expide = "Se expide a petición de la parte interesada en Maracay, a los <b>$dia</b> días del mes de <b>$mes</b> del año <b>$anio</b>.";
    $pdf->writeHTMLCell(0, 0, '', '', $expide, 0, 1, 0, true, 'J', true);
    
    $pdf->Ln(30);
    $pdf->writeHTMLCell(0, 0, 80, '', 'Director(a).', 0, 1, 0, true, 'J', true);
}
$pdf->Output('constancia_inscripcion.pdf', 'I');

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
