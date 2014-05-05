<?php

$path = dirname(__FILE__);
require_once "$path/Preinscripcion.php";

class Inscripcion extends Preinscripcion
{

    public function __construct()
    {
        
    }

    public function add($datos)
    {
        $dat                  = explode('-', $datos['cedula_estudiante']);
        $cedula               = $dat[1];
        $id_anio              = $datos['id_anio'];
        $id_actividad         = $datos['id_actividad'];
        $area                 = $datos['area'];
        $cedula_representante = $datos['cedula_representante'];
        $id_medio             = $datos['id_medio'];
        $cedula_chofer        = $datos['cedula_chofer'];
        $id_tipo              = $datos['id_tipo'];

        $sql_del       = "DELETE FROM inscripcion WHERE cedula_estudiante = $cedula";
        $resultado_del = $this->ejecutar($sql_del);
        if ($resultado_del) {
            $sql       = "INSERT INTO inscripcion(cedula_estudiante,fecha_inscripcion,id_anio,id_actividad,area_descripcion,cedula_representante,id_medio,cedula_chofer)
                    VALUES ($cedula,CURRENT_DATE,$id_anio,$id_actividad,'$area',$cedula_representante,$id_medio,$cedula_chofer);";
            $resultado = $this->ejecutar($sql);

            if ($resultado) {
                $sql1       = "INSERT INTO historial_inscripcion(cedula_estudiante,fecha_inscripcion,id_anio,id_actividad,area_descripcion,cedula_representante,id_medio,cedula_chofer)
                    VALUES ($cedula,CURRENT_DATE,$id_anio,$id_actividad,'$area',$cedula_representante,$id_medio,$cedula_chofer);";
                $resultado1 = $this->ejecutar($sql1);
                
                $sql_update = "UPDATE estudiante SET  id_estatus = 3 WHERE cedula = $cedula;";
                $result_up = $this->ejecutar($sql_update);
                if($result_up){
                    $resultado = TRUE;
                }
            }
        }
        return $resultado;
    }

