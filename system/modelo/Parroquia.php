<?php

$path = dirname(__FILE__);
require_once "$path/Municipio.php";

class Parroquia extends Municipio
{

    public function __construct()
    {
        
    }

    public function add($datos)
    {
       
        $nombre_parroquia = $datos['nombre_parroquia'];
        $id_municipio     = $datos['id_municipio'];
        $id_parroquia     = $datos['id_parroquia'];
        $id_estado     = $datos['id_estado'];
        $sql_exis = "SELECT COUNT(p.id_parroquia) as total FROM parroquia AS p
                     INNER JOIN municipio AS m ON p.id_municipio=m.id_municipio
                     WHERE p.nombre_parroquia = '$nombre_parroquia' 
                     AND p.id_municipio=$id_municipio 
                     AND m.id_estado=$id_estado";
        
        $result = $this->consultar_array($sql_exis);
        $total  = $result[0]['total'];
        if ($total > 0) {
            $resultado = 13;
        } else {
            $sql = "INSERT INTO parroquia(id_parroquia ,nombre_parroquia, id_municipio)VALUES ($id_parroquia ,'$nombre_parroquia',$id_municipio);";
            $resultado = $this->ejecutar($sql);
            if($resultado){
                $resultado = 1;
            }
        }
        return $resultado;
    }

    public function update($datos)
    {
        $id_parroquia     = $datos['id_parroquia'];
        $nombre_parroquia = $datos['nombre_parroquia'];
        $id_municipio     = $datos['id_municipio'];

        $sql = "UPDATE parroquia SET  nombre_parroquia = '$nombre_parroquia',   id_municipio = $id_municipio WHERE id_parroquia = '$id_parroquia';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function delete($datos)
    {

        $id_parroquia = $datos['id_parroquia'];

        $sql = "DELETE FROM parroquia WHERE id_parroquia = '$id_parroquia';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function getParroquia($opciones)
    {

        if (empty($opciones['sql'])) {
            $default  = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
            $opciones = array_merge($default, $opciones);
            $sql      = "SELECT {$opciones['campos']} FROM parroquia p WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        } else {
            $sql = $opciones['sql'];
        }

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
