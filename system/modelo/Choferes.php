<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Choferes extends Seguridad {

    public function __construct() {
        
    }

    public function add($datos) {

        $nacionalidad = $datos['nacionalidad'];
        $cedula       = $datos['cedula'];
        $nombre       = $datos['nombre'];
        $apellido     = $datos['apellido'];
        $email        = $datos['email'];
        $cod_telefono = $datos['cod_telefono'];
        $telefono     = $datos['telefono'];
        $cod_celular  = $datos['cod_celular'];
        $celular      = $datos['celular'];
        $placa        = $datos['placa'];
        $modelo       = $datos['modelo'];
        $color        = $datos['color'];

        $sql = "INSERT INTO chofer(nacionalidad,cedula,nombre,apellido,email,cod_telefono,telefono, cod_celular,celular)
                        VALUES ('$nacionalidad','$cedula','$nombre','$apellido','$email','$cod_telefono','$telefono','$cod_celular','$celular');";

        $sql1 = "INSERT INTO automovil(placa,modelo,color,cedula_chofer)
                    VALUES ('$placa','$modelo','$color','$cedula');";

        $resultado = $this->ejecutar($sql);
        $resultado = $this->ejecutar($sql1);
        return $resultado;
    }
    
    public function update($datos){
        $nacionalidad = $datos['nacionalidad'];
        $cedula       = $datos['cedula'];
        $nombre       = $datos['nombre'];
        $apellido     = $datos['apellido'];
        $email        = $datos['email'];
        $cod_telefono = $datos['cod_telefono'];
        $telefono     = $datos['telefono'];
        $cod_celular  = $datos['cod_celular'];
        $celular      = $datos['celular'];
        $placa        = $datos['placa'];
        $modelo       = $datos['modelo'];
        $color        = $datos['color'];
        
       $sql = "UPDATE chofer
                    SET nacionalidad = '$nacionalidad',
                      nombre         = '$nombre',
                      apellido       = '$apellido',
                      email          = '$email',
                      cod_telefono   = '$cod_telefono',
                      telefono       = '$telefono',
                      cod_celular    = '$cod_celular',
                      celular        = '$celular'
                    WHERE cedula     = '$cedula';";

       $sql1 = "UPDATE automovil
                    SET placa       = '$placa',
                      modelo        = '$modelo',
                      color         = '$color'
                    WHERE cedula_chofer     = '$cedula';";


        $resultado = $this->ejecutar($sql);
        $resultado = $this->ejecutar($sql1);
        return $resultado;
        
        
        
        
    }

        public function getChofer($opciones)
    {
        if(!isset($opciones['sql'])){
        $default   = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
        $opciones  = array_merge($default, $opciones);
        $sql       = "SELECT {$opciones['campos']} FROM chofer ch WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        }else{
            $sql = $opciones['sql'];
        }
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
