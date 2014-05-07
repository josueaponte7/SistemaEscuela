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
    
    public function getInscritos()
    {
        $datos['sql'] = "SELECT
                         CONCAT_WS('-' ,(SELECT nombre FROM nacionalidad WHERE id_nacionalidad = e.nacionalidad),e.cedula) AS cedula,
                         CONCAT_WS(' ',e.nombre,e.apellido) AS nombre,
                         i.tipo,
                         (SELECT anio_escolar FROM anio_escolar WHERE id_anio=i.id_anio) AS anio,
                         (SELECT actividad FROM actividad WHERE id_actividad=i.id_actividad) AS actividad,
                         DATE_FORMAT(fecha_inscripcion,'%d-%m-%Y') AS fecha_inscripcion
                         FROM inscripcion AS i
                         INNER JOIN estudiante AS e ON i.cedula_estudiante=e.cedula";
        $resultado    = $this->datos($datos);
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
                
                $datos['sql'] = "SELECT DATE_FORMAT(fecha_inscripcion,'%d-%m-%Y') AS fecha_inscripcion,tipo,id_anio,id_actividad,area_descripcion,id_medio,cedula_chofer FROM inscripcion WHERE cedula_estudiante=$cedula[1]";
                $result_dat    = $this->datos($datos);
                if(is_array($result_dat)){
                   $dat_extra        = $result_dat[0]['fecha_inscripcion'] . ';' . $result_dat[0]['tipo'] . ';' . $result_dat[0]['id_anio'] . ';' . $result_dat[0]['id_actividad'] . ';' . $result_dat[0]['area_descripcion'];
                   $medio_transporte = $result_dat[0]['id_medio'].';'.$result_dat[0]['cedula_chofer']; 
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
        
        
        $sql_dt['sql'] = "SELECT
                            padre_f,
                            madre_f,
                            padre_pl,
                            madre_pl,
                            padre_al,
                            madre_al,
                            represent_al,
                            padre_fd,
                            madre_fd,
                            represent_fd,
                            padre_alf,
                            madre_alf,
                            represent_alf,
                            padre_nivel,
                            madre_nivel,
                            represent_nivel,
                            padre_set,
                            madre_set,
                            padre_see,
                            madre_see
                          FROM dt_padres WHERE cedula_estudiante=$cedula[1]";
        $result_sql   = $this->datos($sql_dt);
        
        $representantes = $resultado[1]['parentesco'].';'.$resultado[2]['parentesco'];
        $representante  = $resultado[0]['cedula'] . ';' . $resultado[0]['nombre'] . ';' . $resultado[0]['apellido'] . ';'. $parentesco . ';'.$resultado[0]['parentesco'];
        
        $dtg_padre = $result_sql[0]['padre_f'].';'.
                    $result_sql[0]['madre_f'].';'.
                    $result_sql[0]['padre_pl'].';'.
                    $result_sql[0]['madre_pl'].';'.
                    $result_sql[0]['padre_al'].';'.
                    $result_sql[0]['madre_al'].';'.
                    $result_sql[0]['represent_al'].';'.
                    $result_sql[0]['padre_fd'].';'.
                    $result_sql[0]['madre_fd'].';'.
                    $result_sql[0]['represent_fd'].';'.
                    $result_sql[0]['padre_alf'].';'.
                    $result_sql[0]['madre_alf'].';'.
                    $result_sql[0]['represent_alf'].';'.
                    $result_sql[0]['padre_nivel'].';'.
                    $result_sql[0]['madre_nivel'].';'.
                    $result_sql[0]['represent_nivel'].';'.
                    $result_sql[0]['padre_set'].';'.
                    $result_sql[0]['padre_set'].';'.
                    $result_sql[0]['madre_see'].';'.
                    $result_sql[0]['madre_see'].';';
        
        
        $sql_dtgi['sql'] = "SELECT  id_ingreso FROM dt_ingreso_familiar WHERE cedula_estudiante=$cedula[1]";
        $result_sqli   = $this->datos($sql_dtgi);
        
        $dtg_ingreso = '';
        for ($i = 0; $i < count($result_sqli); $i++) {
            $dtg_ingreso .= $result_sqli[$i]['id_ingreso'].',';
        }
        $dtg_ingreso = substr($dtg_ingreso, 0, -1);
        
        
        $sql_dtgps['sql'] = "SELECT id_programa FROM dt_programa_social WHERE cedula_estudiante=$cedula[1]";
        $result_sqlps   = $this->datos($sql_dtgps);
        
        $dtg_pg = '';
        for ($i = 0; $i < count($result_sqlps); $i++) {
            $dtg_pg .= $result_sqlps[$i]['id_programa'].',';
        }
        $dtg_pg = substr($dtg_pg, 0, -1);
        
        $sql_dtgvi['sql'] = "SELECT  ubicacion_vivienda,  tipo_vivienda,  estado_vivienda,  cant_habitacion,  cama FROM dt_vivienda WHERE cedula_estudiante=$cedula[1]";
        $result_sqlv  = $this->datos($sql_dtgvi);
        
        $dtg_v = $result_sqlv[0]['ubicacion_vivienda'].';'.$result_sqlv[0]['tipo_vivienda'].';'.$result_sqlv[0]['estado_vivienda'].';'.$result_sqlv[0]['cant_habitacion'].';'.$result_sqlv[0]['cama'];
        
        $sql_dtgt['sql'] = "SELECT id_tecnologia FROM dt_tecnologia WHERE cedula_estudiante=$cedula[1]";
        $result_sqlt   = $this->datos($sql_dtgt);
        
        $dtg_t = '';
        for ($i = 0; $i < count($result_sqlt); $i++) {
            $dtg_t .= $result_sqlt[$i]['id_tecnologia'].',';
        }
        
        $dtg_t = substr($dtg_t, 0, -1);
        
        $sql_dtgd['sql'] = "SELECT id_diversidad FROM dt_diversidad_funcional WHERE cedula_estudiante=$cedula[1]";
        $result_sqld   = $this->datos($sql_dtgd);
        
        $dtg_d = '';
        for ($i = 0; $i < count($result_sqld); $i++) {
            $dtg_d .= $result_sqld[$i]['id_diversidad'].',';
        }
        
        $dtg_d = substr($dtg_d, 0, -1);
        
        $sql_dtge['sql'] = "SELECT  id_enfermedades FROM dt_enfermedad WHERE cedula_estudiante=$cedula[1]";
        $result_sqle   = $this->datos($sql_dtge);
        
        $dtg_e = '';
        for ($i = 0; $i < count($result_sqle); $i++) {
            $dtg_e .= $result_sqle[$i]['id_enfermedades'].',';
        }
        
        $dtg_e = substr($dtg_e, 0, -1);
        
        $sql_dtgs['sql'] = "SELECT id_servicio FROM dt_servicio WHERE cedula_estudiante=$cedula[1]";
        $result_sqls   = $this->datos($sql_dtgs);
        
        $dtg_s = '';
        for ($i = 0; $i < count($result_sqls); $i++) {
            $dtg_s .= $result_sqls[$i]['id_servicio'].',';
        }
        
        $dtg_s = substr($dtg_s, 0, -1);

        $sql_dtgdz['sql'] = "SELECT id_destreza FROM dt_destreza WHERE cedula_estudiante=$cedula[1]";
        $result_sqldz   = $this->datos($sql_dtgdz);
        
        $dtg_dz = '';
        for ($i = 0; $i < count($result_sqldz); $i++) {
            $dtg_dz .= $result_sqldz[$i]['id_destreza'].',';
        }
        
        $dtg_dz = substr($dtg_dz, 0, -1);
        
        
        $sql_dtga['sql'] = "SELECT id_acceso, id_regular FROM dt_alimentacion WHERE cedula_estudiante=$cedula[1]";
        $result_sqla  = $this->datos($sql_dtga);
        
        $dtg_a = $result_sqla[0]['id_acceso'].';'.$result_sqla[0]['id_regular'];
        
        $sql_dtgay['sql'] = "SELECT id_ayuda FROM dt_ayuda WHERE cedula_estudiante=$cedula[1]";
        $result_sqlay   = $this->datos($sql_dtgay);
        
        $dtg_ay = '';
        for ($i = 0; $i < count($result_sqlay); $i++) {
            $dtg_ay .= $result_sqlay[$i]['id_ayuda'].',';
        }
        
        $dtg_ay = substr($dtg_ay, 0, -1);
        
        
        $datos = $result_anio.';'.$dat_extra.'##'.$representante.'##'.$medio_transporte.'##'.$representantes.'##'.$dtg_padre.'##'.$dtg_ingreso.'##'.$dtg_pg.'##'.$dtg_v.'##'.$dtg_t.'##'.$dtg_d.'##'.$dtg_e.'##'.$dtg_s.'##'.$dtg_dz.'##'.$dtg_a.'##'.$dtg_ay;
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
                $sql_fd = "UPDATE dt_padres SET padre_fd = $p_f, adre_fd = $m_f, represent_fd = $r_f WHERE cedula_estudiante = $cedula;";
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
                $sql_di     = "DELETE FROM dt_ingreso_familiar WHERE cedula_estudiante =$cedula";
                $result_del = $this->ejecutar($sql_di);
                $ingreso    = $datos['ingreso'];
                foreach ($ingreso as $valores) {
                    $sql_ii = "INSERT INTO dt_ingreso_familiar(cedula_estudiante,id_ingreso)VALUES ($cedula,$valores);";
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
                $this->ejecutar($sql_dt);
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

        }else if($dt == 'dt3'){

            if(isset($datos['dtdf']['diversidad'])){
                $sql_ddf = "DELETE FROM dt_diversidad_funcional WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_ddf);
                $diversidad = $datos['dtdf']['diversidad'];
                foreach ($diversidad as $valores) {
                    $sql_idf = "INSERT INTO dt_diversidad_funcional(cedula_estudiante,id_diversidad)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_idf);
                }
            }
            
            if(isset($datos['dtdf']['enfermedad'])){
                $sql_de = "DELETE FROM dt_enfermedad WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_de);
                $diversidad = $datos['dtdf']['enfermedad'];
                foreach ($diversidad as $valores) {
                    $sql_ide = "INSERT INTO dt_enfermedad(cedula_estudiante,id_enfermedades)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_ide);
                }
            }
            
            if(isset($datos['dtdf']['servicio'])){
                $sql_dd = "DELETE FROM dt_servicio WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_dd);
                $diversidad = $datos['dtdf']['servicio'];
                foreach ($diversidad as $valores) {
                    $sql_idd = "INSERT INTO dt_servicio(cedula_estudiante,id_servicio)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_idd);
                }
            }
            
            if(isset($datos['dtdf']['destreza'])){
                $sql_dd = "DELETE FROM dt_destreza WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_dd);
                $diversidad = $datos['dtdf']['destreza'];
                foreach ($diversidad as $valores) {
                    $sql_idd = "INSERT INTO dt_destreza(cedula_estudiante,id_destreza)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_idd);
                }
            }

            if(isset($datos['dtdf']['alimentacion']) || $datos['dtdf']['alimentacion_regular']){
                $alimentacion   = 0;
                $alimentacion_r = 0;
                
                $sql_da = "DELETE FROM dt_alimentacion WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_da);
                if(isset($datos['dtdf']['alimentacion'])){
                    $alimentacion = $datos['dtdf']['alimentacion'];
                }
                if(isset($datos['dtdf']['alimentacion_regular'])){
                    $alimentacion_r = $datos['dtdf']['alimentacion_regular'];
                }
                $sql_ida = "INSERT INTO dt_alimentacion(cedula_estudiante,id_acceso,id_regular)VALUES ($cedula,$alimentacion,$alimentacion_r);";
                $this->ejecutar($sql_ida);
            }
            
            if(isset($datos['dtdf']['ayuda'])){
                $sql_de = "DELETE FROM dt_ayuda WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_de);
                $diversidad = $datos['dtdf']['ayuda'];
                foreach ($diversidad as $valores) {
                    $sql_ide = "INSERT INTO dt_ayuda(cedula_estudiante,id_ayuda)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_ide);
                }
            }
        }
    }
}
