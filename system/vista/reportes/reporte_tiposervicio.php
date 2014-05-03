<?php

require_once '../../modelo/TipoServicio.php';
require_once './tcpdf/spa.php';
require_once './tcpdf/MyClass.php';

$campos['condicion'] = 1;
$id_condicion        = 'id_tiposervicio';
if (isset($_GET['id'])) {
    $id                  = $_GET['id'];
    $campos['condicion'] = " $id_condicion IN($id)";
}

// Instnciar el objeto estado
$obj              = new TipoServicio();
$campos['campos'] = 'tp.id_tiposervicio,  tp.tiposervicio';
$resultado        = $obj->getTipo($campos);
$total            = $obj->totalFilas('tiposervicio', 'id_tiposervicio',$campos['condicion']);

$pdf = new MyClass("P", "mm", "A4", true, 'UTF-8', false);

// Mostrar Cabecera de titulo en las hojas
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

/* * ******Imagen del logo en la primera hoja********* */
$pdf->Image('imagenes/logo.png', 3, 18, 45, 15, 'PNG', FALSE);


// titulo del listado
$titulo = "LISTADO DE TIPOS DE SREVICIOS";
$pdf->Ln(5);
$pdf->SetX(60);
// fuente y tamaño de letra 
$pdf->SetFont('FreeSerif', 'B', 14);
// añadimos el titulo
$pdf->Cell(90, 0, $titulo, 0, 0, 'C', 0);
$pdf->Ln(15);

/* * ********************************** */



$j            = 0;
// Cantidad maxima de registros a mostrar por pagina
$max          = 35;
$row_height   = 6;
$backup_group = "";


// width de las filas 

$w_idservicio = 20;
$w_tipo       = 90;

// Mover a la derecha 
$pdf->SetX(50);
// Color Cabecera de la tabla
$pdf->SetFillColor(39, 129, 213);
// Titulos de la Cabecera
$pdf->Cell($w_idservicio, $row_height, 'ID', 1, 0, 'C', 1);
$pdf->Cell($w_tipo, $row_height, 'Tipo de Servicio', 1, 1, 'L', 1);


// Ciclo para crear los registros
for ($i = 0; $i < count($resultado); $i++) {

    // Asignarle variables a los registros
    $id_tiposervicio = $resultado[$i]['id_tiposervicio'];
    $tiposervicio    = $resultado[$i]['tiposervicio'];

    // verificar que la variable $j no si es mayor se hace un salto de pagina
    if ($j > $max) {
        $pdf->AddPage();

        // color de la letra
        $pdf->SetFillColor(255, 255, 255);

        // salto de linea
        $pdf->Ln(15);
        /*         * ****Imagen del logo de las hojas que continua***** */
        $pdf->Image('imagenes/logo.png', 3, 18, 45, 15, 'PNG', FALSE);
        // Tipo de letra negrita tamaño 14
        $pdf->SetFont('FreeSerif', 'B', 14);

        $pdf->SetX(60);
        // Titulo del Reporte width:90 heigth:0 text:$titulo alineacion:C
        $pdf->Cell(90, 0, $titulo, 0, 0, 'C', 0);
        $pdf->Ln(15);

        // Color Cabecera de la tabla
        $pdf->SetFillColor(39, 129, 213);
        $pdf->SetX(50);
        $pdf->Cell($w_idservicio, $row_height, 'ID', 1, 0, 'C', 1);
        $pdf->Cell($w_tipo, $row_height, 'Tipo de Servicio', 1, 1, 'L', 1);
        $j = 0;
    }

    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('FreeSerif', '', 12);
    if ($i % 2 != 0) {
        $pdf->SetFillColor(204, 205, 206);
    }

    /* $pdf->SetTextColor(0, 0, 0);
      if ($id == 20 || $id == 40 || $id == 60) {
      $pdf->SetTextColor(255, 0, 0);
      } */

    // crear los registros a mostrar
    $pdf->SetFont('FreeSerif', '', 12);
    $pdf->SetX(50);
    $pdf->Cell($w_idservicio, $row_height, $id_tiposervicio, 1, 0, 'C', 1);
    $pdf->Cell($w_tipo, $row_height, $tiposervicio, 1, 1, 'L', 1);
    $j++;
}
/* * *************Linea de fin de hoja con la cantidad total de registros********************* */
$pdf->setCellMargins(0, 0, 0, 0);
$linea     = '------------------------------------------------------------------------------------------------------------------------------';
$pdf->Ln();
$pdf->SetFillColor(255, 255, 255);
$pdf->Cell(0, 0, $linea, 0, 0, 'L', 1);
$pdf->Ln(6);
//$pdf->Write(14, 'Registros:' . '' . $h);
$pdf->SetFont('FreeSerif', '', 10);
$registros = 'Total de Registros:<span style="color:#FF0000;">' . $total . '</span>';
$pdf->writeHTML($registros, true, false, true, false, 'R');
$pdf->Output('listado_tiposServicios.pdf', 'I');

