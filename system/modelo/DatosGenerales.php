<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class DatosGenerales extends Seguridad {
    
    public function __construct() {
       
    }
    
    public function add($datos){        
        
    }      
    
    public function misiones($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_programa,  nombre_programa FROM programa_social" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function concepIngreso($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT id_ingreso,tipo_ingreso FROM concepto_ingreso" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function ubicacion($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_ubicacion,  ubicacion FROM ubicacion_vivienda" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function tipoVivienda($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_tipo,  tipo_vivienda FROM tipo_vivienda" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function estadoVivienda($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_estado,  estado_vivienda FROM estado_vivienda" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function cama($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_cama,  cama FROM tipo_cama" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function tecnologia($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " select  id_tecnologia,  nombre_tecnologia from tecnologia" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function diversidad($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_diversidad,  tipo_diversidad FROM diversidad_funcional" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function enfermedad($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_enfermedad,  enfermedad FROM enfermedades" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function servicio($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_tiposervicio,  tiposervicio FROM tiposervicio" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function destreza($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_destreza,  tipo_destreza FROM destrezas_habilidades" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
     public function accesoAlim($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_acceso,  tipo_acceso FROM acceso_alimentacion" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    public function alimRegular($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " SELECT  id_regular,  tipo_regular FROM alimentacion_regular" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
     public function ameritaAyu($where = 1)
    {
        $where = ' WHERE ' . $where;       
        $sql   = " select  id_ayuda,  tipo_ayuda from amerita_ayuda" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
}

