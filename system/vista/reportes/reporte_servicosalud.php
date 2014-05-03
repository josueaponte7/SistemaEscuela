<?php

require_once '../../modelo/ServicioSalud.php';
require_once './tcpdf/spa.php';
require_once './tcpdf/tcpdf.php';


class MyClass extends TCPDF
{

    public function Header()
    {
        $this->setJPEGQuality(90);
        $this->Image('imagenes/top.png', 12, 5, 270, 12, 'PNG', FALSE);
    }

    public function Footer()
    {
        date_default_timezone_set('America/Caracas');
        $fecha = "Fecha: " . date("d/m/Y h:i A");
        $this->SetY(-8);
        // Set font
        $this->SetFont('FreeSerif', '', 8);
        //$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
        $style = array('width' => 0.30, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
        // Page number
        $this->Line(5, 200, 290, 200, $style);
        $this->Cell(25, 0, $fecha, 0, false, 'R', 0, '', 0, false, 'T', 'M');
        $this->Cell(265, 0, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

}

$campos['condicion'] = 1;
$id_condicion        = 'sp.id_servicio';
if (isset($_GET['id'])) {
    $id                  = $_GET['id'];
    $campos['condicion'] = " $id_condicion IN($id)";
}

$obj           = new ServicioSalud();
$campos['sql'] = "SELECT sp.id_servicio, 
                         sp.servicio, 
                        CONCAT_WS('-',ct.codigo, sp.telefono) AS telefono, 
                        ts.tiposervicio 
                        FROM servicio_publico sp 
                        INNER JOIN codigo_telefono ct ON (sp.cod_telefono = ct.id) 
                        INNER JOIN tiposervicio ts ON (sp.id_tiposervicio = ts.id_tiposervicio)
                    WHERE " . $campos['condicion'] . "
                  ORDER BY sp.id_servicio;";

$resultado = $obj->getServicio($campos);
$total     = $obj->totalFilas('servicio_publico AS sp', 'sp.id_servicio',$campos['condicion']);

$pdf = new MyClass("L", "mm", "A4", true, 'UTF-8', false);

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
$titulo = "LISTADO DE CENTRO DE SALUD PUBLICOS";
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

$w_id       = 10;
$w_centro   = 107;
$w_tipo     = 107;
$w_telefono = 30;


// Mover a la derecha 
$pdf->SetX(20);

// Color Cabecera de la tabla
$pdf->SetFillColor(39, 129, 213);

// Titulos de la Cabecera
$pdf->Cell($w_id, $row_height, 'ID', 1, 0, 'C', 1);
$pdf->Cell($w_centro, $row_height, 'Centro de Salud', 1, 0, 'L', 1);
$pdf->Cell($w_tipo, $row_height, 'Tipo de Centro de Salud', 1, 0, 'L', 1);
$pdf->Cell($w_telefono, $row_height, 'Telefono', 1, 1, 'L', 1);


// Ciclo para crear los registros
for ($i = 0; $i < count($resultado); $i++) {

    // Asignarle variables a los registros
    $id_servicio  = $resultado[$i]['id_servicio'];
    $servicio     = $resultado[$i]['servicio'];
    $tiposervicio = $resultado[$i]['tiposervicio'];
    $telefono     = $resultado[$i]['telefono'];

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
        $pdf->SetX(20);
        $pdf->Cell($w_id, $row_height, 'ID', 1, 0, 'C', 1);
        $pdf->Cell($w_centro, $row_height, 'Centro de Salud', 1, 0, 'L', 1);
        $pdf->Cell($w_tipo, $row_height, 'Tipo de Centro de Salud', 1, 0, 'L', 1);
        $pdf->Cell($w_telefono, $row_height, 'Telefono', 1, 1, 'L', 1);
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
    $pdf->SetX(20);
    $pdf->Cell($w_id, $row_height, $id_servicio, 1, 0, 'C', 1);
    $pdf->Cell($w_centro, $row_height, $servicio, 1, 0, 'L', 1);
    $pdf->Cell($w_tipo, $row_height, $tiposervicio, 1, 0, 'L', 1);
    $pdf->Cell($w_telefono, $row_height, $telefono, 1, 1, 'L', 1);
    $j++;
}
/* * *************Linea de fin de hoja con la cantidad total de registros********************* */
$pdf->setCellMargins(0, 0, 0, 0);
$linea     = '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------';
$pdf->Ln();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetX(20);
$pdf->Cell(0, 0, $linea, 0, 0, 'L', 1);
$pdf->Ln(6);
//$pdf->Write(14, 'Registros:' . '' . $h);
$pdf->SetFont('FreeSerif', '', 10);
$registros = 'Total de Registros:<span style="color:#FF0000;">' . $total . '</span>';
$pdf->SetX(240);
$pdf->writeHTML($registros, 1, 0, 1, 0, 'L');
$pdf->Output('listado_centrosSalud.pdf', 'I');

