<?php

require_once '../../modelo/Representante.php';
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


$campos['condicion'] = 1 .' AND condicion=1';
$cedula_condicion = 're.cedula'; 
if(isset($_GET['cedulas'])){

    $id = $_GET['cedulas'];
    $campos['condicion'] = " $cedula_condicion IN($id)";
}

$obj = new Representante();
$campos['sql'] = "SELECT 
                    CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = re.nacionalidad),re.cedula) AS cedula,
                    CONCAT_WS(' ',re.nombre,re.apellido) AS nombres,
                    IF(cod_telefono='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_telefono),telefono)) AS telefono, 
                    IF(cod_celular='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_celular),celular)) AS celular,
                    (select er.nombre from estatus_representante er where re.id_estatus = er.id_estatus) AS estatus
                  FROM representante re
                  WHERE ".$campos['condicion']. "
                  ORDER BY re.cedula";

$resultado  = $obj->getRepresentantes($campos);
$total     = $obj->totalFilas('representante AS re', 're.cedula',$campos['condicion']);

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
$titulo = "LISTADO DE REPRESENTANTES";
$pdf->Ln(5);
$pdf->SetX(90);
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

$w_cedula   = 40;
$w_nombre   = 95;
$w_telefono = 65;
$w_estatus = 45;


// Mover a la derecha 
$pdf->SetX(28);

// Color Cabecera de la tabla
$pdf->SetFillColor(39, 129, 213);

// Titulos de la Cabecera
$pdf->Cell($w_cedula, $row_height, 'Cedula', 1, 0, 'C', 1);
$pdf->Cell($w_nombre, $row_height, 'Nombres', 1, 0, 'L', 1);
$pdf->Cell($w_telefono, $row_height, 'Teléfonos', 1, 0, 'L', 1);
$pdf->Cell($w_estatus, $row_height, 'Status', 1, 1, 'L', 1);


// Ciclo para crear los registros
for ($i = 0; $i < count($resultado); $i++) {

    // Asignarle variables a los registros
    $cedula   = $resultado[$i]['cedula'];
    $nombres  = $resultado[$i]['nombres'];
    $telefono = $resultado[$i]['telefono'];
    $celular  = $resultado[$i]['celular'];
    $estatus  = $resultado[$i]['estatus'];
    
    if ($telefono != 0 && $celular == 0) {
        $telefonos = $telefono;
    } else if ($celular != 0 && $telefono == 0) {
        $telefonos = $celular;
    } else if ($telefono != 0 && $celular != 0) {
        $telefonos = $telefono . ',' . $celular;
    }


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

        $pdf->SetX(90);
        // Titulo del Reporte width:90 heigth:0 text:$titulo alineacion:C
        $pdf->Cell(90, 0, $titulo, 0, 0, 'C', 0);
        $pdf->Ln(15);

        // Color Cabecera de la tabla
        $pdf->SetFillColor(39, 129, 213);
        $pdf->SetX(28);
        $pdf->Cell($w_cedula, $row_height, 'Cedula', 1, 0, 'C', 1);
        $pdf->Cell($w_nombre, $row_height, 'Nombres', 1, 0, 'L', 1);
        $pdf->Cell($w_telefono, $row_height, 'Telefonos', 1, 0, 'L', 1);
        $pdf->Cell($w_estatus, $row_height, 'Status', 1, 1, 'L', 1);
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
    $pdf->SetX(28);
    $pdf->Cell($w_cedula, $row_height, $cedula, 1, 0, 'C', 1);
    $pdf->Cell($w_nombre, $row_height, $nombres, 1, 0, 'L', 1);
    $pdf->Cell($w_telefono, $row_height, $telefonos, 1, 0, 'L', 1);
    $pdf->Cell($w_estatus, $row_height, $estatus, 1, 1, 'L', 1);
    $j++;
}
/* * *************Linea de fin de hoja con la cantidad total de registros********************* */
$pdf->setCellMargins(0, 0, 0, 0);
$linea     = '-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------';
$pdf->Ln();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetX(28);
$pdf->Cell(0, 0, $linea, 0, 0, 'L', 1);
$pdf->Ln(6);
//$pdf->Write(14, 'Registros:' . '' . $h);
$pdf->SetFont('FreeSerif', '', 10);
$registros = 'Total de Registros:<span style="color:#FF0000;">' . $total . '</span>';
$pdf->SetX(245);
$pdf->writeHTML($registros, 1, 0, 1, 0, 'L');
$pdf->Output('listado_reperesentantes.pdf', 'I');
