<?php

$path = dirname(__FILE__);
require_once "$path/Seguridad.php";

class Estudiante extends Seguridad
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
        $id_estatus   = $datos['id_estatus'];
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
        $fech_naci    = $this->formateaBD($fech_naci);


        $condicion = "cedula = '$cedula' AND nacionalidad = $nacionalidad";
        $total     = $this->totalFilas('estudiante', 'cedula', $condicion);
        if ($total > 0) {
            $resultado = 13;
        } else {
       $sql = "INSERT INTO estudiante(nacionalidad,cedula, nombre, apellido, email, fech_naci, lugar_naci, sexo, id_parroquia, calle, casa, edificio,
                                       barrio, cod_telefono, telefono, cod_celular, celular,id_estatus)
                     VALUES ('$nacionalidad','$cedula', '$nombre', '$apellido', '$email', '$fech_naci', '$lugar_naci', '$sexo', '$id_parroquia', '$calle',
                             '$casa', '$edificio', '$barrio', '$cod_telefono', '$telefono', '$cod_celular', '$celular',$id_estatus);";

            $resultado = $this->ejecutar($sql);
            if ($resultado === TRUE) {
                $representantes = explode(",", $datos['representantes']);
                for ($i = 0; $i < count($representantes); $i++) {
                    $datos_repre = explode(";", $representantes[$i]);

                   $sql = "INSERT INTO estudiante_representante(cedula_estudiante,cedula_representante,parentesco,representante)
                              VALUES ($cedula,$datos_repre[0],$datos_repre[1],$datos_repre[2]);";
          
                    $this->ejecutar($sql);
                }
            }
        }
        return $resultado;
    }

    public function UpRepre($datos)
    {
        $cedula               = $datos['cedula'];
        $cedula_representante = $datos['cedula_representante'];


        $sql       = "UPDATE estudiante_representante SET representante = 0 WHERE cedula_estudiante=$cedula;";
        $resultado = $this->ejecutar($sql);

        if ($resultado) {
            $sql1       = "UPDATE estudiante_representante SET representante = 1 WHERE cedula_estudiante=$cedula AND cedula_representante=$cedula_representante;";
            $resultado1 = $this->ejecutar($sql1);
        }

        return $resultado1;
    }

    /*     * *Para llamar al estudiante y montarlo en el select con los datos completos*** */

    public function getEstudianterepre($opciones = array())
    {
        if (empty($opciones['sql'])) {
            $default  = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
            $opciones = array_merge($default, $opciones);
            $sql      = "SELECT {$opciones['campos']} FROM estudiante_representante AS er WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']} ";
        } else {
            $sql = $opciones['sql'];
        }

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function datos($opciones = array())
    {
        if (empty($opciones['sql'])) {
            $default    = array('campos' => '*', 'condicion' => '1', 'ordenar' => '1', 'limite' => 200);
            $opciones   = array_merge($default, $opciones);
            $this->_sql = "SELECT {$opciones['campos']} FROM estudiante AS es WHERE {$opciones['condicion']} ORDER BY {$opciones['ordenar']} LIMIT {$opciones['limite']}";
        } else {
            $this->_sql = $opciones['sql'];
        }
        $resultado = $this->consultar_array($this->_sql);
        return $resultado;
    }
    
    public function getEstudiante($datos)
    {
        $cedula = $datos['cedula'];

        $sql_es['sql'] = "SELECT
                            e.nacionalidad,
                            e.cedula,
                            e.nombre,
                            e.apellido,
                            e.email,
                            DATE_FORMAT(e.fech_naci,'%d/%m/%Y') AS fech_naci,
                            DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(e.fech_naci)), '%Y')+0 AS edad,
                            e.lugar_naci,
                            e.sexo,
                            e.calle,
                            e.casa,
                            edificio,
                            e.barrio,
                            e.cod_telefono,
                            e.telefono, 
                            e.cod_celular, 
                            e.celular,
                            m.id_estado,  
                            p.id_municipio,
                            e.id_parroquia,
                            e.id_estatus
                          FROM estudiante AS e
                          INNER JOIN parroquia AS p ON e.id_parroquia = p.id_parroquia
                          INNER JOIN municipio AS m ON p.id_municipio = m.id_municipio
                          WHERE cedula=$cedula";
        $result = $this->datos($sql_es);
        $da= $result[0];
        $dat =   $da['nacionalidad'].';'
                .$da['nombre'].';'
                .$da['apellido'].';'
                .$da['sexo'].';'
                .$da['fech_naci'].';'
                .$da['edad'].';'
                .$da['cod_telefono'].';'
                .$da['telefono'].';'
                .$da['cod_celular'].';'
                .$da['celular'].';'
                .$da['email'].';'
                .$da['id_estatus'].';'
                .$da['lugar_naci'].';'
                .$da['id_estado'].';'
                .$da['id_municipio'].';'
                .$da['id_parroquia'].';'
                .$da['calle'].';'
                .$da['casa'].';'
                .$da['edificio'].';'                
                .$da['barrio'];
                
        return $dat;
    }
    
    public function getRepresentante($datos)
    {
        $cedula = $datos['cedula'];
        
        $sql_es = "SELECT
                            er.cedula_representante,
                            CONCAT_WS(' ',r.nombre,r.apellido) AS nombres,
                            IF(r.cod_telefono='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = r.cod_telefono),r.telefono)) AS telefono, 
                            IF(r.cod_celular='',0,CONCAT_WS('-' ,(SELECT codigo FROM codigo_telefono WHERE id = r.cod_celular),r.celular)) AS celular,
                            er.parentesco,
                            er.representante
                          FROM estudiante_representante AS er
                          INNER JOIN representante AS r ON er.cedula_representante=r.cedula
                          WHERE er.cedula_estudiante = $cedula";
        $result_re = $this->consultar_array($sql_es);
        for ($i = 0; $i < count($result_re); $i++) {
            
            
            $telefono = $result_re[$i]['telefono'];
            $celular  = $result_re[$i]['celular'];

            if($telefono != 0 && $celular == 0){
                $telefonos =$telefono;
            }else if($celular != 0 && $telefono == 0){
                $telefonos = $celular;
            }else if($telefono != 0 && $celular != 0){
                $telefonos = $telefono.','.$celular;
            }
            
            switch ($result_re[$i]['parentesco']) {
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
            
            
            
            $datos_re[] = array(
                'cedula'        => $result_re[$i]['cedula_representante'],
                'nombres'       => $result_re[$i]['nombres'],
                'telefonos'     => $telefonos,
                'id_parentesco' => $result_re[$i]['parentesco'],
                'parentesco'    => $parentesco,
                'representante' => $result_re[$i]['representante']
            );
        }
        
        return json_encode($datos_re);
    }
    
    public function update($datos)
    {
        
        $cedula       = $datos['cedula'];
        $nombre       = $datos['nombre'];
        $apellido     = $datos['apellido'];
        $email        = $datos['email'];
        $id_estatus   = $datos['id_estatus'];
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
        $fech_naci    = $this->formateaBD($fech_naci);
        
        $sql = "UPDATE estudiante
                SET
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
                    id_estatus = '$id_estatus'
                WHERE cedula=$cedula;";

        $resultado = $this->ejecutar($sql);
            if ($resultado === TRUE) {
                $representantes = explode(",", $datos['representantes']);
                $sql_del = "DELETE FROM estudiante_representante WHERE cedula_estudiante=$cedula;";
                $this->ejecutar($sql_del);
                for ($i = 0; $i < count($representantes); $i++) {
                    $datos_repre = explode(";", $representantes[$i]);

                    $sql = "INSERT INTO estudiante_representante(cedula_estudiante,cedula_representante,parentesco,representante)
                              VALUES ($cedula,$datos_repre[0],$datos_repre[1],$datos_repre[2]);";
                    $this->ejecutar($sql);
                }
            }
        
        return $resultado;
    }
    
    public function delete($datos)
    {

        $dat_cedula = explode('-', $datos['cedula']);
        $cedula     = $dat_cedula[1];

        $sql = "UPDATE estudiante SET  condicion = 0 WHERE cedula = $cedula;";

        $resultado = $this->ejecutar($sql);
        return $resultado;
    }

}
