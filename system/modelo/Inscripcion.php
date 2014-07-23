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
        $cedula = $datos['cedula_estudiante'];

        $id_anio              = $datos['id_anio'];
        $id_actividad         = $datos['id_actividad'];
        $area                 = $datos['area'];
        $cedula_representante = $datos['cedula_representante'];
        $id_medio             = $datos['id_medio'];
        
        $cedula_chofer = "";
        if(isset($datos['cedula_chofer'])){
          $cedula_chofer        = $datos['cedula_chofer'];   
        }
       
        //$id_tipo              = $datos['id_tipo'];
        $tipo                 = $datos['tipo_estudiante'];
        
        
        
        $cedula_representante = substr($cedula_representante, 2);
        
        $sql_del       = "DELETE FROM inscripcion WHERE cedula_estudiante = $cedula";
        $resultado_del = $this->ejecutar($sql_del);

        if ($resultado_del) {
            echo $sql       = "INSERT INTO inscripcion(cedula_estudiante,fecha_inscripcion,id_anio,id_actividad,area_descripcion,cedula_representante,id_medio,tipo,cedula_chofer)
                    VALUES ($cedula,CURRENT_DATE,$id_anio,$id_actividad,'$area',$cedula_representante,$id_medio,'$tipo','$cedula_chofer');";
            exit;$resultado = $this->ejecutar($sql);

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
                               WHERE i.cedula_estudiante=$cedula[1]";

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
            if($result_insert){
                $sql = "UPDATE inscripcion SET paso1 = 1 WHERE cedula_estudiante = '$cedula';";
                $result_del = $this->ejecutar($sql);
                echo 1;
            }
        } else if (isset($datos['dt_mision'])) { // Guardar Segundo paso
            $cedula = $datos['cedula_estudiante'];

            if (isset($datos['mision'])) {
                $mision = $datos['mision'];
                $sql_dp = "DELETE FROM dt_programa_social WHERE cedula_estudiante = $cedula;";
                $this->ejecutar($sql_dp);
                $valor_program = 0;
                foreach ($mision as $valores) {
                    $sql_pro = "INSERT INTO dt_programa_social(cedula_estudiante,id_programa)VALUES ($cedula,$valores);";
                    $resul = $this->ejecutar($sql_pro);
                    if(!$resul){
                        $sql_dp = "DELETE FROM dt_programa_social WHERE cedula_estudiante = $cedula;";
                        $this->ejecutar($sql_dp);
                        break;
                        
                    }else{
                        $valor_program = 1;
                    }
                }
                if($valor_program ==1){
                    $sql = "UPDATE inscripcion SET paso2 = 1 WHERE cedula_estudiante = '$cedula';";
                    $result_del = $this->ejecutar($sql);
                    echo 1;
                }
            }
        } else if (isset($datos['dt_vivienda'])) {
            
            $cedula            = $datos['dt_vivienda']['cedula_estudiante'];
            
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

            $campos       = implode(',', $fields);
            $valores      = implode(',', $values);
            
            $sql_dv = "DELETE FROM dt_vivienda WHERE cedula_estudiante = $cedula;";
            $this->ejecutar($sql_dv);
            
            $sql_vivienda = "INSERT INTO dt_vivienda({$campos})VALUES ({$valores});";
            $resul_vi = $this->ejecutar($sql_vivienda);
            
            $sql_dtec = "DELETE FROM dt_tecnologia WHERE cedula_estudiante = $cedula;";
            $this->ejecutar($sql_dtec);
            
            if (isset($tecnologia)) {
                foreach ($tecnologia as $valores) {
                    $sql_tec = "INSERT INTO dt_tecnologia(cedula_estudiante,id_tecnologia)VALUES($cedula,$valores);";
                    $this->ejecutar($sql_tec);
                }
            }
            
            if($resul_vi){
                $sql_p3 = "UPDATE inscripcion SET paso3 = 1 WHERE cedula_estudiante = '$cedula';";
                $result_del = $this->ejecutar($sql_p3);
                echo 1;
            }
            
        } else if (isset($datos['dt_diversidad'])) {
            
            $cedula = $datos['dt_diversidad']['cedula_estudiante'];
            
            if(isset($datos['dt_diversidad']['diversidad'])){
                 $diversidad = $datos['dt_diversidad']['diversidad'];
                unset($datos['dt_diversidad']['diversidad']);
            }
           
            if(isset($datos['dt_diversidad']['enfermedad'])){
                $enfermedad = $datos['dt_diversidad']['enfermedad'];
                unset($datos['dt_diversidad']['enfermedad']);
            }
            
            if(isset($datos['dt_diversidad']['servicio'])){
                $servicio = $datos['dt_diversidad']['servicio'];
                unset($datos['dt_diversidad']['servicio']);
            }
            
            if(isset($datos['dt_diversidad']['destreza'])){
                $destreza = $datos['dt_diversidad']['destreza'];
                unset($datos['dt_diversidad']['destreza']);
            }
            
            if(isset($datos['dt_diversidad']['ayuda'])){
                $ayuda = $datos['dt_diversidad']['ayuda'];
                unset($datos['dt_diversidad']['ayuda']);
            }          
        
            foreach ($datos['dt_diversidad'] as $id => $value) {
                $fields[] = $id;
                if (is_array($value) && !empty($value[0])) {
                    $values[] = $value[0];
                } else {
                    $values[] = "'" . $value . "'";
                }
            }
            // Alimentcion
            $campos       = implode(',', $fields);
            $valores      = implode(',', $values);
            
            $sql_dd = "DELETE FROM dt_diversidad WHERE cedula_estudiante = $cedula;";
            $this->ejecutar($sql_dd);
            
            $sql_ddi = "INSERT INTO dt_diversidad({$campos})VALUES ({$valores});";
            $resul_di = $this->ejecutar($sql_ddi);
   
            // Diversidad Funcional
            $sql_dtec = "DELETE FROM dt_diversidad_funcional WHERE cedula_estudiante = $cedula;";
            $this->ejecutar($sql_dtec);
            
            if (isset($diversidad)) {
                foreach ($diversidad as $valores) {
                    $sql_tec = "INSERT INTO dt_diversidad_funcional(cedula_estudiante,id_diversidad)VALUES($cedula,$valores);";
                    $this->ejecutar($sql_tec);
                }
            }
            
            // Enfermedades
            $sql_dten = "DELETE FROM dt_enfermedad WHERE cedula_estudiante = $cedula;";
            $this->ejecutar($sql_dten);
            
            if (isset($enfermedad)) {
                foreach ($enfermedad as $valores) {
                    $sql_tec = "INSERT INTO dt_enfermedad(cedula_estudiante,id_enfermedades)VALUES($cedula,$valores);";
                    $this->ejecutar($sql_tec);
                }
            }
            
            // Servicios 
            $sql_dtse = "DELETE FROM dt_servicio WHERE cedula_estudiante = $cedula;";
            $this->ejecutar($sql_dtse);
            
            if (isset($servicio)) {
                foreach ($servicio as $valores) {
                    $sql_tec = "INSERT INTO dt_servicio(cedula_estudiante,id_servicio)VALUES($cedula,$valores);";
                    $this->ejecutar($sql_tec);
                }
            }

            // Destreza 
            $sql_dtde = "DELETE FROM dt_destreza WHERE cedula_estudiante = $cedula;";
            $this->ejecutar($sql_dtde);
            
            if (isset($destreza)) {
                foreach ($destreza as $valores) {
                    $sql_tec = "INSERT INTO dt_destreza(cedula_estudiante,id_destreza)VALUES($cedula,$valores);";
                    $this->ejecutar($sql_tec);
                }
            }
            
            // Ayuda
            $sql_dtay = "DELETE FROM dt_ayuda WHERE cedula_estudiante = $cedula;";
            $this->ejecutar($sql_dtay);
            
            if (isset($ayuda)) {
                foreach ($ayuda as $valores) {
                    $sql_tec = "INSERT INTO dt_ayuda(cedula_estudiante,id_ayuda)VALUES($cedula,$valores);";
                    $this->ejecutar($sql_tec);
                }
            }
            
            if($resul_di){
                $sql = "UPDATE inscripcion SET paso4 = 1 WHERE cedula_estudiante = '$cedula';";
                $result_del = $this->ejecutar($sql);
                echo 1;
            }
        }
    }

    public function searchDG($datos)
    {
        $cedula        = $datos['cedula_estudiante'];
        
        $sql_ins['sql'] = "SELECT 
                                IFNULL(i.paso1,0) AS paso1,
				IFNULL(i.paso2,0) AS paso2,
				IFNULL(i.paso3,0) AS paso3,
				IFNULL(i.paso4,0) AS paso4
                               FROM inscripcion AS i 
                               WHERE i.cedula_estudiante=$cedula";
        
        
        $result_insc  = $this->datos($sql_ins);
        $pas1 = (boolean)$result_insc[0]['paso1'];
        $pas2 = (boolean)$result_insc[0]['paso2'];
        $pas3 = (boolean)$result_insc[0]['paso3'];
        $pas4 = (boolean)$result_insc[0]['paso4'];
        
        $datos = "";
        // Paso 1
        if ($pas1 == TRUE) {
            $datos = '1//';
            $sql_re['sql'] = "SELECT * FROM dt_padres WHERE cedula_estudiante=$cedula";
            $total         = $this->numero_filas($sql_re['sql']);
                        
            if ($total > 0) {

                // Datos Padres Madres 
                $result_rep   = $this->datos($sql_re);
                $padres_f     = $result_rep[0]['padre_f'] . ';' . $result_rep[0]['madre_f'];
                $padres_pl    = $result_rep[0]['padre_pl'] . ';' . $result_rep[0]['madre_pl'];
                $padres_al    = $result_rep[0]['padre_al'] . ';' . $result_rep[0]['madre_al'] . ';' . $result_rep[0]['represent_al'];
                $padres_fd    = $result_rep[0]['padre_fd'] . ';' . $result_rep[0]['madre_fd'] . ';' . $result_rep[0]['represent_al'];
                $padres_alf   = $result_rep[0]['padre_alf'] . ';' . $result_rep[0]['madre_alf'] . ';' . $result_rep[0]['represent_alf'];
                $padres_nivel = $result_rep[0]['padre_nivel'] . ';' . $result_rep[0]['madre_nivel'] . ';' . $result_rep[0]['represent_nivel'];
                $padres_set   = $result_rep[0]['padre_set'] . ';' . $result_rep[0]['madre_set'];
                $padres_see   = $result_rep[0]['padre_see'] . ';' . $result_rep[0]['madre_see'];

                $datos_rep = $padres_f . ';' . $padres_pl . ';' . $padres_al . ';' . $padres_fd . ';' . $padres_alf . ';' . $padres_nivel . ';' . $padres_set . ';' . $padres_see;
                $datos_p1     = $datos_rep;

                $sql_re['sql'] = "SELECT id_ingreso FROM dt_ingreso_familiar WHERE cedula_estudiante=$cedula";

                $result_if = $this->datos($sql_re);

                $total_if = $this->numero_filas($sql_re['sql']);
                $datos_in = "";
                if ($total_if > 0) {

                    for ($i = 0; $i < count($result_if); $i++) {
                        $datos_in .= $result_if[$i]['id_ingreso'] . ",";
                    }
                    $datos_in = substr($datos_in, 0, -1);
                }
                $datos = $datos.$datos_p1 . ';' . $datos_in.'##';
            }
            
        }else{
            $datos = '0//##';        
        }
        
        // Datos Misiones y Programas Sociales
        
        if($pas2 == TRUE){
            $datos = $datos.'2//';
            
            $sql_ps['sql'] = "SELECT id_programa FROM dt_programa_social WHERE cedula_estudiante=$cedula";
            
            $result_ps  = $this->datos($sql_ps);

            $total_ps   = $this->numero_filas($sql_ps['sql']);
            $datos_ps   = "";
            if($total_ps > 0){
                
                for ($i = 0; $i < count($result_ps); $i++) {
                    $datos_ps .= $result_ps[$i]['id_programa'].",";
                }
                $datos_ps = substr($datos_ps, 0, -1);
            }
            $datos = $datos.$datos_ps.'##';
        }else{
            $datos = $datos.'0//##';
        }
        
        // Datos Vivienda
        if($pas3 == TRUE){
            
            $datos = $datos.'3//';
            
            $sql_dv['sql'] = "SELECT ubicacion_vivienda,tipo_vivienda,estado_vivienda,cant_habitacion,cama FROM dt_vivienda WHERE cedula_estudiante=$cedula";
            $total_dv = $this->numero_filas($sql_dv['sql']);
            //$datos_dv = $total_dv;
            if ($total_dv > 0) {
                $result_dv   = $this->datos($sql_dv);
                $datos_vi     = $result_dv[0]['ubicacion_vivienda'] . ';' . $result_dv[0]['tipo_vivienda'].';'.$result_dv[0]['estado_vivienda'].';'.$result_dv[0]['cant_habitacion'].';'.$result_dv[0]['cama'];
            }
            
            $datos = $datos.$datos_vi;
            
            // Datos Tecnologicos
            
            $sql_tec['sql'] = "SELECT id_tecnologia FROM dt_tecnologia WHERE cedula_estudiante=$cedula";
            
            $result_tec  = $this->datos($sql_tec);

            $total_tec   = $this->numero_filas($sql_tec['sql']);
            $datos_tec   = "";
            if($total_tec > 0){
                
                for ($i = 0; $i < count($result_tec); $i++) {
                    $datos_tec .= $result_tec[$i]['id_tecnologia'].",";
                }
                $datos_tec = substr($datos_tec, 0, -1);
            }
            $datos = $datos.';'.$datos_tec.'##';
            
        }else{
            $datos = $datos.'0//##';
        }
        
        // Diversidad Funcional
        if($pas4 == TRUE){
            $datos = $datos.'4//';
            // Diversidad Funcional
            
            $sql_df['sql'] = "SELECT id_diversidad FROM dt_diversidad_funcional WHERE cedula_estudiante=$cedula";
            
            $result_df  = $this->datos($sql_df);

            $total_df   = $this->numero_filas($sql_df['sql']);
            $datos_df   = "";
            if($total_df > 0){
                
                for ($i = 0; $i < count($result_df); $i++) {
                    $datos_df .= $result_df[$i]['id_diversidad'].",";
                }
                $datos_df = substr($datos_df, 0, -1);
            }
            
            $datos = $datos.$datos_df;
            
            // Datos Enfermedades
            
            $sql_de['sql'] = "SELECT id_enfermedades FROM dt_enfermedad WHERE cedula_estudiante=$cedula";
            
            $result_de  = $this->datos($sql_de);

            $total_de   = $this->numero_filas($sql_de['sql']);
            $datos_de   = "";
            if($total_de > 0){
                
                for ($i = 0; $i < count($result_de); $i++) {
                    $datos_de .= $result_de[$i]['id_enfermedades'].",";
                }
                $datos_de = substr($datos_de, 0, -1);
            }
            
            $datos = $datos.';'.$datos_de;
            
            
            // Datos Servicios
            
            $sql_ds['sql'] = "SELECT id_servicio FROM dt_servicio WHERE cedula_estudiante=$cedula";
            
            $result_ds  = $this->datos($sql_ds);

            $total_ds   = $this->numero_filas($sql_ds['sql']);
            $datos_ds   = "";
            if($total_ds > 0){
                
                for ($i = 0; $i < count($result_ds); $i++) {
                    $datos_ds .= $result_ds[$i]['id_servicio'].",";
                }
                $datos_ds = substr($datos_ds, 0, -1);
            }
            
            $datos = $datos.';'.$datos_ds;
            
            
            // Datos Destreza
            
            $sql_des['sql'] = "SELECT id_destreza FROM dt_destreza WHERE cedula_estudiante=$cedula";
            
            $result_des  = $this->datos($sql_des);

            $total_des   = $this->numero_filas($sql_des['sql']);
            $datos_des   = "";
            if($total_des > 0){
                
                for ($i = 0; $i < count($result_des); $i++) {
                    $datos_des .= $result_des[$i]['id_destreza'].",";
                }
                $datos_des = substr($datos_des, 0, -1);
            }
            
            $datos = $datos.';'.$datos_des;
            
            
            // Datos Alimentacion
            $sql_da['sql'] = "SELECT alimentacion,alimentacion_regular FROM dt_diversidad WHERE cedula_estudiante=$cedula";
            $total_da = $this->numero_filas($sql_da['sql']);
            $datos_va = '';
            if ($total_da > 0) {
                $result_da   = $this->datos($sql_da);
                $datos_va     = $result_da[0]['alimentacion'] . ';' . $result_da[0]['alimentacion_regular'];
            }
            
            $datos = $datos.';'.$datos_va;
            
            // Datos Ayuda
            
            $sql_day['sql'] = "SELECT id_ayuda FROM dt_ayuda WHERE cedula_estudiante=$cedula";
            
            $result_day  = $this->datos($sql_day);

            $total_day   = $this->numero_filas($sql_day['sql']);
            $datos_day   = "";
            if($total_day > 0){
                
                for ($i = 0; $i < count($result_day); $i++) {
                    $datos_day .= $result_day[$i]['id_ayuda'].",";
                }
                $datos_day = substr($datos_day, 0, -1);
            }
            
            $datos = $datos.';'.$datos_day;
            
        }else{
            $datos = $datos.'0//';
        }
        
        echo $datos;
    }
}
