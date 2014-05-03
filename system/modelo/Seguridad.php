<?php

$path = dirname(__FILE__);
require_once "$path/Conexion.php";

class Seguridad extends Conexion
{

    public function __construct()
    {
        
    }

    public function codTelefono($where = 1)
    {
        $where     = ' WHERE ' . $where;
        $sql       = "SELECT id,codigo FROM codigo_telefono " . $where;
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    /*     * *Lo puso Yergi** */

    public function formateaBD($fecha)
    {
        $fechaesp      = preg_split('/[\/-]+/', $fecha);
        $revertirfecha = array_reverse($fechaesp);
        $fechabd       = implode('-', $revertirfecha);
        return $fechabd;
    }

    /*     * Lo puso yergi* */

    public function grupoUsuario($where = 1)
    {
        $where     = ' WHERE ' . $where;
        $sql       = "SELECT id_grupo, nombre_grupo FROM grupo_usuario " . $where;
        $resultado = $this->consultar_array($sql);
        return $resultado;
    }

    public function codNacionalidad($where = 1)
    {
        $where = ' WHERE ' . $where;
        $sql   = "SELECT  id_nacionalidad, nombre FROM nacionalidad" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    } 
    
    public function sexo($where = 1)
    {
        $where = ' WHERE ' . $where;
        $sql   = "SELECT  id_sexo,  sexo FROM sexo" . $where;

        $resultado = $this->consultar_array($sql);
        return $resultado;
    }
    
    protected function Login($datos)
    {
        session_start();
        $usuario = $datos['usuario'];
        $clave   = $datos['contrasena'];
        $sql   = "SELECT  u.id_usuario,u.id_grupo,CONCAT_WS(' ',u.nombre,u.apellido) AS nombres FROM usuario AS u WHERE usuario='$usuario' AND contrasena=MD5('$clave')";
        $tot = $this->numero_filas($sql);
        if($tot > 0){
            $resultado = $this->consultar_array($sql);
            $_SESSION['id_usuario'] = $resultado[0]['id_usuario'];
            $_SESSION['id_grupo']   = $resultado[0]['id_grupo'];
            $_SESSION['nombres']    = $resultado[0]['nombres'];
        return $tot;
        }else{
            return FALSE;
        }
        
    }
    
    public function Logout()
    {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("location:../../");
        } else {
            session_unset();
            session_destroy();
            sleep(1);
            header("location:../../");
        }
    }

}
