<?php

require_once '../../modelo/Preinscripcion.php';
require_once './tcpdf/spa.php';
require_once './tcpdf/MyClass.php';

$campos['condicion'] = 1;
$id_estatus_condicion = 'e.id_estatus'; 
if(isset($_GET['id_estatus'])){
    $id_estatus = $_GET['id_estatus'];
    $campos['condicion'] = "e.id_estatus < 3";
}

$obj = new Preinscripcion();
$campos['sql'] = "SELECT 
                    LPAD(pr.num_registro, 8, '0') AS num_registro,
                    CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = pr.nacionalidad),pr.cedula) AS cedula,
                    CONCAT_WS(' ',e.nombre,e.apellido) AS nombres,
                    se.sexo,
                    CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = e.cod_telefono),e.telefono) AS telefonos,
                    DATE_FORMAT(CURRENT_DATE,'%d/%m/%Y' ) AS fecha_actual
                    FROM pre_inscripcion pr
                    INNER JOIN estudiante AS e ON(pr.cedula = e.cedula)
                    INNER JOIN sexo se ON (e.sexo = se.id_sexo)
                    WHERE e.id_estatus < 3";
$resultado  = $obj->datos($campos);

//$total     = $obj->totalFilas('estudiante AS e', 'e.id_estatus','e.id_estatus < 3');

//total de registros a mostrar en el reporte
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
$titulo = "LISTADO DE LA PRE-INSCRITOS";
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
$w_num_registro   = 40;
$w_cedula   = 27;
$w_nombres   = 45;
$w_sexo = 25;
$w_telefonos = 30;
$w_fecha_actual = 32;



// Mover a la derecha 
$pdf->SetX(7);

// Color Cabecera de la tabla
$pdf->SetFillColor(39, 129, 213);

// Titulos de la Cabecera
$pdf->Cell($w_num_registro, $row_height, 'Número Registro', 1, 0, 'C', 1);
$pdf->Cell($w_cedula, $row_height, 'Cedula', 1, 0, 'C', 1);
$pdf->Cell($w_nombres, $row_height, 'Nombres', 1, 0, 'L', 1);
$pdf->Cell($w_sexo, $row_height, 'Sexo', 1, 0, 'L', 1);
$pdf->Cell($w_telefonos, $row_height, 'Teléfonos', 1, 0, 'L', 1);
$pdf->Cell($w_fecha_actual, $row_height, 'Fecha Actual', 1, 1, 'L', 1);


// Ciclo para crear los registros
for ($i = 0; $i < count($resultado); $i++) {

    // Asignarle variables a los registros
    $num_registro    = $resultado[$i]['num_registro'];
    $cedula    = $resultado[$i]['cedula'];
    $nombres   = $resultado[$i]['nombres'];
    $sexo = $resultado[$i]['sexo'];
    $telefonos = $resultado[$i]['telefonos'];
    $fecha_actual = $resultado[$i]['fecha_actual'];
    

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
        $pdf->SetX(7);
        $pdf->Cell($w_num_registro, $row_height, 'Número Registro', 1, 0, 'C', 1);
        $pdf->Cell($w_cedula, $row_height, 'Cedula', 1, 0, 'C', 1);
        $pdf->Cell($w_nombres, $row_height, 'Nombres', 1, 0, 'L', 1);
        $pdf->Cell($w_sexo, $row_height, 'Sexo', 1, 0, 'L', 1);
        $pdf->Cell($w_telefonos, $row_height, 'Teléfono', 1, 0, 'L', 1);
        $pdf->Cell($w_fecha_actual, $row_height, 'Fecha Actual', 1, 1, 'L', 1);
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
    $pdf->SetX(7);
    $pdf->Cell($w_num_registro, $row_height, $num_registro, 1, 0, 'C', 1);
    $pdf->Cell($w_cedula, $row_height, $cedula, 1, 0, 'C', 1);
    $pdf->Cell($w_nombres, $row_height, $nombres, 1, 0, 'L', 1);
    $pdf->Cell($w_sexo, $row_height, $sexo, 1, 0, 'L', 1);
    $pdf->Cell($w_telefonos, $row_height, $telefonos, 1, 0, 'L', 1);
    $pdf->Cell($w_fecha_actual, $row_height, $fecha_actual, 1, 1, 'L', 1);
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
$pdf->Output('listado_preinscripcion.pdf', 'I');



