<?php
require_once '../modelo/Preinscripcion.php';

$obj = new Preinscripcion();
if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if (isset($_POST['cedula'])) {
        $datos['cedula'] = $_POST['cedula'];
    }
    if (isset($_POST['num_registro'])) {
        $datos['num_registro'] = str_replace('0', '', $_POST['num_registro']);
    }
    switch ($accion) {
        case 'Guardar':

            $resultado = $obj->add($datos);
            if ($resultado) {
                echo 1;
            } else {
                echo 0;
            }
        break;
        case 'Buscar':
            $data['campos']    = "CONCAT_WS( ' ',nombre,apellido) AS datos,DATE_FORMAT(fech_naci,'%d/%m/%Y') AS fech_naci,sexo,(YEAR(CURDATE())-YEAR(fech_naci)) - (RIGHT(CURDATE(),5)<RIGHT(fech_naci,5)) AS edad,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_telefono),telefono) AS telefono,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = cod_celular),celular) AS celular";
            $data['condicion'] = "CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = es.nacionalidad),es.cedula)='" . $datos['cedula']."'";
            $data['limite']    = "1";
            $resultado         = $obj->datos($data);
            $num_preins        = $obj->get('pre_inscripcion AS es', 'num_registro',$data['condicion']);
            
            $num_registro      = '00000001'; 
            if($num_preins > 0){
                $num_registro =  str_pad($num_preins,7,"0",STR_PAD_LEFT);
            }else{
                $num_preins  = $obj->last('pre_inscripcion', 'num_registro');
                if($num_preins > 0){
                    $num_preins   = (int) $num_preins[0] + 1;
                    $num_registro =  str_pad($num_preins,7,"0",STR_PAD_LEFT);
                }
            }
            $es_array = is_array($resultado) ? TRUE : FALSE;
            if ($es_array == TRUE) {
                $sexo = 'Femenino';
                if($resultado[0]['sexo'] == 2){
                    $sexo = 'Masculino';
                }
                echo $num_registro.';'.$resultado[0]['datos'].';'.$resultado[0]['fech_naci'].';'.$sexo.';'.$resultado[0]['edad'].';'.$resultado[0]['telefono'].';'.$resultado[0]['celular'];
            }else{
                echo 0;
            }
            break;

        case 'Eliminar':
            $resultado = $obj->delete($datos);
            if ($resultado) {
                echo 1;
            }
       break;
       case 'UpRepre':
            $resultado = $obj->UpRepre($datos);
            if ($resultado) {
                echo 1;
            }
       break;
    }
}