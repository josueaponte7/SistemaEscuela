<?php
class Sesion
{
    private function __construct()
    {

    }

    private function __wakeup()
    {

    }

    public static function crear()
    {
        if (!(self::$_instancia instanceof self)) {
            self::$_instancia = new self();
        }
        return self::$_instancia;
    }
    
    protected function cerrarSesion()
    {
        $_SESSION = array();
        if (file_exists('session.txt')) {
            unlink('session.txt');
        }
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado
        header("location:admin.php"); // Fecha en el pasado
    }

    private function _validarSession($date)
    {
        date_default_timezone_set('America/Caracas');
        $fecha_i = $date;
        $fecha_f = date('Y-m-d H:i');

        $fecha1  = new DateTime($fecha_i);
        $fecha2  = new DateTime($fecha_f);
        $fecha   = $fecha1->diff($fecha2);
        $archivo = "session.txt";
       
        if ($fecha->y == 0 && $fecha->m == 0 && $fecha->d == 0 && $fecha->h == 0 && $fecha->i >= 20 && $fecha->i < 30) {
            $date_session  = date("Y-m-d H:i");
            $texto         = file($archivo);
            $ar_id_session = $texto[1];
            if ($ar_id_session === $_SESSION['id_session']) {
                $session_id               = uniqid(hash("ripemd160", rand()));
                $session                  = $date_session . "\n" . $session_id;
                $fp                       = fopen($archivo, "w");
                fwrite($fp, $session);
                fclose($fp);
                $_SESSION['id_session']   = $session_id;
                $_SESSION['date_session'] = $date_session;
                $_SESSION['id_usuario']   = 999;
            }else{
                unlink('session.txt');
                header("Cache-Control: no-cache, must-revalidate"); 
                header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
                header("location:admin.php");
            }
        }if ($fecha->y > 0 || $fecha->m > 0 || $fecha->d > 0 || $fecha->h > 0 || $fecha->i >= 30) {
            unlink('session.txt');
            header("Cache-Control: no-cache, must-revalidate"); 
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
            header("location:admin.php"); 
        }
    }
    protected function valSession($date)
    {
        $this->_validarSession($date);
    }
}
    