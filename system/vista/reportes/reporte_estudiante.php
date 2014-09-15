<?php

require_once '../../modelo/Estudiante.php';
require_once './tcpdf/spa.php';
require_once './tcpdf/MyClass.php';

$campos['condicion'] = 1 .' AND e.condicion=1';
$cedula_condicion = 'e.cedula'; 

if(isset($_GET['cedula'])){
    $cedula = $_GET['cedula'];
    $campos['condicion'] = " $cedula_condicion IN($cedula)";
}

$obj = new Estudiante();
$campos['sql'] = "SELECT 
                    CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = e.nacionalidad),e.cedula) AS cedula,
                    e.nombre,
                    e.apellido,
                    r.cedula as cedula_r,
                    CONCAT_WS(' ',r.nombre,r.apellido) AS representante
                    FROM estudiante_representante AS er
                    INNER JOIN estudiante AS e ON(er.cedula_estudiante=e.cedula AND er.representante=1)
                    INNER JOIN representante AS r ON(er.cedula_representante=r.cedula AND er.representante=1)
                    WHERE " . $campos['condicion'] . "
                    ORDER BY e.cedula";
$resultado  = $obj->getEstudianterepre($campos);

//total de registros a mostrar en el reporte
//$total     = $obj->totalFilas('estudiante AS e', 'e.cedula',$campos['condicion']);

$total = count($resultado);

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
$titulo = "LISTADO DE ESTUDIANTES";
$pdf->Ln(5);
$pdf->SetX(60);
// fuente y tamaño de letra 
$pdf->SetFont('FreeSerif', 'B', 12);
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
$w_nombre   = 50;
$w_apellido = 50;
$w_repre = 50;


// Mover a la derecha 
$pdf->SetX(10);

// Color Cabecera de la tabla
$pdf->SetFillColor(39, 129, 213);

// Titulos de la Cabecera
$pdf->SetFont('FreeSerif', 'B', 11);
$pdf->MultiCell($w_cedula, $row_height, 'Cedula', 1,  'C',1, 0);
$pdf->MultiCell($w_nombre, $row_height, 'Nombres', 1,  'L', 1,0);
$pdf->MultiCell($w_apellido, $row_height, 'Apellidos', 1, 'L', 1,0);
$pdf->MultiCell($w_repre, $row_height, 'Representante', 1, 'L', 1,1);


// Ciclo para crear los registros
for ($i = 0; $i < count($resultado); $i++) {

    // Asignarle variables a los registros
    $cedula    = $resultado[$i]['cedula'];
    $nombre   = $resultado[$i]['nombre'];
    $apellido  = $resultado[$i]['apellido'];
    $representante = $resultado[$i]['representante'];

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
        $pdf->SetFont('FreeSerif', 'B', 11);

        $pdf->SetX(60);
        // Titulo del Reporte width:90 heigth:0 text:$titulo alineacion:C
        $pdf->Cell(90, 0, $titulo, 0, 0, 'C', 0);
        $pdf->Ln(15);

        // Color Cabecera de la tabla
        $pdf->SetFillColor(39, 129, 213);
        $pdf->SetX(10);
        $pdf->MultiCell($w_cedula, $row_height, 'Cedula', 1, 'C', 0);
        $pdf->MultiCell($w_nombre, $row_height, 'Nombres', 1, 'L', 1,0);
        $pdf->MultiCell($w_apellido, $row_height, 'Apellidos', 1, 'L', 1,0);
        $pdf->MultiCell($w_repre, $row_height, 'Representante', 1,'L', 1,1);
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
    $pdf->SetFont('FreeSerif', '', 10);
    $pdf->SetX(10);
    $pdf->MultiCell($w_cedula, 10, $cedula, 1,  'C', 1,0);
    $pdf->MultiCell($w_nombre, 10, $nombre, 1, 'L', 1,0);
    $pdf->MultiCell($w_apellido, 10, $apellido, 1,'L', 1,0);
    $pdf->MultiCell($w_repre, 10, $representante, 1,'L', 1,1);
    $j++;
}
/* * *************Linea de fin de hoja con la cantidad total de registros********************* */
$pdf->setCellMargins(0, 0, 0, 0);
$linea     = '----------------------------------------------------------------------------------------------------------------------------------------------------------------';
$pdf->Ln();
$pdf->SetFillColor(255, 255, 255);
$pdf->SetX(10);
$pdf->Cell(0, 0, $linea, 0, 0, 'L', 0);
$pdf->Ln(5);
//$pdf->Write(14, 'Registros:' . '' . $h);
$pdf->SetFont('FreeSerif', '', 10);
$registros = 'Total de Registros:<span style="color:#FF0000;">' . $total . '</span>';
$pdf->writeHTML($registros, true, false, true, false, 'R');
$pdf->Output('listado_estudiantes.pdf', 'I');
