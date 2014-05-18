<?php

$path = dirname(__FILE__);
require_once "$path/Estado.php";

class Municipio extends Estado
{

    public function __construct()
    {
        
    }
    
     public function add($datos)
    {

        $nombre_municipio = $datos['nombre_municipio'];
        $id_estado     = $datos['id_estado'];
        $id_municipio     = $datos['id_municipio'];
        
//        $condicion     = "nombre_municipio='$nombre_municipio' && id_estado='$id_estado'";
        $condicion     = "nombre_municipio='$nombre_municipio AND id_estado= $id_estado'";
        $total         = $this->totalFilas('municipio', 'nombre_municipio', $condicion);
        if ($total > 0) {
            $resultado = 13;
        } else {
            $sql = "INSERT INTO municipio(id_municipio,nombre_municipio, id_estado)VALUES ($id_municipio,'$nombre_municipio', $id_estado);";

            $resultado = $this->ejecutar($sql);
            if($resultado){
                $resultado = 1;
            }
        }
        return $resultado;
    }

    public function update($datos)
    {

        $nombre_municipio = $datos['nombre_municipio'];
        $id_estado        = $datos['id_estado'];
        $id_municipio     = $datos['id_municipio'];

        $sql = "UPDATE municipio SET  nombre_municipio = '$nombre_municipio',  id_estado = $id_estado WHERE id_municipio = $id_municipio;";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function delete($datos)
    {

        $id_municipio = $datos['id_municipio'];

        $sql = "DELETE FROM municipio WHERE id_municipio = '$id_municipio';";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

    public function getMunicipio($opciones)
    {

        if (empty($opciones['sql'])) {
            $default  = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
            $opciones = array_merge($default, $opciones);
            $sql      = "SELECT {$opciones['campos']} FROM municipio m WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        } else {
            $sql = $opciones['sql'];
        }

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

}
