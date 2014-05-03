<?php
require_once './tcpdf/tcpdf.php';
class MyClass extends TCPDF
{

    public function Header()
    {
        $this->setJPEGQuality(90);
        $this->Image('imagenes/top.png', 12, 5, 185, 12, 'PNG', FALSE);
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
        $this->Line(15, 285, 195, 285, $style);
        $this->Cell(35, 0, $fecha, 0, false, 'R', 0, '', 0, false, 'T', 'M');
        $this->Cell(160, 0, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

}
