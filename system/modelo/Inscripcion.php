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
        $tipo                 = $datos['tipo_estudiante'];

        $sql_del       = "DELETE FROM inscripcion WHERE cedula_estudiante = $cedula";
        $resultado_del = $this->ejecutar($sql_del);

        if ($resultado_del) {
            $sql       = "INSERT INTO inscripcion(cedula_estudiante,fecha_inscripcion,id_anio,id_actividad,area_descripcion,cedula_representante,id_medio,tipo,cedula_chofer)
                    VALUES ($cedula,CURRENT_DATE,$id_anio,$id_actividad,'$area',$cedula_representante,$id_medio,'$tipo',$cedula_chofer);";
            $resultado = $this->ejecutar($sql);

            if ($resultado) {
                $sql1       = "INSERT INTO historial_inscripcion(cedula_estudiante,fecha_inscripcion,id_anio,id_actividad,area_descripcion,cedula_representante,id_medio,cedula_chofer)
                    VALUES ($cedula,CURRENT_DATE,$id_anio,$id_actividad,'$area',$cedula_representante,$id_medio,$cedula_chofer);";
                $resultado1 = $this->ejecutar($sql1);

                $sql_update = "UPDATE estudiante SET  id_estatus = 3 WHERE cedula = $cedula;";
                $result_up  = $this->ejecutar($sql_update);
                if ($result_up) {
                    $resultado = TRUE;
                }
            }
        }
        return $resultado;
    }

    public function update($datos)
    {
        $dat_ced       = explode('-', $datos['cedula_estudiante']);
        $cedula        = $dat_ced[1];
        $actividad     = $datos['id_actividad'];
        $area          = $datos['area'];
        $medio         = $datos['id_medio'];
        $cedula_chofer = $datos['cedula_chofer'];
        $sql_update    = "UPDATE inscripcion SET 
                        id_actividad     = $actividad,
                        area_descripcion = '$area',
                        id_medio         = $medio,
                        cedula_chofer    = $cedula_chofer
                      WHERE cedula_estudiante = $cedula;";
        $result_up     = $this->ejecutar($sql_update);
        if ($result_up) {
            $resultado = TRUE;
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

        $cedula            = explode('-', $datos['cedula_estudiante']);
        $inscrito          = $this->get('inscripcion', 'COUNT(cedula_estudiante)', "cedula_estudiante=$cedula[1]");
        $tipo_estudiante   = 'Regular';
        $datos_inscripcion = "";
        $anio_es_v         = 'i';
        $datos_trasporte   = '';
        if ($inscrito == 1) {

            $sql['sql'] = "SELECT 
                                    IF(id_anio=(SELECT id_anio FROM anio_escolar ORDER BY id_anio DESC LIMIT 1),'i','v') AS anio_escolar
                                 FROM inscripcion WHERE cedula_estudiante = $cedula[1]";
            $result     = $this->datos($sql);
            $anio_es_v  = $result[0]['anio_escolar'];

            if ($anio_es_v == 'v') {
                $tipo_estudiante = 'Reintegro';
            } else {
                $sql['sql'] = "SELECT 
                                DATE_FORMAT(i.fecha_inscripcion,'%d-%m-%Y') AS fecha_inscripcion,
                                i.id_anio,
                                (SELECT anio_escolar FROM anio_escolar WHERE id_anio=i.id_anio) AS anio_escolar,
                                i.id_actividad,
                                i.area_descripcion,
                                i.id_medio,
                                i.cedula_chofer
                               FROM inscripcion AS i 
                               INNER JOIN chofer AS c ON i.cedula_chofer=c.cedula
                               WHERE cedula_estudiante=$cedula[1]";

                $result            = $this->datos($sql);
                $fecha_inscripcion = $result[0]['fecha_inscripcion'];
                $id_anio           = $result[0]['id_anio'];
                $anio_escolar      = $result[0]['anio_escolar'];
                $id_actividad      = $result[0]['id_actividad'];
                $area_descripcion  = $result[0]['area_descripcion'];
                $id_medio          = $result[0]['id_medio'];
                $cedula_chofer     = $result[0]['cedula_chofer'];
                $datos_inscripcion = $fecha_inscripcion . ';' . $id_anio . ';' . $anio_escolar . ';' . $id_actividad . ';' . $area_descripcion;
                $datos_trasporte   = $id_medio . ';' . $cedula_chofer;
            }
        } else {
            $tipo_estudiante   = 'Ingreso';
            $datos_inscripcion = "";
            $anio_es_v         = 'n';
            $fecha_inscripcion = '';
            $id_anio           = '';
            $anio_escolar      = '';
            $id_actividad      = '';
            $area_descripcion  = '';
            $id_medio          = '';
            $cedula_chofer     = '';
            $datos_inscripcion = $fecha_inscripcion . ';' . $id_anio . ';' . $anio_escolar . ';' . $id_actividad . ';' . $area_descripcion;
        }

        $sql_re['sql'] = "SELECT 
                                CONCAT_WS('-',(SELECT nombre FROM nacionalidad WHERE id_nacionalidad=r.nacionalidad),r.cedula) AS cedula,
                                r.nombre,
                                r.apellido,
                                er.parentesco
                               FROM estudiante_representante er
                               INNER JOIN representante  AS r ON er.cedula_representante=r.cedula
                               WHERE er.representante = 1 AND cedula_estudiante=$cedula[1]";

        $result_rep = $this->datos($sql_re);
        switch ($result_rep[0]['parentesco']) {
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
        $datos_repre = $result_rep[0]['cedula'] . ';' . $result_rep[0]['nombre'] . ';' . $result_rep[0]['apellido'] . ';' . $parentesco;
        $datos       = $anio_es_v . ';' . $inscrito . ';' . $tipo_estudiante . ';' . $datos_inscripcion . ';' . $datos_repre . ';' . $datos_trasporte;
        return $datos;
    }

    public function addDG($datos)
    {


        if (isset($datos['dt_padres'])) { // Guardar Primer paso
            foreach ($datos['dt_padres'] as $id => $value) {
                $fields[] = $id;
                if (is_array($value) && !empty($value[0])) {
                    $values[] = $value[0];
                } else {
                    $values[] = "'" . $value . "'";
                }
            }

            $campos            = implode(',', $fields);
            $valores           = implode(',', $values);
            $cedula            = $datos['dt_padres']['cedula_estudiante'];
            $sql_del_dt_padres = "DELETE FROM dt_padres WHERE cedula_estudiante = $cedula;";
            $result_del        = $this->ejecutar($sql_del_dt_padres);

            $sql_insert_dt_padres = "INSERT INTO dt_padres($campos)VALUES ($valores)";
            $result_insert        = $this->ejecutar($sql_insert_dt_padres);

            $valores = '';
            $values  = '';
            if (isset($datos['id_ingreso'])) {
                $cedula = $datos['id_ingreso']['cedula_estudiante'];
                unset($datos['id_ingreso']['cedula_estudiante']);
                foreach ($datos['id_ingreso'] as $id => $value) {
                    $values .= "($cedula,$value),";
                }
                $valores    = substr($values, 0, -1);
                $sql_di     = "DELETE FROM dt_ingreso_familiar WHERE cedula_estudiante =$cedula";
                $result_del = $this->ejecutar($sql_di);
                $sql_ii     = "INSERT INTO dt_ingreso_familiar(cedula_estudiante,id_ingreso)VALUES $valores;";
                $this->ejecutar($sql_ii);
            }
        } else if (isset($datos['dt_mision'])) { // Guardar Segundo paso
            $cedula = $datos['cedula_estudiante'];

            if (isset($datos['mision'])) {
                $mision = $datos['mision'];
                $sql_dp = "DELETE FROM dt_programa_social WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_dp);
                foreach ($mision as $valores) {
                    $sql_pro = "INSERT INTO dt_programa_social(cedula_estudiante,id_programa)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_pro);
                }
            }
        } else if (isset($datos['dt_vivienda'])) {

            $tecnologia = $datos['dt_vivienda']['tecnologia'];
            unset($datos['dt_vivienda']['tecnologia']);

            foreach ($datos['dt_vivienda'] as $id => $value) {
                $fields[] = $id;
                if (is_array($value) && !empty($value[0])) {
                    $values[] = $value[0];
                } else {
                    $values[] = "'" . $value . "'";
                }
            }

            $campos       = implode(',', $fields) . "\n";
            $valores      = implode(',', $values);
            $sql_vivienda = "INSERT INTO dt_vivienda({$campos})VALUES ({$valores});";
            $this->ejecutar($sql_vivienda);

            $cedula = $datos['dt_vivienda']['cedula_estudiante'];
            if (isset($tecnologia)) {
                foreach ($tecnologia as $valores) {
                    $sql_tec = "INSERT INTO dt_tecnologia(cedula_estudiante,id_tecnologia)VALUES($cedula,$valores);";
                    $this->ejecutar($sql_tec);
                }
            }
        } else if ($dt == 'dt3') {


            if (isset($datos['dtdf']['diversidad'])) {
                $sql_ddf    = "DELETE FROM dt_diversidad_funcional WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_ddf);
                $diversidad = $datos['dtdf']['diversidad'];
                foreach ($diversidad as $valores) {
                    $sql_idf = "INSERT INTO dt_diversidad_funcional(cedula_estudiante,id_diversidad)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_idf);
                }
            }

            if (isset($datos['dtdf']['enfermedad'])) {
                $sql_de     = "DELETE FROM dt_enfermedad WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_de);
                $diversidad = $datos['dtdf']['enfermedad'];
                foreach ($diversidad as $valores) {
                    $sql_ide = "INSERT INTO dt_enfermedad(cedula_estudiante,id_enfermedades)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_ide);
                }
            }

            if (isset($datos['dtdf']['servicio'])) {
                $sql_dd     = "DELETE FROM dt_servicio WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_dd);
                $diversidad = $datos['dtdf']['servicio'];
                foreach ($diversidad as $valores) {
                    $sql_idd = "INSERT INTO dt_servicio(cedula_estudiante,id_servicio)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_idd);
                }
            }

            if (isset($datos['dtdf']['destreza'])) {
                $sql_dd     = "DELETE FROM dt_destreza WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_dd);
                $diversidad = $datos['dtdf']['destreza'];
                foreach ($diversidad as $valores) {
                    $sql_idd = "INSERT INTO dt_destreza(cedula_estudiante,id_destreza)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_idd);
                }
            }

            if (isset($datos['dtdf']['alimentacion']) || $datos['dtdf']['alimentacion_regular']) {
                $alimentacion   = 0;
                $alimentacion_r = 0;

                $sql_da = "DELETE FROM dt_alimentacion WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_da);
                if (isset($datos['dtdf']['alimentacion'])) {
                    $alimentacion = $datos['dtdf']['alimentacion'];
                }
                if (isset($datos['dtdf']['alimentacion_regular'])) {
                    $alimentacion_r = $datos['dtdf']['alimentacion_regular'];
                }
                $sql_ida = "INSERT INTO dt_alimentacion(cedula_estudiante,id_acceso,id_regular)VALUES ($cedula,$alimentacion,$alimentacion_r);";
                $this->ejecutar($sql_ida);
            }

            if (isset($datos['dtdf']['ayuda'])) {
                $sql_de     = "DELETE FROM dt_ayuda WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_de);
                $diversidad = $datos['dtdf']['ayuda'];
                foreach ($diversidad as $valores) {
                    $sql_ide = "INSERT INTO dt_ayuda(cedula_estudiante,id_ayuda)VALUES ($cedula,$valores);";
                    $this->ejecutar($sql_ide);
                }
            }
        }
    }

    public function searchDG($datos)
    {
        $cedula        = $datos['cedula_estudiante'];
        $sql_re['sql'] = "SELECT * FROM dt_padres WHERE cedula_estudiante=$cedula";
        $total = $this->numero_filas($sql_re['sql']);
        $datos = $total;
        if ($total > 0) {
            $result_rep   = $this->datos($sql_re);
            $padres_f     = $result_rep[0]['padre_f'] . ';' . $result_rep[0]['madre_f'];
            $padres_pl    = $result_rep[0]['padre_pl'] . ';' . $result_rep[0]['madre_pl'];
            $padres_al    = $result_rep[0]['padre_al'] . ';' . $result_rep[0]['madre_al'] . ';' . $result_rep[0]['represent_al'];
            $padres_fd    = $result_rep[0]['padre_fd'] . ';' . $result_rep[0]['madre_fd'] . ';' . $result_rep[0]['represent_al'];
            $padres_alf   = $result_rep[0]['padre_alf'] . ';' . $result_rep[0]['madre_alf'] . ';' . $result_rep[0]['represent_alf'];
            $padres_nivel = $result_rep[0]['padre_nivel'] . ';' . $result_rep[0]['madre_nivel'] . ';' . $result_rep[0]['represent_nivel'];
            $padres_set   = $result_rep[0]['padre_set'] . ';' . $result_rep[0]['madre_set'];
            $padres_see   = $result_rep[0]['padre_see'] . ';' . $result_rep[0]['madre_see'];
            
            $sql_re['sql'] = "SELECT id_ingreso FROM dt_ingreso_familiar WHERE cedula_estudiante=$cedula";
            
            $result_if  = $this->datos($sql_re);

            $total_if   = $this->numero_filas($sql_re['sql']);
            $datos_in   = "";
            if($total_if > 0){
                
                for ($i = 0; $i < count($result_if); $i++) {
                    $datos_in .= $result_if[$i]['id_ingreso'].",";
                }
                $datos_in = substr($datos_in, 0, -1);
            }
            $datos_rep = $padres_f . ';' . $padres_pl . ';' . $padres_al . ';' . $padres_fd . ';' . $padres_alf . ';' . $padres_nivel . ';' . $padres_set . ';' . $padres_see;
            $datos = $datos_rep.';'.$datos_in;
        }

        echo $datos;
    }

}
