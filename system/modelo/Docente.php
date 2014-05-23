<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Docente extends Seguridad
{

    public function __construct()
    {
        
    }

    public function add($datos)
    {

        $nacionalidad = $datos['nacionalidad'];
        $cedula       = $datos['cedula'];
        $nombre       = $datos['nombre'];
        $apellido     = $datos['apellido'];
        $email        = $datos['email'];
        $fech_naci    = $datos['fech_naci'];
        $lugar_naci   = $datos['lugar_naci'];
        $sexo         = $datos['sexo'];
        $calle        = $datos['calle'];
        $casa         = $datos['casa'];
        $edificio     = $datos['edificio'];
        $barrio       = $datos['barrio'];
        $cod_telefono = $datos['cod_telefono'];
        $telefono     = $datos['telefono'];
        $cod_celular  = $datos['cod_celular'];
        $celular      = $datos['celular'];
        $id_parroquia = $datos['id_parroquia'];
        $estatus      = $datos['estatus'];
        $id_actividad = $datos['id_actividad'];
        $fech_naci    = $this->formateaBD($fech_naci);

       $condicion     = "cedula = '$cedula' AND nacionalidad = $nacionalidad";
        $total     = $this->totalFilas('docente', 'cedula', $condicion);
        if ($total > 0) {
            $resultado = 13;
        } else {
            $sql = "INSERT INTO docente (nacionalidad, cedula, nombre, apellido, email, fech_naci, lugar_naci, sexo, calle, casa, edificio, barrio, cod_telefono,
                                     telefono, cod_celular, celular, id_parroquia, activo, id_actividad)
                             VALUES ('$nacionalidad', '$cedula', '$nombre', '$apellido', '$email', '$fech_naci', '$lugar_naci', '$sexo', '$calle', '$casa',
                                     '$edificio', '$barrio', '$cod_telefono', '$telefono', '$cod_celular', '$celular', '$id_parroquia', '$estatus', '$id_actividad' );";

            $resultado = $this->ejecutar($sql);
        }
        return $resultado;
    }

//    public function add($datos) {
//        $nacionalidad = $datos['nacionalidad'];
//        $cedula       = $datos['cedula'];
//        $nombre       = $datos['nombre'];
//        $apellido     = $datos['apellido'];
//        $email        = $datos['email'];
//        $fech_naci    = $datos['fech_naci'];
//        $lugar_naci   = $datos['lugar_naci'];
//        $sexo         = $datos['sexo'];
//        $calle        = $datos['calle'];
//        $casa         = $datos['casa'];
//        $edificio     = $datos['edificio'];
//        $barrio       = $datos['barrio'];
//        $cod_telefono = $datos['cod_telefono'];
//        $telefono     = $datos['telefono'];
//        $cod_celular  = $datos['cod_celular'];
//        $celular      = $datos['celular'];
//        $id_parroquia = $datos['id_parroquia'];
//        $estatus      = $datos['estatus'];
//        $id_actividad = $datos['id_actividad'];
//        $fech_naci = $this->formateaBD($fech_naci);
//
//        $sql = "INSERT INTO docente (nacionalidad, cedula, nombre, apellido, email, fech_naci, lugar_naci, sexo, calle, casa, edificio, barrio, cod_telefono,
//                                     telefono, cod_celular, celular, id_parroquia, activo, id_actividad)
//                             VALUES ('$nacionalidad', '$cedula', '$nombre', '$apellido', '$email', '$fech_naci', '$lugar_naci', '$sexo', '$calle', '$casa',
//                                     '$edificio', '$barrio', '$cod_telefono', '$telefono', '$cod_celular', '$celular', '$id_parroquia', '$estatus',
//                '$id_actividad' );";
//
//        $resultado = $this->ejecutar($sql);
//        return $resultado;
//    }

    public function update($datos)
    {

        $nacionalidad = $datos['nacionalidad'];
        $cedula       = $datos['cedula'];
        $nombre       = $datos['nombre'];
        $apellido     = $datos['apellido'];
        $email        = $datos['email'];
        $fech_naci    = $datos['fech_naci'];
        $lugar_naci   = $datos['lugar_naci'];
        $sexo         = $datos['sexo'];
        $calle        = $datos['calle'];
        $casa         = $datos['casa'];
        $edificio     = $datos['edificio'];
        $barrio       = $datos['barrio'];
        $cod_telefono = $datos['cod_telefono'];
        $telefono     = $datos['telefono'];
        $cod_celular  = $datos['cod_celular'];
        $celular      = $datos['celular'];
        $id_parroquia = $datos['id_parroquia'];
        $estatus      = $datos['estatus'];
        $id_actividad = $datos['id_actividad'];
        $fech_naci    = $this->formateaBD($fech_naci);

//        $cedula   = explode('-', $cedula);
//        $cedula       = $cedula[1];

        $sql = "UPDATE docente
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
                              cod_telefono = '$cod_telefono',
                              telefono = '$telefono',
                              cod_celular = '$cod_celular',
                              celular = '$celular',
                              id_parroquia = '$id_parroquia',
                              activo = '$estatus',
                              id_actividad = '$id_actividad'
                            WHERE cedula = '$cedula';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function estatusDoce($where = 1)
    {
        $where = ' WHERE ' . $where;
        $sql   = "SELECT  id_estatus,  nombre FROM estatus_docente" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function activi($where = 1)
    {
        $where = ' WHERE ' . $where;
        $sql   = "SELECT  id_actividad,  actividad  FROM actividad" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function getDocente($opciones)
    {
        if (!isset($opciones['sql'])) {
            $default  = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
            $opciones = array_merge($default, $opciones);
            $sql      = "SELECT {$opciones['campos']} FROM docente doc  WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        } else {
            $sql = $opciones['sql'];
        }
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
