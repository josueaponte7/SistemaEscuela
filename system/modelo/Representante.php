<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Representante extends Seguridad
{

    private $_sql;

    public function __construct()
    {
        
    }

    public function add($datos)
    {

        $nacionalidad   = $datos['nacionalidad'];
        $cedula         = $datos['cedula'];
        $nombre         = $datos['nombre'];
        $apellido       = $datos['apellido'];
        $email          = $datos['email'];
        $fech_naci      = $datos['fech_naci'];
        $lugar_naci     = $datos['lugar_naci'];
        $sexo           = $datos['sexo'];
        $calle          = $datos['calle'];
        $casa           = $datos['casa'];
        $edificio       = $datos['edificio'];
        $barrio         = $datos['barrio'];
        $cod_telefono   = $datos['cod_telefono'];
        $telefono       = $datos['telefono'];
        $cod_celular    = $datos['cod_celular'];
        $celular        = $datos['celular'];
        $antecedente    = $datos['antecedente'];
        $fuente_ingreso = $datos['fuente_ingreso'];
        $id_parroquia   = $datos['id_parroquia'];
        $id_estatus     = $datos['id_estatus'];
        $id_nivel       = $datos['id_nivel'];
        $id_profesion   = $datos['id_profesion'];

        $fech_naci = $this->formateaBD($fech_naci);

        $sql = "INSERT INTO representante(nacionalidad, cedula, nombre,  apellido, email, fech_naci, lugar_naci, sexo, calle, casa, edificio,barrio,
                           antecedente,fuente_ingreso, cod_telefono, telefono, cod_celular, celular, id_parroquia, id_estatus, id_nivel, id_profesion)               
                     VALUES ('$nacionalidad','$cedula', '$nombre', '$apellido','$email', '$fech_naci', '$lugar_naci', '$sexo', '$calle', '$casa',
                             '$edificio', '$barrio', '$antecedente', '$fuente_ingreso', '$cod_telefono', '$telefono', '$cod_celular', '$celular',
                             '$id_parroquia', '$id_estatus','$id_nivel', '$id_profesion');";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function update($datos)
    {

        $nacionalidad   = $datos['nacionalidad'];
        $cedula         = $datos['cedula'];
        $nombre         = $datos['nombre'];
        $apellido       = $datos['apellido'];
        $email          = $datos['email'];
        $fech_naci      = $datos['fech_naci'];
        $lugar_naci     = $datos['lugar_naci'];
        $sexo           = $datos['sexo'];
        $calle          = $datos['calle'];
        $casa           = $datos['casa'];
        $edificio       = $datos['edificio'];
        $barrio         = $datos['barrio'];
        $cod_telefono   = $datos['cod_telefono'];
        $telefono       = $datos['telefono'];
        $cod_celular    = $datos['cod_celular'];
        $celular        = $datos['celular'];
        $antecedente    = $datos['antecedente'];
        $fuente_ingreso = $datos['fuente_ingreso'];
        $id_parroquia   = $datos['id_parroquia'];
        $id_estatus     = $datos['id_estatus'];
        $id_nivel       = $datos['id_nivel'];
        $id_profesion   = $datos['id_profesion'];

        $fech_naci = $this->formateaBD($fech_naci);

        $sql = "UPDATE representante
                    SET nacionalidad = '$nacionalidad',
                      nombre = '$nombre',
                      apellido = '$apellido',
                      email = '$email',
                      fech_naci = '$fech_naci',
                      lugar_naci = '$lugar_naci',
                      sexo = '$sexo',
                      calle = '$calle',
                      casa = '$casa',
                      edificio = '$edificio',
                      barrio = '$barrio',
                      antecedente = '$antecedente',
                      fuente_ingreso = '$fuente_ingreso',
                      cod_telefono = '$cod_telefono',
                      telefono = '$telefono',
                      cod_celular = '$cod_celular',
                      celular = '$celular',
                      id_parroquia = '$id_parroquia',
                      id_estatus = '$id_estatus',
                      id_nivel = '$id_nivel',
                      id_profesion = '$id_profesion'
                    WHERE cedula = '$cedula';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function delete($datos)
    {

        $dat_cedula = explode('-', $datos['cedula']);
        $cedula     = $dat_cedula[1];

        $sql = "UPDATE representante SET  condicion = 0 WHERE cedula = $cedula;";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function estatusRep($where = 1)
    {
        $where = ' WHERE ' . $where;
        $sql   = "SELECT  id_estatus,  nombre FROM estatus_representante" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function nivelInst($where = 1)
    {
        $where = ' WHERE ' . $where;
        $sql   = "SELECT  id_nivel,  nombre_nivel FROM nivel_academico" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function Profesion($where = 1)
    {
        $where = ' WHERE ' . $where;
        $sql   = "SELECT  id_profesion,  nombre_profesion FROM profesion" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function getRepresentantes($opciones = array())
    {

        if (!isset($opciones['sql'])) {
            $default    = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
            $opciones   = array_merge($default, $opciones);
            $this->_sql = "SELECT {$opciones['campos']} FROM representante WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']}";
        } else {
            $this->_sql = $opciones['sql'];
        }
        $resultado = $this->consultar_array($this->_sql);
        return $resultado;
    }

}