    public function tipoestudiante($where = 1)
    {
        $where = ' WHERE ' . $where;
        $sql   = " SELECT  id_tipo,  tipo_estudiatnte FROM tipo_estudiante" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function anioescolar($where = 1)
    {
        $where = ' WHERE ' . $where;
        $sql   = " SELECT  id_anio,  anio_escolar FROM anio_escolar" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function actividad($where = 1)
    {
        $where = ' WHERE ' . $where;
        $sql   = " SELECT  id_actividad,  actividad FROM actividad" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function getDatos($datos)
    {

        $cedula      = explode('-', $datos['cedula_estudiante']);
        $hay         = $this->get('inscripcion', 'COUNT(cedula_estudiante)', "cedula_estudiante=$cedula[1]");
        $tipo        = 'Ingreso';
        $id_tipo     = 1;
        $result_anio = 0;
        $dat_extra   = 0;
        if ($hay == 1) {
            $tiempo = $this->get('inscripcion', '(YEAR(CURDATE())-YEAR(fecha_inscripcion)) - (RIGHT(CURDATE(),5)<RIGHT(fecha_inscripcion,5)) AS tiempo', "cedula_estudiante=$cedula[1]");
            $result_anio = $this->get('inscripcion AS i', 'IF(i.id_anio=(SELECT id_anio FROM anio_escolar ORDER BY id_anio DESC LIMIT 1),1,0) AS id_anio', "cedula_estudiante=$cedula[1]");
            if ($tiempo <= 1) {
                $tipo    = 'Regular';
                $id_tipo = 2;
            } else {
                $tipo    = 'Reintegro';
                $id_tipo = 3;
            }
            if (isset($result_anio) && $result_anio == 1) {
                
                $datos['sql'] = "SELECT DATE_FORMAT(fecha_inscripcion,'%d-%m-%Y') AS fecha_inscripcion,id_anio,id_actividad,area_descripcion,id_medio,cedula_chofer FROM inscripcion WHERE cedula_estudiante=$cedula[1]";
                $result_dat    = $this->datos($datos);
                if(is_array($result_dat)){
                   $dat_extra = $result_dat[0]['fecha_inscripcion'].';'.$result_dat[0]['id_anio'].';'.$result_dat[0]['id_actividad'].';'.$result_dat[0]['area_descripcion'].';'.$result_dat[0]['id_medio'].';'.$result_dat[0]['cedula_chofer'];
                }
                
            }
        }
        $datos['sql'] = "SELECT 
                                r.cedula,
                                r.nombre,
                                r.apellido,
                                er.parentesco
                            FROM representante AS r
                            INNER JOIN estudiante_representante AS er ON r.cedula=er.cedula_representante
                            WHERE  er.cedula_estudiante=$cedula[1]";
        $resultado    = $this->datos($datos);
        
        switch ($resultado[0]['parentesco']) {
            case 1:
                $parentesco = 'Madre';
            break;
            case 2:
                $parentesco = 'Padre';
            break;
            case 3:
                $parentesco = 'Abuela';
            break;
            case 4:
                $parentesco = 'Abuelo';
            break;
            case 5:
                $parentesco = 'Tia';
            break;
            case 6:
                $parentesco = 'Tio';
            break;
        }
        $representantes = $resultado[1]['parentesco'].';'.$resultado[2]['parentesco'];
        $datos = $result_anio.';'.$resultado[0]['cedula'] . ';' . $resultado[0]['nombre'] . ';' . $resultado[0]['apellido'] . ';'. $parentesco . ';'.$resultado[0]['parentesco'].';'  . $id_tipo . ';' . $tipo.';'.$dat_extra.';'.$representantes;
        return $datos;
    }
    
    public function addDG($datos)
    {
        $dt = $datos['dt'];
        $cedula = $datos['cedula_estudiante'];
        if($dt == 'dt0'){
            
            $sql_del    = "DELETE FROM dt_padres WHERE cedula_estudiante =$cedula";
            $result_del = $this->ejecutar($sql_del);
            $sql_insert = "INSERT INTO dt_padres(cedula_estudiante)VALUES ($cedula)";
            $result_insert = $this->ejecutar($sql_insert);

            if (isset($datos['representante_al'])) {
                $p_a = 0;
                $m_a = 0;
                $r_a = 0;
                $representante_a = $datos['representante_al'];

                foreach ($representante_a as $valores) {

                    if ($valores == 1) {
                        $p_a = 1;
                    }
                    if ($valores == 2) {
                        $m_a = 1;
                    }
                    if ($valores == 3) {
                        $r_a = 1;
                    }
  
                }
                $sql_al = "UPDATE dt_padres SET padre_al = $p_a,  madre_al = $m_a, represent_al = $r_a WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_al);
            }
            
            if (isset($datos['representante_fd'])) {
                $p_f = 0;
                $m_f = 0;
                $r_f = 0;
                $representante_f = $datos['representante_fd'];

                foreach ($representante_f as $valores) {

                    if ($valores == 1) {
                        $p_f = 1;
                    }
                    if ($valores == 2) {
                        $m_f = 1;
                    }
                    if ($valores == 3) {
                        $r_f = 1;
                    }
  
                }
                $sql_fd = "UPDATE dt_padres SET padre_fd = $p_f,  ,adre_fd = $m_f, represent_fd = $r_f WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_fd);
            }
 
            if (isset($datos['representante_a'])) {
                $p_a = 0;
                $m_a = 0;
                $r_a = 0;
                $representante_a = $datos['representante_a'];
                
                foreach ($representante_a as $valores) {

                    if ($valores == 'ps') {
                        $p_a = 1;
                    }
                    if ($valores == 'ms') {
                        $m_a = 1;
                    }
                    if ($valores == 'rs') {
                        $r_a = 1;
                    }
                }
                $sql_alf = "UPDATE dt_padres SET padre_alf = $p_a,  madre_alf = $m_a,  represent_alf = $r_a WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_alf);
            }
            
            if (isset($datos['padre_nivel'])) {
                $nivel = $datos['padre_nivel'];
                $sql_pn = "UPDATE dt_padres SET padre_nivel = $nivel WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_pn);
            }
            if (isset($datos['madre_nivel'])) {
                $nivel = $datos['madre_nivel'];
                $sql_mn = "UPDATE dt_padres SET madre_nivel = $nivel WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_mn);
            }
            if (isset($datos['representante_nivel'])) {
                $nivel = $datos['representante_nivel'];
                $sql_rn = "UPDATE dt_padres SET represent_nivel = $nivel WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_rn);
            }
            
            if (isset($datos['representante_set'])) {
                $p_s = 0;
                $m_s = 0;
                $representante_s = $datos['representante_set'];

                foreach ($representante_s as $valores) {

                    if ($valores == 1) {
                        $p_s = 1;
                    }
                    if ($valores == 2) {
                        $m_s = 1;
                    }
  
                }
                $sql_set = "UPDATE dt_padres SET padre_set = $p_s,  madre_set = $m_s WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_set);
            }

            if (isset($datos['representante_see'])) {
                $p_e = 0;
                $m_e = 0;
                $representante_e = $datos['representante_see'];

                foreach ($representante_e as $valores) {

                    if ($valores == 1) {
                        $p_e = 1;
                    }
                    if ($valores == 2) {
                        $m_e = 1;
                    }
  
                }
                $sql_see = "UPDATE dt_padres SET padre_see = $p_e,  madre_see = $m_e WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_see);
            }
            
            if (isset($datos['ingreso'])) {
                $sql_di     = "DELETE FROM ingreso_familiar WHERE cedula_estudiante =$cedula";
                $result_del = $this->ejecutar($sql_di);
                $ingreso    = $datos['ingreso'];
                foreach ($ingreso as $valores) {
                    $sql_ii = "INSERT INTO ingreso_familiar(cedula_estudiante,id_ingreso)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_ii);
                }
            }
        }else if($dt == 'dt1'){
            if(isset($datos['mision'])){
                $mision = $datos['mision'];
                $sql_dp = "DELETE FROM dt_programa_social WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_dp);
                foreach ($mision as $valores) {
                  $sql_pro = "INSERT INTO dt_programa_social(cedula_estudiante,id_programa)VALUES ($cedula,$valores);";  
                  $this->ejecutar($sql_pro);
                }
            }
            
        }else if($dt == 'dt2'){
            
            if(isset($datos['dtv']['tecnologia'])){
                $tecnologia = $datos['dtv']['tecnologia'];

                $sql_dt = "DELETE FROM dt_tecnologia WHERE cedula_estudiante = $cedula;";
                foreach ($tecnologia as $valores) {
                    $sql_it = "INSERT INTO dt_tecnologia(cedula_estudiante,id_tecnologia)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_it);
                }
            }
            $sql_v = "DELETE FROM dt_vivienda WHERE cedula_estudiante = $cedula;";
            $this->ejecutar($sql_v);
            unset($datos['dtv']['cedula']);
            unset($datos['dtv']['accion']);
            unset($datos['dtv']['dt']);
            unset($datos['dtv']['tecnologia']);
            $column = implode(',',(array_keys($datos['dtv'])));
            $values = implode(',',(array_values($datos['dtv'])));
            $sql_iv = "INSERT INTO dt_vivienda(cedula_estudiante,$column)VALUES($cedula,$values);";
            $this->ejecutar($sql_iv);
            
           
  
            
        }
    }
}
