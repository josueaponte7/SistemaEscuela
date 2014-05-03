<?php

class SecurLoginHashing
{
    protected $salt = 'M@t3rN1d@D';
    protected $iterations = 2;
    protected $algorithms = array();
    public function __construct($iterations = 2, $algorithms = array('sha512', 'ripemd320', 'whirlpool'))
    {
        $this->iterations = $iterations;
        $this->algorithms = $algorithms;
    }
    public function hash($toHash, $user_salt)
    {
        return self::staticHash($toHash, $user_salt, $this->salt, $this->iterations, $this->algorithms);
    }

    public static function staticHash($toHash, $user_salt, $salt, $iterations = 2, $algorithms = array('sha512', 'ripemd320', 'whirlpool'))
    {
        $i = 0;
        do {
          
            $toHash   = $user_salt . $toHash . $salt;
            $tempHash = '';
            foreach ($algorithms as $algo) {
                $tempHash .= hash($algo, $toHash);
            }
            $toHash = hash($algo, $tempHash);
            $i++;
        } while ($i < $iterations);

        return $toHash;
    }

}
