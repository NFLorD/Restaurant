<?php 

class DB
{
    protected static $pdo;

    public static function getPDO()
    {
        if (empty(self::$pdo)) {
            self::$pdo = new PDO(
                "mysql:host=localhost;dbname=restaurant;charset=utf8",
                "root",
                "troiswa",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        return self::$pdo;
    }
}

?>