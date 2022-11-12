<?php

class BD
{
    public static function conexion()
    {
        try {
            return new PDO("mysql:host=localhost;dbname=registro_de_notas", "root", "");
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
