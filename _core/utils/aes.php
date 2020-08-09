<?php

class AES
{
    private static $clave = "bf3c199c2470cb477d907b1e0917c17b";
    private static $method = "aes-256-cbc";
    private static $iv = "5183666c72eec9e4";

    public static function Encriptar($string)
    {
        $clave  = self::$clave;
        $method = self::$method;
        $iv = self::$iv;

        $key = openssl_encrypt ($string, $method, $clave, false, $iv);
        return $key;
    }

    public static function Desencriptar($key)
    {
        $clave  = self::$clave;
        $method = self::$method;
        $iv = self::$iv;
        
        $string = openssl_decrypt($key, $method, $clave, false, $iv);

        return $string;
    }
}