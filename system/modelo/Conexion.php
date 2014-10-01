<?php

class Conexion {

    private static $_server   = 'localhost';
    private static $_user     = 'root';
    private static $_password = '123456';
    protected $bd             = 'sis_escuela';
    private $_sql             = '';
    private $_state_conn      = FALSE;

    private function __construct() {
        
    }

    private function __wakeup() {
        
    }

    public static function crear() {
        if (!(self::$_instancia instanceof self)) {
            self::$_instancia = new self();
        }
        return self::$_instancia;
    }

    private function _abrir_conn() {
        // conectarse a mysql
        $this->_conn = new mysqli(self::$_server, self::$_user, self::$_password, $this->bd);
        // verificar error
        if ((int) $this->_conn->connect_errno == 0) {
            $this->_state_conn = TRUE;
            $this->_conn->set_charset('utf8');
            return $this->_conn;
        }
    }

    private function _query() {
        $this->_abrir_conn();
        if ($this->_state_conn === TRUE) {
            // query de mysqlli
            $resultado = $this->_conn->query($this->_sql);
            if($resultado){
                return $resultado;
            }else{
                return FALSE;
            }
        }
        $this->_cerrar_conn(); 
    }
    
    
    public function last($table = NULL, $campo = 1,$conditions = '1')
    {

        if ($table === NULL) {
            return FALSE;
        } else {
   
            $resultado = FALSE;
            $this->_sql = "SELECT $campo FROM $table WHERE $conditions ORDER BY 1 DESC LIMIT 1";
            $this->_state_query = $this->_query();
            if ($this->_state_query->num_rows > 0) {
                $this->_state_query->data_seek($this->_state_query->num_rows -1);
                $row = $this->_state_query->fetch_row();
                $this->_state_query->free();
                $resultado = $row;
            }
            $this->_cerrar_conn();
            return $resultado;
        }
    }
    
    
    public function get($table = NULL, $campo = 1,$conditions = '1')
    {

        if ($table === NULL) {
            return FALSE;
        } else {
   
            $resultado  = FALSE;
            $this->_sql = "SELECT $campo FROM $table WHERE $conditions ORDER BY 1 DESC LIMIT 1";
            
            $this->_state_query = $this->_query();
            if ($this->_state_query->num_rows > 0) {
                $this->_state_query->data_seek($this->_state_query->num_rows -1);
                $row = $this->_state_query->fetch_row();
                $this->_state_query->free();
                $resultado = $row[0];
            }
            $this->_cerrar_conn();
            return $resultado;
        }
    }
    
    public function totalFilas($table = NULL, $field = NULL, $conditions = '1')
    {
        if ($table === NULL || $field === NULL) {
            return FALSE;
        } else {
            $resultado = 0;
            $this->_sql       = "SELECT $field FROM $table WHERE $conditions ORDER BY 1 DESC LIMIT 200";
            $this->_query();
            $this->_state_query = $this->_conn->query($this->_sql );
            if ($this->_state_conn && $this->_state_query && $this->_state_query->num_rows > 0) {
                $resultado = $this->_state_query->num_rows;
                $this->_state_query->free();
            }
            $this->_cerrar_conn();
            return $resultado;
        }
    }
    private function _consulta_array() {
        $resultado = $this->_query();
        if ($this->_state_conn === TRUE) {
            // query de mysqlli
            $count = $this->_numero_filas();
            if($count > 0){
            while ($row = $resultado->fetch_array()) {
                $rows[] = $row;
            }
            return $rows;
            }else{
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    private function _numero_filas() {
        $resultado = $this->_query();
        if ($this->_state_conn === TRUE) {
            $row_cnt   = $resultado->num_rows;
            if ($row_cnt > 0) {
                return $row_cnt;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    protected function numero_filas($sql){
         $this->_sql = $sql;
         $resultado = $this->_numero_filas();
         return $resultado;
    }
    protected function consultar_array($sql) {
        $this->_sql = $sql;
        $resultado = $this->_consulta_array(); 
        return $resultado;
    }
    
    protected function ejecutar($sql) {
        $this->_sql = $sql;
        $resultado = $this->_query();
        if($resultado === TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }
     
    private function _cerrar_conn() {
        $this->_conn->close();
    }   
}
