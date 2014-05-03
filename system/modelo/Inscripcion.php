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
            if ($tiempo == 0) {
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
                            WHERE er.representante=1 AND er.cedula_estudiante=$cedula[1]";
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
        $datos = $result_anio.';'.$resultado[0]['cedula'] . ';' . $resultado[0]['nombre'] . ';' . $resultado[0]['apellido'] . ';' . $parentesco . ';' . $id_tipo . ';' . $tipo.';'.$dat_extra;
        return $datos;
    }

}
